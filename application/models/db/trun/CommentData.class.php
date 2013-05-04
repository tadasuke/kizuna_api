<?php

class CommentData extends AK_Db{
	
	/**
	 * インサート
	 * @param int $talkSeqNum
	 * @param int $userNum
	 * @param string $comment
	 * @param string $commentDate
	 * @param string $userDeleteFlg
	 * @return int $commentSeqNum
	 */
	public function insert( $talkSeqNum, $userNum, $comment, $commentDate, $userDeleteFlg ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkSeqNum:'    . $talkSeqNum );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:'       . $userNum );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'comment:'       . $comment );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'commentDate:'   . $commentDate );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userDeleteFlg:' . $userDeleteFlg );
		
		$this -> sqlcmd =
			"INSERT INTO comment_data "
			. "( "
				. "  comment_seq_num "
				. ", talk_seq_num "
				. ", user_num "
				. ", comment "
				. ", comment_date "
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
			, $talkSeqNum
			, $userNum
			, $comment
			, $commentDate
			, $userDeleteFlg
			, date( 'YmdHis' )
		);
		
		$commentSeqNum = $this -> exec();
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'commentSeqNum:' . $commentSeqNum );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $commentSeqNum;
		
	}
	
	
	/**
	 * データ取得
	 * @param int $talkSeqNum
	 * @param string $userDeleteFlg
	 * @return array
	 */
	public function getDataByTalkSeqNum( $talkSeqNum, $userDeleteFlg ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkSeqNum:'    . $talkSeqNum );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userDeleteFlg:' . $userDeleteFlg );
		
		$this -> sqlcmd =
			"SELECT "
				. "  comment_seq_num "
				. ", talk_seq_num "
				. ", user_num "
				. ", comment "
				. ", comment_date "
				. ", user_delete_flg "
			. "FROM comment_data "
			. "WHERE talk_seq_num = ? "
			. "AND user_delete_flg = ? "
			. "AND delete_flg = ? "
			;
			
		$this -> bindArray = array(
			  $talkSeqNum
			, $userDeleteFlg
			, DELETE_FLG_FALSE
		);
		
		$this -> select();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $this -> valueArray;
		
	}
	
}