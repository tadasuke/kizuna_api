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
				. ", profile_img_key "
			. "FROM user_personal_data "
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
	 * ユーザパーソナル情報更新
	 * @param int $userNum
	 * @param array $updateArray
	 */
	public function updatePersonalData( $userNum, array $updateArray ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:' . $userNum );
		
		$sqlcmd =
			"UPDATE user_personal_data "
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
		
		$sqlcmd .= " WHERE user_num = ? ";
		$bindArray[] = $userNum;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'sqlcmd:' . $sqlcmd );
	
		$this -> sqlcmd    = $sqlcmd;
		$this -> bindArray = $bindArray;
		
		$this -> exec();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
}
