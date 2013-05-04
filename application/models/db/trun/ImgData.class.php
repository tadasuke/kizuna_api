<?php

class ImgData extends AK_Db{
	
	
	/**
	 * インサート
	 * @param string $imgKey
	 * @param string $img
	 * @return int $imeSeqNum
	 */
	public function insert( $imgKey, $img ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgKey:' . $imgKey );
		
		$this -> sqlcmd =
			"INSERT INTO img_data "
			. "( "
				. "  img_seq_num "
				. ", img_key "
				. ", img "
				. ", insert_time "
			. ") VALUES ( "
				. "  ? "
				. ", ? "
				. ", ? "
				. ", ? "
			. ") "
			;
			
		$this -> bindArray = array(
			  0
			, $imgKey
			, $img
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