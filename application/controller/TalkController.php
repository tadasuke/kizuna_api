<?php

require_once 'application/models/Talk.class.php';

class TalkController extends KizunaBaseController {
	
	
	/**
	 * トーク実行
	 */
	public function execTalkAction() {
	
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		$themeId = $this -> getParam( 'theme_id' );
		$talk    = $this -> getParam( 'talk' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'themeId:'  . $themeId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talk:'     . $talk );
		
		$talkSeqNum = '';
	
		// 書き込み実行
		$result = Talk::execTalk( $this -> playerUserNum, $themeId, $talk );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'result:' . $result );
	
		// 書き込み成功時には書き込みシーケンスIDを取得
		if ( strcmp( $result, Talk::TALK_RESULT_COMPLETE ) == 0 ) {
			$talkSeqNum = Talk::$newTalkSeqNum;
		} else {
			;
		}
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkSeqNum:' . $talkSeqNum );
	
		// レスポンス設定
		$responseArray = array(
			  'result'       => $result
			, 'talk_seq_num' => $talkSeqNum
		);
		$this -> setResponseParam( $responseArray );
	
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
	
	}
	
	
	/**
	 * トークデータ取得
	 */
	public function getTalkAction() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$talkObj = Talk::getInstance();
		$talkBeanArray = $talkObj -> getTalkBeanArray();
		
		$talkDataArray = array();
		foreach ( $talkBeanArray as $talkBean ) {
			$talkDataArray[] = array(
				'talk_seq_num' => $talkBean -> getTalkSeqNum()
				, 'talk'       => $talkBean -> getTalk()
				, 'theme_id'   => $talkBean -> getThemeId()
				, 'talk_user_key' => ''
				, 'talk_date'  => $talkBean -> getTalkDate()
			);
		}
		
		$this -> setResponseParam( array( 'talk_data' => $talkDataArray ) );
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