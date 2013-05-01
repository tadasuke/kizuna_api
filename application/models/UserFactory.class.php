<?php

require_once 'User.class.php';

/**
 * ユーザオブジェクト作成クラス
 * @author tadasuke
 */
class UserFactory {
	
	/**
	 * ユーザオブジェクト配列
	 * @var array[User]
	 */
	private static $userObjArray = array();
	
	/**
	 * ユーザオブジェクト作成
	 * @param int $userNum
	 * @return User
	 */
	public static function get( $userNum ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:' . $userNum );
		
		if ( isset( self::$userObjArray[$userNum] ) === FALSE ) {
			self::$userObjArray[$userNum] = new User( $userNum );
		} else {
			;
		}
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );

		return self::$userObjArray[$userNum];
		
	}
	
	
}