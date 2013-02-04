<?php

class TalkData extends AK_Db {
	
	/**
	 * データ取得
	 * @param int $seqId
	 * @param int $userId
	 * @param string $themeId
	 * @param int $getRecordCount
	 * @param int $startSeqId
	 */
	public function getData( $getRecordCount = NULL, $seqId = NULL, $userId = NULL, $themeId = NULL, $startSeqId = NULL ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'seqId:'          . $seqId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userId:'         . $userId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'themeId:'        . $themeId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'getRecordCount:' . $getRecordCount );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'startSeqId:'     . $startSeqId );
		
		$this -> sqlcmd =
			"SELECT "
				. "  seq_id "
				. ", user_id "
				. ", theme_id "
				. ", talk "
				. ", talk_type "
				. ", talk_date "
				. ", user_delete_flg "
			. "FROM talk_data "
			. "WHERE delete_flg = ? "
			;
			
		$this -> bindArray = array(
			DELETE_FLG_FALSE
		);
		
		if ( is_null( $seqId ) === FALSE ) {
			$this -> sqlcmd .= "AND seq_id = ? ";
			$this -> bindArray[] = $seqId;
		} else {
			;
		}
		
		if ( is_null( $userId ) === FALSE ) {
			$this -> sqlcmd .= "AND user_id = ? ";
			$this -> bindArray[] = $userId;
		} else {
			;
		}
		
		if ( is_null( $themeId ) === FALSE ) {
			$this -> sqlcmd .= "AND theme_id = ? ";
			$this -> bindArray[] = $themeId;
		} else {
			;
		}
		
		if ( is_null( $startSeqId ) === FALSE ) {
			$this -> sqlcmd .= "AND seq_id >= ? ";
			$this -> bindArray[] = $startSeqId;
		} else {
			;
		}
		
		$this -> sqlcmd .= "ORDER BY seq_id ";
		
		if ( is_null( $getRecordCount ) === FALSE ) {
			$this -> sqlcmd .= "LIMIT 0, " . $getRecordCount . " ";
		}
		
		$this -> select();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $this -> valueArray;
	}
	
}