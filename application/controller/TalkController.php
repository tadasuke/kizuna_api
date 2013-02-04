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
		$talkUserId = User::getUserIdFromUserKey( $talkUserKey );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkUserId:' . $talkUserId );
		
		// 取得トークデータ数設定
		if ( strlen( $recordCount ) == 0 ) {
			$recordCount = DEF_GET_TALK_DATA_COUNT;
		} else {
			if ( $recordCount > MAX_GET_TALK_DATA_COUNT ) {
				$recordCount = MAX_GET_TALK_DATA_COUNT;
			} else {
				;
			}
		}
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'recordCount:' . $recordCount );
		
		
		
		
		exit;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
}