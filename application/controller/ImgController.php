<?php

class ImgController extends KizunaBaseController {
	
	/**
	 * 画像アップロード
	 */
	public function uploadAction() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
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
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
}