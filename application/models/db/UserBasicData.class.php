<?php

class UserBasicData extends AK_Db {
	
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
				. "  user_id "
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
				. "  user_id "
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
	
}