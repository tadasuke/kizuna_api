<?php

class UserPersonalData extends AK_Db {
	
	
	/**
	 * シンプルインサート
	 * @param int $userNum
	 * @param string $name
	 */
	public function simpleInsert( $userNum, $name ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:' . $userNum );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'name:'    . $name );
		
		$this -> sqlcmd =
			"INSERT INTO user_personal_data "
			. "( "
				. "  user_num "
				. ", name "
				. ", insert_time "
			. ") VALUES ( "
				. "  ? "
				. ", ? "
				. ", ? "
			. ") "
			;
			
		$this -> bindArray = array(
			  $userNum
			, $name	
			, date( 'YmdHis' )
		);
		
		$this -> exec();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	/**
	 * データ取得
	 * ユーザIDを元にデータを取得する
	 * メールアドレスを元にデータを取得する
	 * @param int $userNum
	 * @return array
	 */
	public function getDataByUserNum( $userNum ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$this -> sqlcmd =
			"SELECT "
				. "  user_num "
				. ", name "
				. ", gender "
				. ", birthday "
				. ", address "
				. ", telephone_number_1 "
				. ", telephone_number_2 "
				. ", profile_img_seq_id "
			. "FROM user_personal_data "
			. "WHERE user_num = ? "
			;
			
		$this -> bindArray = array(
			$userNum
		);
		
		$this -> select();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $this -> valueArray;
	}
	
}
