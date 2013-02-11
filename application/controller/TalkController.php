<?php

require_once 'application/models/Talk.class.php';

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
	
	
	/**
	 * トーク実行
	 */
	public function talkAction() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		$themeId = $this -> getParam( 'theme_id' );
		$talk    = $this -> getParam( 'talk' );
		$talkType = $this -> getParam( 'talk_type' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'themeId:'  . $themeId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talk:'     . $talk );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkType:' . $talkType );
		
		$talkSeqId = '';
		
		// 書き込み実行
		$result = Talk::execTalk( $this -> playerUserId, $themeId, $talk, $talkType );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'result:' . $result );
		
		// 書き込み成功時には書き込みシーケンスIDを取得
		$talkSeqId = (strcmp( $result, Talk::TALK_RESULT_COMPLETE ) == 0) ? Talk::$talkSeqId : $talkSeqId;
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkSeqId:' . $talkSeqId );
		
		// レスポンス設定
		$responseArray = array(
			  'result'      => $result
			, 'talk_seq_id' => $talkSeqId
		);
		$this -> setResponseParam( $responseArray );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	/**
	 * コメント実行
	 */
	public function commentAction() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$talkSeqId = $this -> getParam( 'talk_seq_id' );
		$comment   = $this -> getParam( 'comment' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkSeqId:' . $talkSeqId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'comment:'   . $comment );
		
		$commentSeqId = '';
		
		// コメント書き込み実行
		$result = Talk::execComment( $this -> playerUserId, $talkSeqId, $comment );
		
		// コメント書き込み成功時にはコメントシーケンスIDを取得
		$commentSeqId = (strcmp( $result, Talk::COMMENT_RESULT_COMPLETE ) == 0 ) ? Talk::$commentSeqId : $commentSeqId;
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'commentSeqId:' . $commentSeqId );
		
		// レスポンス設定
		$responseArray = array(
			  'result'         => $result
			, 'comment_seq_id' => $commentSeqId
		);
		$this -> setResponseParam( $responseArray );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
}