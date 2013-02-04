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
	 * @param int $userId
	 * @return User
	 */
	public static function get( $userId ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userId:' . $userId );
		
		if ( isset( self::$userObjArray[$userId] ) === FALSE ) {
			self::$userObjArray[$userId] = new User( $userId );
		} else {
			;
		}
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );

		return self::$userObjArray[$userId];
		
	}
	
	
}