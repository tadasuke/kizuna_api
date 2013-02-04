<?php

class UserPersonalData extends AK_Db {
	
	/**
	 * データ取得
	 * ユーザIDを元にデータを取得する
	 * メールアドレスを元にデータを取得する
	 * @param int $userId
	 * @return array
	 */
	public function getDataByUserId( $userId ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$this -> sqlcmd =
			"SELECT "
				. "  user_id "
				. ", name "
				. ", gender "
				. ", birthday "
				. ", address "
				. ", telephone_number_1 "
				. ", telephone_number_2 "
				. ", profile_img_seq_id "
			. "FROM user_personal_data "
			. "WHERE user_id = ? "
			;
			
		$this -> bindArray = array(
			$userId
		);
		
		$this -> select();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $this -> valueArray;
	}
	
}
