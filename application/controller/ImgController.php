<?php

require_once 'application/models/Img.class.php';

class ImgController extends KizunaBaseController {
	
	/**
	 * 画像アップロード
	 */
	public function uploadAction() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$imgKey = '';
		
		$upload_file = $_FILES["upload_file"];
		$name    = $upload_file['name'];
		$type    = $upload_file['type'];
		$tmpName = $upload_file['tmp_name'];
		$error   = $upload_file['error'];
		$size    = $upload_file['size'];
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'name:' . $name );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'type:' . $type );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'tmpName:' . $tmpName );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'error:' . $error );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'size:' . $size );
		
		// 画像ファイルを取得
		$img = file_get_contents( $tmpName );
		
		// アップロード
		$result = Img::uploadImg( $img );
		
		// アップロードが成功した場合
		if ( strcmp( $result, Img::UPLOAD_IMG_COMPLETE ) == 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'upload_complete' );
			$imgKey = Img::$newImgKey;
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgKey:' . $imgKey );
		} else {
			;
		}
		
		// レスポンス配列作成
		$responseArray = array(
			  'result'  => $result
			, 'img_key' => $imgKey
		);
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		$this -> setResponseParam( $responseArray );
		
	}
	
	
	/**
	 * 画像取得
	 */
	public function getImgAction() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$imgKey = $this -> getParam( 'img_key' );
		
		$img = Img::getImgByImgKey( $imgKey );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		$this -> setResponseType( self::RESPONSE_TYPE_IMG );
		$this -> setResponseParam( array( $img ) );
		
	}
	
}