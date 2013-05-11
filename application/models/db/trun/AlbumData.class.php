<?php

/**
 * アルバムデータクラス
 * @author tadasuke
 */
class AlbumData extends AK_Db{

	/**
	 * インサート
	 * @param int $userNum
	 * @param int $imgSeqNum
	 * @param string $userDeleteFlg
	 */
	public function insert( $userNum, $imgSeqNum, $userDeleteFlg ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:'       . $userNum );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgSeqNum:'     . $imgSeqNum );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userDeleteFlg:' . $userDeleteFlg );
		
		$this -> sqlcmd =
			"INSERT INTO album_data "
			. "( "
				. "  user_num "
				. ", img_seq_num "
				. ", user_delete_flg "
				. ", insert_time "
			. ") VALUES ( "
				. "  ? "
				. ", ? "
				. ", ? "
				. ", ? "
			. ") "
			;
			
		$this -> bindArray = array(
			  $userNum
			, $imgSeqNum
			, $userDeleteFlg
			, date( 'YmdHis' )
		);
		
		$this -> exec();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
}