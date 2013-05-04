<?php

class Img {
	
	const UPLOAD_IMG_COMPLETE = '0';
	const UPLOAD_IMG_ERROR    = '1';
	
	public static $newImgSeqNum = NULL;
	
	public static $newImgKey = NULL;
	
	/**
	 * 画像アップロード
	 * @param string $img
	 */
	public static function uploadImg( $img ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$imgKey = Library::string2hash( microtime() );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgKey:' . $imgKey );
		
		$imgSeqNum = DataClassFactory::getImgDataObj() -> insert( $imgKey, $img );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgSeqNum:' . $imgSeqNum );
		
		self::$newImgSeqNum = $imgSeqNum;
		self::$newImgKey    = $imgKey;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return self::UPLOAD_IMG_COMPLETE;
		
	}
	
}