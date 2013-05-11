<?php

abstract class DataClassFactory {
	
	const DEFAULT_TRUN_DIR   = 'trun/';
	const DEFAULT_MASTER_DIR = 'master/';
	
	/**
	 * ユーザ基本データ
	 * @var UserBasicData
	 */
	private static $userBasicDataObj = NULL;
	public static function getUserBaslcDataObj() {
		if ( is_null( self::$userBasicDataObj ) === TRUE ) {
			require_once self::DEFAULT_TRUN_DIR . 'UserBasicData.class.php';
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
			require_once self::DEFAULT_TRUN_DIR . 'UserPersonalData.class.php';
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
			require_once self::DEFAULT_TRUN_DIR . 'TalkData.class.php';
			self::$talkDataObj = new TalkData();
		} else {
			;
		}
		return self::$talkDataObj;
	}
	
	/**
	 * コメントデータ
	 * @var CommentData
	 */
	private static $commentDataObj = NULL;
	public static function getCommentDataObj() {
		if ( is_null( self::$commentDataObj ) === TRUE ) {
			require_once self::DEFAULT_TRUN_DIR . 'CommentData.class.php';
			self::$commentDataObj = new CommentData();
		} else {
			;
		}
		return self::$commentDataObj;
	}
	
	
	/**
	 * 画像データ
	 * @var ImgData
	 */
	private static $imgDataObj = NULL;
	public static function getImgDataObj() {
		if ( is_null( self::$imgDataObj ) === TRUE ) {
			require_once self::DEFAULT_TRUN_DIR . 'ImgData.class.php';
			self::$imgDataObj = new ImgData();
		} else {
			;
		}
		return self::$imgDataObj;
	}
	
	
	/**
	 * アルバムデータ
	 * @var AlbumData
	 */
	private static $albumDataObj = NULL;
	public static function getAlbumDataObj() {
		if ( is_null( self::$albumDataObj ) === TRUE ) {
			require_once self::DEFAULT_TRUN_DIR . 'AlbumData.class.php';
			self::$albumDataObj = new AlbumData();
		} else {
			;
		}
		return self::$albumDataObj;
	}
	
	
	//------------------------- マスター系 ----------------------------------
	
	/**
	 * テーママスタ
	 * @var ThemeMaster
	 */
	private static $themeMasterObj = NULL;
	public static function getThemeMasterObj() {
		if ( is_null( self::$themeMasterObj ) === TRUE ) {
			require_once self::DEFAULT_MASTER_DIR . 'ThemeMaster.class.php';
			self::$themeMasterObj = new ThemeMaster( MASTER_DB_IDEMTIFICATION_NAME );
		} else {
			;
		}
		return self::$themeMasterObj;
	}
	
	
}