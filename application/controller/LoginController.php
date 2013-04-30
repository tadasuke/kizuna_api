<?php

class LoginController extends KizunaBaseController {
	
	const LOGIN_COMPLETE = '0';
	const LOGIN_ERROR    = '1';
	
	
	/**
	 * 新規登録
	 */
	public function newEntryAction() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$mailAddress = $this -> getParam( 'mail_address' );
		$password    = $this -> getParam( 'password' );
		$name        = $this -> getParam( 'name' );
		
		// 新規登録
		$result = User::newEntry( $mailAddress, $password, $name );
		
		// 新規登録エラーの場合
		if ( strcmp( $result, User::NEW_ENTRY_CHECK_NORMAL ) != 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'new_entry_error!!' );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
			$this -> setResponseParam( array( 'result' => $result ) );
			return;
		} else {
			;
		}
		
		// ログインクッキー設定
		$this -> setLoginCookie( User::$newUserKey, User::$newHashPassword );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		$this -> setResponseParam( array( 'result' => $result ) );
		return;
		
	}
	
	
	/**
	 * ログイン
	 */
	public function loginAction() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$mailAddress = $this -> getGetParam( 'mail_address' );
		$password    = $this -> getGetParam( 'password' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'mailAddress:' . $mailAddress );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'password:'    . $password );
		
		// 登録済チェック
		$valueArray = User::getUserData( $mailAddress, $password );
		// 登録しているアドレス、パスワードが一致しなかった場合
		if ( count( $valueArray ) == 0 ) {
			// レスポンスパラメータ設定
			$this -> addResponseParam( 'result', self::LOGIN_ERROR );
			return;
		} else {
			;
		}
		
		// レスポンスパラメータ設定
		$this -> addResponseParam( 'result', self::LOGIN_COMPLETE );
		
		// ログインクッキーを設定
		$userKey  = $valueArray['user_key'];
		$hashPassword = $valueArray['password'];
		$this -> setLoginCookie( $userKey, $hashPassword );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	//------------------------------------ protected ------------------------------------
	
	/**
	 * ログイン確認処理
	 * 未ログイン時の処理なので必ずTRUEを返す
	 */
	protected function isLogin() {
		return TRUE;
	}
	
	
	//------------------------------------ private ------------------------------------
	
	/**
	 * ログインクッキー設定
	 * @param string $userKey
	 * @param string $hashPassword
	 */
	private function setLoginCookie( $userKey, $hashPassword ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userKey:'      . $userKey );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'hashPassword:' . $hashPassword );
		
		$keyName   = AK_Ini::getConfig( 'system_config', 'cookie_config', 'login_key_name' );
		$keepTime  = AK_Ini::getConfig( 'system_config', 'cookie_config', 'keep_time' );
		$delimiter = AK_Ini::getConfig( 'system_config', 'cookie_config', 'login_key_delimiter' );
		
		$cookieValue = $userKey . $delimiter . $hashPassword;
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'cookieValue:' . $cookieValue );
		
		setcookie( $keyName, $cookieValue, time() + $keepTime, '/' );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
}