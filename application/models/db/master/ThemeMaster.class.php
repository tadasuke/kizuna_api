<?php

class ThemeMaster extends AK_Db{
	
	/**
	 * データ取得
	 * @param string $themeId
	 * @return array
	 */
	public function getDataByThemeId( $themeId = NULL ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'themeId:' . $themeId );
		
		$this -> sqlcmd =
		"SELECT "
			. "  theme_id "
			. ", theme_name "
			. ", templete "
		. "FROM theme_master "
		. "WHERE delete_flg = ? "
		;
													
		$this -> bindArray = array(
			DELETE_FLG_FALSE
		);
		
		// テーマIDが設定されていた場合
		if ( is_null( $themeId ) === FALSE ) {
			$this -> sqlcmd .= "AND theme_id = ? ";
			$this -> bindArray[] = $themeId;
		} else {
			;
		}
		
		$this -> select();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $this -> valueArray;
	}
	
}