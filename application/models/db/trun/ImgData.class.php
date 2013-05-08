<?php

class ImgData extends AK_Db{
	
	
	/**
	 * インサート
	 * @param string $imgKey
	 * @param string $img
	 * @param string $imgFileName
	 * @param string $imgType
	 * @param int $imgSize
	 * @return int $imeSeqNum
	 */
	public function insert( $imgKey, $img, $imgFileName, $imgType, $imgSize ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgKey:'      . $imgKey );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgFileName:' . $imgFileName );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgType:'     . $imgType );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgSize:'     . $imgSize );
		
		$this -> sqlcmd =
			"INSERT INTO img_data "
			. "( "
				. "  img_seq_num "
				. ", img_key "
				. ", img "
				. ", img_file_name "
				. ", img_type "
				. ", img_size "
				. ", insert_time "
			. ") VALUES ( "
				. "  ? "
				. ", ? "
				. ", ? "
				. ", ? "
				. ", ? "
				. ", ? "
				. ", ? "
			. ") "
			;
			
		$this -> bindArray = array(
			  0
			, $imgKey
			, $img
			, $imgFileName
			, $imgType
			, $imgSize
			, date( 'YmdHis' )
		);
		
		$imgSeqNum = $this -> exec();
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgSeqNum:' . $imgSeqNum );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $imgSeqNum;
		
	}
	
	
	/**
	 * データ取得
	 * @param string $imgKey
	 */
	public function getDataByImgKey( $imgKey ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgKey:' . $imgKey );
		
		$this -> sqlcmd =
			"SELECT "
				. "  img_seq_num "
				. ", img_key "
				. ", img "
				. ", img_file_name "
				. ", img_type "
				. ", img_size "
			. "FROM img_data "
			. "WHERE img_key = ? "
			. "AND delete_flg = ? "
			;
			
		$this -> bindArray = array(
			  $imgKey
			, DELETE_FLG_FALSE
		);
		
		$this -> select();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $this -> valueArray;
		
	}
	
}