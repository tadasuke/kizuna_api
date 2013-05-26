<?php

class UserBasicData extends AK_Db {
	
	
	/**
	 * インサート
	 * @param string $userKey
	 * @param string $mailAddress
	 * @param string $password
	 * @param string $status
	 * @param string $entryDate
	 * @param string $cancelFlg
	 * @return int $userNum
	 */
	public function insert( $userKey, $mailAddress, $password, $status, $entryDate, $cancelFlg ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userKey:'     . $userKey );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'mailAddress:' . $mailAddress );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'password:'    . $password );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'status:'      . $status );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'entryDate:'   . $entryDate );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'cancelFlg:'   . $cancelFlg );
		
		$this -> sqlcmd =
			"INSERT INTO user_basic_data "
			. "( "
				. "  user_num "
				. ", user_key "
				. ", mail_address "
				. ", password "
				. ", status "
				. ", entry_date "
				. ", cancel_flg "
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
			. ") "
			;
			
		$this -> bindArray = array(
			  0
			, $userKey
			, $mailAddress
			, $password
			, $status
			, $entryDate
			, $cancelFlg
			, date( 'YmdHis' )	
		);
		
		$userNum = $this -> exec();
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:' . $userNum );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $userNum;
		
	}
	
	/**
	 * データ取得
	 * メールアドレスを元にデータを取得する
	 * @param string $mailAddress
	 * @return array
	 */
	public function getDataByMailAddress( $mailAddress ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$this -> sqlcmd =
			"SELECT "
				. "  user_num "
				. ", user_key "
				. ", mail_address "
				. ", password "
				. ", status "
				. ", entry_date "
				. ", cancel_flg "
			. "FROM user_basic_data "
			. "WHERE mail_address = ? "
			;
			
		$this -> bindArray = array(
			$mailAddress
		);
		
		$this -> select();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $this -> valueArray;
	}
	
	
	/**
	 * データ取得
	 * ユーザキーを元にデータを取得する
	 * @param string $userKey
	 */
	public function getDataByUserKey( $userKey ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userKey:' . $userKey );
		
		$this -> sqlcmd =
			"SELECT "
				. "  user_num "
				. ", user_key "
				. ", mail_address "
				. ", password "
				. ", status "
				. ", entry_date "
				. ", cancel_flg "
			. "FROM user_basic_data "
			. "WHERE user_key = ? "
			;
			
		$this -> bindArray = array( $userKey );
		
		$this -> select();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $this -> valueArray;
		
	}
	
	
	/**
	 * ユーザデータ取得
	 * @param int $userNum
	 * @return array
	 */
	public function getDataByUserNum( $userNum ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:' . $userNum );
		
		$this -> sqlcmd =
			"SELECT "
				. "  user_num "
				. ", user_key "
				. ", mail_address "
				. ", password "
				. ", status "
				. ", entry_date "
				. ", cancel_flg "
			. "FROM user_basic_data "
			. "WHERE user_num = ? "
			. "AND delete_flg = ? "
			;
		
		$this -> bindArray = array(
				  $userNum
				, DELETE_FLG_FALSE
		);
		
		$this -> select();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $this -> valueArray;
		
	}
	
	
	/**
	 * データ取得
	 * @param string $userKey
	 */
	public function getAllData() {
	
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
	
		$this -> sqlcmd =
			"SELECT "
				. "  user_num "
				. ", user_key "
				. ", mail_address "
				. ", password "
				. ", status "
				. ", entry_date "
				. ", cancel_flg "
			. "FROM user_basic_data "
			. "WHERE delete_flg = ? "
			;
			
		$this -> bindArray = array(
			DELETE_FLG_FALSE
		);
																							
		$this -> select();
	
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $this -> valueArray;
	
	}
	
}