<?php

/**
 * 新規登録コントローラ
 * @author y-suzuki
 */
class RegistController extends KizunaBaseController {
	
	const TEMP_SUBJECT		= 'kizun＜仮登録＞メール';
	const CONFIRM_URL		= 'http://api.ki2na.madfaction.net/regist/confirm?tempkey=';
	const FROM_ADDRESS		= 'From: ki2na';
	const REGIST_MESSAGE 	= 'kizunaへの登録が完了しました！kizunaライフを存分にお楽しみください！';
	const REGIST_SUBJECT	= 'kizun登録完了のお知らせ';
	const FINISH_URL		= 'Location: http://ki2na.jp/top/index';
	const FINISH_ERROR_URL		= 'Location: http://ki2na.jp/top/index';
	
	const REGIST_COMPLETE 	= '0';
	const REGIST_ERROR 		= '1';
	
	const SEND_MAIL_OK		= '0';
	const SEND_MAIL_ERROR	= '1';
	
	
	/**
	 * テスト
	 */
	public function tempTestAction() {

		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );

		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		$this -> setResponseParam( array( 'result' => 0 ) );
		return;

	}
	

	/**
	 * 仮登録処理
	 */
	public function tempRegistAction() {

		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );

		$mailAddress = $this -> getGetAndPostParam( 'mail_address' );
		$password    = $this -> getGetAndPostParam( 'password' );
		$name        = $this -> getGetAndPostParam( 'name' );
		
		// ユーザ仮データ登録
		$result = User::newTempEntry( $mailAddress, $password, $name );
		
		// 登録エラーの場合
		if ( strcmp( $result, User::NEW_ENTRY_CHECK_NORMAL ) != 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'new_entry_error!!' );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
			$this -> setResponseParam( array( 'result' => $result ) );
			return;
		} else {
			;
		}
		
		// URL
		$url = self::CONFIRM_URL . User::$newUserKey;
		
		// メール本文
		$message = '[kizuna新規登録]' . "\r\n" . "\r\n" 
			. '下記URLへのアクセスで新規登録が完了します。' . "\r\n" 
			. $url;
		
		// 仮登録メール送信
		if ( mb_send_mail( 
			$mailAddress, 
			self::TEMP_SUBJECT, 
			$message, 
			self::FROM_ADDRESS	
		) ) {
			
			// メール送信成功
			$result = SELF::SEND_MAIL_OK;
			
		} else {
			
			$result = SELF::SEND_MAIL_ERROR;
			
			// TODO メール送信失敗時にはDBデータの削除が必要か検討
			
			// メール送信失敗
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'temp_regist_send_mail_error!!' );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
			$this -> setResponseParam( array( 'result' => $result ) );
			return;
			
		}

		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		$this -> setResponseParam( array( 'result' => $result ) );
		return;

	}


	/**
	 * 新規登録完了処理
	 */
	public function confirmAction() {

		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );

		// ユーザキー
		$userKey = $this -> getGetAndPostParam( 'tempkey' );
		
		// ユーザキーを元にデータを取得
		$userBasicDataObj = DataClassFactory::getUserBaslcDataObj();
		$valueArray = $userBasicDataObj -> getDataByUserKey( $userKey );
		
		// 該当データが無ければエラー
		if ( is_null( $valueArray ) === TRUE ) {
			
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'user_key_not_exist_error!!' );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
			$this -> setResponseParam( array( 'result' => self::REGIST_ERROR ) );
			
			header( self::FINISH_URL . '?error=' . self::REGIST_ERROR );
			
			return;
			
		} else {
			;
		}
		
		// 仮登録状態以外ならばエラー
		if ( strcmp( $valueArray[0]['status'], '0' ) != 0 ) {
			
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'already_registration_error!!' );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
			$this -> setResponseParam( array( 'result' => self::REGIST_ERROR ) );
			
			header( self::FINISH_URL . '?error=' . self::REGIST_ERROR );
			
			return;
			
		} else {
			;
		}

		// 本登録status更新
		$updateArray = array( 'status' => User::USER_STATUS_MENBER );
		$userBasicDataObj -> updateBasicData( $valueArray[0]['user_num'], $updateArray );

		// 登録完了メール
		mb_send_mail( $valueArray[0]['mail_address'], self::REGIST_SUBJECT, self::REGIST_MESSAGE, self::FROM_ADDRESS );

		// ログインクッキー設定
		$this -> setLoginCookie( User::$newUserKey, User::$newHashPassword );

		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		//$this -> setResponseParam( array( 'result' => self::REGIST_COMPLETE ) );
		
		header( self::FINISH_URL );

		return;

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

		$keyName   = AK_Config::getConfig( 'system_config', 'cookie_config', 'login_key_name' );
		$keepTime  = AK_Config::getConfig( 'system_config', 'cookie_config', 'keep_time' );
		$delimiter = AK_Config::getConfig( 'system_config', 'cookie_config', 'login_key_delimiter' );

		$cookieValue = $userKey . $delimiter . $hashPassword;
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'cookieValue:' . $cookieValue );

		setcookie( $keyName, $cookieValue, time() + $keepTime, '/' );

		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );

	}

}