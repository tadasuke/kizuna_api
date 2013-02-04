<?php

class IndexController extends KizunaBaseController {
	
	const LOGIN_COMPLETE = '0';
	const LOGIN_ERROR    = '1';
	
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
		
		// クッキーにログインキーをセット
		$userKey  = $valueArray['user_key'];
		$password = $valueArray['password'];
		$keyName   = AK_Ini::getConfig( 'system_config', 'cookie_config', 'login_key_name' );
		$keepTime  = AK_Ini::getConfig( 'system_config', 'cookie_config', 'keep_time' );
		$delimiter = AK_Ini::getConfig( 'system_config', 'cookie_config', 'login_key_delimiter' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'keyName:'   . $keyName );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'keepTime:'  . $keepTime );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'delimiter:' . $delimiter );
		setcookie( $keyName, $userKey . $delimiter . $password, time() + $keepTime, '/' );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	/**
	 * ログイン確認処理
	 * 未ログイン時の処理なので必ずTRUEを返す
	 */
	protected function isLogin() {
		return TRUE;
	}
	
}