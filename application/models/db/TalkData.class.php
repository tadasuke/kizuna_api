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
	 * @param int $userId
	 * @param string $themeId
	 * @param string $talk
	 * @param string $talkType
	 * @param int $imgSeqId
	 * @param string $talkDate
	 * @param string $userDeleteFlg
	 */
	public function insert( $userId, $themeId, $talk, $talkType, $imgSeqId, $talkDate, $userDeleteFlg ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userId:'        . $userId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'themeId:'       . $themeId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talk:'          . $talk );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkType:'      . $talkType );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgSeqId:'      . $imgSeqId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkDate:'      . $talkDate );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userDeleteFlg:' . $userDeleteFlg );
		
		$this -> sqlcmd =
			"INSERT INTO talk_data "
			. "( "
				. "  seq_id "
				. ", user_id "
				. ", theme_id "
				. ", talk "
				. ", talk_type "
				. ", img_seq_id "
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
				. ", ? "
				. ", ? "
			. ") "
			;
			
		$this -> bindArray = array(
			  0
			, $userId
			, $themeId
			, $talk
			, $talkType
			, $imgSeqId
			, $talkDate
			, $userDeleteFlg
			, date( 'YmdHis' )
		);
		
		$talkSeqId = $this -> exec();
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkSeqId:' . $talkSeqId );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $talkSeqId;
		
	}
	
}