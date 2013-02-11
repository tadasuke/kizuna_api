<?php

class ThemeMaster extends AK_Db{
	
	
	/**
	 * 前データ取得
	 * @return array
	 */
	public function getAllData() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$this -> sqlcmd =
			"SELECT "
				. "  theme_id "
				. ", theme_name "
				. ", templete "
			. "FROM theme_master "
			. "WHERE delete_flg = ? "
			;
			
		$this -> bindArray = array( DELETE_FLG_FALSE );
		
		$this -> select();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $this -> valueArray;
		
	}
	
	/**
	 * データ取得
	 * @param string $themeId
	 * @return array
	 */
	public function getDataByThemeId( $themeId ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'themeId:' . $themeId );
		
		$this -> sqlcmd =
		"SELECT "
			. "  theme_id "
			. ", theme_name "
			. ", templete "
		. "FROM theme_master "
		. "WHERE theme_id = ? "
		. "AND delete_flg = ? "
		;
													
		$this -> bindArray = array(
			  $themeId
			, DELETE_FLG_FALSE
		);
		
		$this -> select();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $this -> valueArray;
	}
	
}