<?php

class CommentData extends AK_Db{
	
	
	/**
	 * インサート
	 * @param int $talkSeqId
	 * @param int $userId
	 * @param string $comment
	 * @param string $commentDate
	 * @param string $userDeleteFlg
	 */
	public function insert( $talkSeqId, $userId, $comment, $commentDate, $userDeleteFlg ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkSeqId:'     . $talkSeqId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userId:'        . $userId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'comment:'       . $comment );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'commentDate:'   . $commentDate );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userDeleteFlg:' . $userDeleteFlg );
		
		$this -> sqlcmd =
			"INSERT INTO comment_data "
			. "( "
				. "  talk_seq_id "
				. ", user_id "
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
			. ") "
			;
			
		$this -> bindArray = array(
			  $talkSeqId
			, $userId
			, $comment
			, $commentDate
			, $userDeleteFlg
			, date( 'YmdHis' )
		);
		
		$commentSeqId = $this -> exec();
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'commentSeqId:' . $commentSeqId );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $commentSeqId;
		
	}
	
}