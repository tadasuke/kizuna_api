<?php

abstract class DataClassFactory {
	
	/**
	 * ユーザ基本データ
	 * @var UserBasicData
	 */
	private static $userBasicDataObj = NULL;
	public static function getUserBaslcDataObj() {
		if ( is_null( self::$userBasicDataObj ) === TRUE ) {
			require_once 'UserBasicData.class.php';
			self::$userBasicDataObj = new UserBasicData();
		} else {
			;
		}
		return self::$userBasicDataObj;
	}
	
	/**
	 * ユーザパーソナルデータ
	 * @var UserPersonalData
	 */
	private static $userPersonalDataObj = NULL;
	public static function getUserPersonalDataObj() {
		if ( is_null( self::$userPersonalDataObj ) === TRUE ) {
			require_once 'UserPersonalData.class.php';
			self::$userPersonalDataObj = new UserPersonalData();
		} else {
			;
		}
		return self::$userPersonalDataObj;
	}
	
	/**
	 * トークデータ
	 * @var TalkData
	 */
	private static $talkDataObj = NULL;
	public static function getTalkDataObj() {
		if ( is_null( self::$talkDataObj ) === TRUE ) {
			require_once 'TalkData.class.php';
			self::$talkDataObj = new TalkData();
		} else {
			;
		}
		return self::$talkDataObj;
	}
	
}