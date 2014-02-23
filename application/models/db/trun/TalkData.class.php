<?php

class TalkData extends AK_Db{
	
	/**
	 * データ取得
	 * @param int $seqId
	 * @param int $userId
	 * @param string $themeId
	 * @param int $getRecordCount
	 * @param int $startSeqNum
	 */
	public function getData( $getRecordCount = NULL, $seqNum = NULL, $userNum = NULL, $themeId = NULL, $startSeqNum = NULL, $userDeleteFlg = NULL, $searchWord = NULL ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'seqNum:'         . $seqNum );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:'        . $userNum );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'themeId:'        . $themeId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'getRecordCount:' . $getRecordCount );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'startSeqNum:'    . $startSeqNum );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'searchWord:'     . $searchWord );
		
		$this -> sqlcmd =
			"SELECT "
				. "  seq_num "
				. ", user_num "
				. ", theme_id "
				. ", talk "
				. ", talk_date "
				. ", user_delete_flg "
			. "FROM talk_data "
			. "WHERE delete_flg = ? "
			;
			
		$this -> bindArray = array(
			DELETE_FLG_FALSE
		);
		
		if ( is_null( $seqNum ) === FALSE ) {
			$this -> sqlcmd .= "AND seq_num = ? ";
			$this -> bindArray[] = $seqNum;
		} else {
			;
		}
		
		if ( is_null( $userNum ) === FALSE ) {
			$this -> sqlcmd .= "AND user_num = ? ";
			$this -> bindArray[] = $userNum;
		} else {
			;
		}
		
		if ( is_null( $themeId ) === FALSE ) {
			$this -> sqlcmd .= "AND theme_id = ? ";
			$this -> bindArray[] = $themeId;
		} else {
			;
		}
		
		if ( is_null( $startSeqNum ) === FALSE ) {
			$this -> sqlcmd .= "AND seq_num >= ? ";
			$this -> bindArray[] = $startSeqNum;
		} else {
			;
		}
		
		if ( is_null( $userDeleteFlg ) === FALSE ) {
			$this -> sqlcmd .= "AND user_delete_flg = ? ";
			$this -> bindArray[] = $userDeleteFlg;
		} else {
			;
		}

		if ( is_null( $searchWord ) === FALSE ) {
			$this -> sqlcmd .= "AND talk like ? ";
			$this -> bindArray[] = "%" . $searchWord . "%";
		} else {
			;
		}

		$this -> sqlcmd .= "ORDER BY seq_num ASC ";
		
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
	
	/**
	 * アップデート
	 * @param int $user_num
	 * @param string $seq_num
	 * @param string $userDeleteFlg
	 * @param array $updateArray
	 */
	public function update( $user_num, $seq_num, $user_delete_flg, array $updateArray ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );

        AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'user_num:'       . $user_num );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'seq_num:'        . $seq_num );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'user_delete_flg:'. $user_delete_flg );
		
		$sqlcmd =
			"UPDATE talk_data "
			. "SET "
			;
		$bindArray = array();
		foreach ( $updateArray as $key => $value ) {
			$sqlcmd .= $key . ' = ? ';
			$sqlcmd .= ',';
			$bindArray[] = $value;
		}

		// 末尾のカンマを削除
		$sqlcmd = substr( $sqlcmd, 0, strlen( $sqlcmd ) - 1 );

		$sqlcmd .= " WHERE user_num = ? "
            . "AND seq_num = ? "
            . "AND user_delete_flg = ? "
            ;
		$bindArray[] = $user_num;
		$bindArray[] = $seq_num;
		$bindArray[] = $user_delete_flg;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'sqlcmd:' . $sqlcmd );
	
		$this -> sqlcmd    = $sqlcmd;
		$this -> bindArray = $bindArray;
		
		$this -> exec();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
}