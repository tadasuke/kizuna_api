<?php

require_once 'application/models/Talk.class.php';
//require_once BASE_PATH . 'application/models/UserFactory.class.php';

class TalkController extends KizunaBaseController {
	
	/**
	 * トークデータ取得
	 */
	public function getTalkDataAction() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$themeId        = $this -> getParam( 'theme_id' );
		$talkId         = $this -> getParam( 'talk_id' );
		$talkUserKey    = $this -> getParam( 'talk_user_key' );
		$recordCount    = $this -> getParam( 'record_count' );
		$startTalkSeqId = $this -> getParam( 'start_talk_seq_id' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'themeId:'        . $themeId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkId:'         . $talkId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkUserKey:'    . $talkUserKey );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'recordCount:'    . $recordCount );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'startTalkSeqId:' . $startTalkSeqId );
		
		// ユーザキーを元にユーザIDを取得
		$talkUserId = (strlen( $talkUserKey ) > 0 ) ? User::getUserIdFromUserKey( $talkUserKey ) : NULL;
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkUserId:' . $talkUserId );
		
		// 取得トークデータ数設定
		if ( strlen( $recordCount ) == 0 ) {
			$recordCount = AK_Ini::getConfig( 'talk_config', 'def_get_talk_data_count' );
		} else {
			if ( $recordCount > AK_Ini::getConfig( 'talk_config', 'max_get_talk_data_count' ) ) {
				$recordCount = AK_Ini::getConfig( 'talk_config', 'max_get_talk_data_count' );
			} else {
				;
			}
		}
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'recordCount:' . $recordCount );
		
		// トークオブジェクト生成
		$talkObj = Talk::getInstance();
		//------------
		// 検索条件設定
		//------------
		// テーマID
		if ( strlen( $themeId ) > 0 ) {
			$talkObj -> setSearchThemeId( $themeId );
		} else {
			;
		}
		// トークID
		if ( strlen( $talkId ) > 0 ) {
			$talkObj -> setSearchTalkSeqId( $talkId );
		} else {
			;
		}
		// ユーザID
		if ( strlen( $talkUserId ) > 0 ) {
			$talkObj -> setSearchUserId( $searchUserId );
		} else {
			;
		}
		// 取得件数
		$talkObj -> setGetRecordCount( $recordCount );
		// 検索開始シーケンスID
		if ( strlen( $startTalkSeqId ) > 0 ) {
			$talkObj -> setStartTalkSeqId( $startTalkSeqId );
		} else {
			;
		}
		$talkBeanArray = $talkObj -> getTalkBeanArray( TRUE );
		
		$talkDataArray = array();
		foreach ( $talkBeanArray as $talkBean ) {
			
			User::getUserIdFromUserKey($userKey);
			
			$talkDataArray[] = array(
				  'talk_seq_id'   => $talkBean -> getTalkSeqId()
				, 'talk'          => $talkBean -> getTalk()
				, 'theme_id'      => $talkBean -> getThemeId()
				, 'takl_user_key' => User::getUserKeyByUserId( $talkBean -> getTalkUserId() )
				, 'talk_date'     => $talkBean -> getTalkDate()
			);
		}
		
		$this -> setResponseParam( array( 'talk_data' => $talkDataArray ) );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
}