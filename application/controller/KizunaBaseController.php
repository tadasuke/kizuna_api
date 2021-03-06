<?php

/**
 * 共通処理コントローラ
 * @author tadasuke
 */
class KizunaBaseController extends AK_BaseController {
	
	/**
	 * プレイユーザID
	 * @var int
	 */
	protected $playerUserNum = NULL;
	
	/**
	 * プレイユーザキー
	 * @var string
	 */
	protected $playerUserKey = NULL;
	
	/**
	 * 前処理
	 * @see AK_BaseController::beforeRun()
	 */
	public function beforeRun() {
		
		//-------------
		// ログ出力先設定
		//-------------
		AK_Log::setAkLoggingClass( AK_Config::getConfig( 'system_config', 'log_config', 'path' ), AK_Log::DEBUG );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		//--------------
		// デフォルト値設定
		//--------------
		// DBコミットフラグ
		AK_Registry::set( REGISTRY_DB_COMMIT_FLG_KEY_NAME, TRUE );
		// サーバエラーフラグ
		AK_Registry::set( REGISTRY_SERVER_ERROR_KEY_NAME, RESULT_NORMAL );
		
		//-----------
		// DB接続設定
		//-----------
		// TRUN
		$databaseName = AK_Config::getConfig( 'db_config', 'database_name' );
		$host         = AK_Config::getConfig( 'db_config', 'host' );
		$user         = AK_Config::getConfig( 'db_config', 'user' );
		$password     = AK_Config::getConfig( 'db_config', 'password' );
		$akDbConfig = new AK_DbConfig( $databaseName, $host, $user, $password );
		AK_DaoFactory::addDbConfig( $akDbConfig );
		// MASTER
		$databaseName = AK_Config::getConfig( 'master_db_config', 'database_name' );
		$host         = AK_Config::getConfig( 'master_db_config', 'host' );
		$user         = AK_Config::getConfig( 'master_db_config', 'user' );
		$password     = AK_Config::getConfig( 'master_db_config', 'password' );
		$akDbConfig = new AK_DbConfig( $databaseName, $host, $user, $password );
		AK_DaoFactory::addDbConfig( $akDbConfig, MASTER_DB_IDEMTIFICATION_NAME );
		
		//------------------
		// ログイン済みチェック
		//------------------
		$result = $this -> isLogin();
		if ( $result === FALSE ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'no_login_error!!' );
			AK_Registry::set( REGISTRY_ERROR_FLG_NAME, RESULT_LOGIN_ERROR );
			AK_Core::setExecActionFlg( FALSE );
			return;
		} else {
			;
		}
		
		//------------------
		// レスポンスタイプ設定
		//------------------
		if ( strcmp( $this -> getGetAndPostParam( 'response_type' ), 'jsonp' ) == 0 ) {
			$this -> setResponseType( self::RESPONSE_TYPE_JSONP );
		} else {
			;
		}
		
		//------------------------
		// リクエストパラメータログ出力
		//------------------------
		$paramArray = $this -> getAllParam();
		foreach ( $paramArray as $key => $value ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, $key . '=>' . $value );
		}
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	/**
	 * 後処理
	 * @see AK_BaseController::afterRun()
	 */
	public function afterRun() {
		
//		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		// DBコミット
		$daoArray = AK_DaoFactory::getAllDao();
		foreach ( $daoArray as $dao ) {
			$dao -> commit();
		}
		
		// レスポンスパラメータに値を追加
		$this -> addResponseParam( 'error_flg', AK_Registry::get( REGISTRY_SERVER_ERROR_KEY_NAME ) );
		$info = array();
		$info['id'] = AK_Log::getLogClass() -> getProcessId();
		$this -> addResponseParam( 'info', $info );
		
//		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
	}
	
	//----------------------------------- proteced -------------------------------
	
	/**
	 * ログインチェック
	 * @param string $userId
	 * @return boolean
	 */
	protected function isLogin() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		// クッキー名取得
		$loginKeyName = AK_Config::getConfig( 'system_config', 'cookie_config', 'login_key_name' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'loginKeyName:' . $loginKeyName );
		// クッキー取得
		$loginKey = (isset( $_COOKIE[$loginKeyName] ) === TRUE) ? $_COOKIE[$loginKeyName] : '';
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'loginKey:' . $loginKey );
		
		// クッキーが取得できなかった場合
		if ( strlen( $loginKey ) == 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'no_cookie!!' );
			return FALSE;
		} else {
			;
		}
		
		//-----------------------------------
		// クッキーから、ユーザキー、パスワードを抽出
		//-----------------------------------
		$array = explode( AK_Config::getConfig( 'system_config', 'cookie_config', 'login_key_delimiter' ), $loginKey );
		$userKey  = $array[0];
		$password = $array[1];
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userKey:'  . $userKey );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'password:' . $password );
		
		//----------------------------
		// ユーザキーを元にDBからデータ取得
		//----------------------------
		$valueArray = DataClassFactory::getUserBaslcDataObj() -> getDataByUserKey( $userKey );
		
		// ユーザキーエラー
		if ( count( $valueArray ) == 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'user_key_error!!' );
			return FALSE;
		} else {
			;
		}
		
		// パスワードエラー
		if ( strcmp( $password, $valueArray[0]['password'] ) != 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'password_error!!' );
			return FALSE;
		} else {
			;
		}
		
		// ユーザデータ設定
		$this -> playerUserNum  = $valueArray[0]['user_num'];
		$this -> playerUserKey = $userKey;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return TRUE;
	}
	
}