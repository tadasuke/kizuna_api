<?php

class TalkData extends AK_Db{
	
	/**
	 * データ取得
	 * @param int $seqId
	 * @param int $userId
	 * @param string $themeId
	 * @param int $getRecordCount
	 * @param int $startSeqId
	 */
	public function getData( $getRecordCount = NULL, $seqId = NULL, $userId = NULL, $themeId = NULL, $startSeqId = NULL, $userDeleteFlg = Talk::TALK_USER_DELTE_FLG_FALSE ) {
		
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
		
		if ( is_null( $userDeleteFlg ) === FALSE ) {
			$this -> sqlcmd .= "AND user_delete_flg = ? ";
			$this -> bindArray[] = $userDeleteFlg;
		} else {
			;
		}
		
		$this -> sqlcmd .= "ORDER BY seq_id DESC ";
		
		if ( is_null( $getRecordCount ) === FALSE ) {
			$this -> sqlcmd .= "LIMIT 0, " . $getRecordCount . " ";
		}
		
		$this -> select();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $this -> valueArray;
	}
	
	/**
	 * インサート
	 * @param int $userNum
	 * @param string $themeId
	 * @param string $talk
	 * @param string $talkDate
	 * @param string $userDeleteFlg
	 * @return int $talkSeqNum
	 */
	public function insert( $userNum, $themeId, $talk, $talkDate, $userDeleteFlg ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:'       . $userNum );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'themeId:'       . $themeId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talk:'          . $talk );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkDate:'      . $talkDate );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userDeleteFlg:' . $userDeleteFlg );
		
		$this -> sqlcmd =
			"INSERT INTO talk_data "
			. "( "
				. "  seq_num "
				. ", user_num "
				. ", theme_id "
				. ", talk "
				. ", talk_date "
				. ", user_delete_flg "
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
			, $userNum
			, $themeId
			, $talk
			, $talkDate
			, $userDeleteFlg
			, date( 'YmdHis' )
		);
		
		$talkSeqNum = $this -> exec();
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkSeqNum:' . $talkSeqNum );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $talkSeqNum;
		
	}
	
}