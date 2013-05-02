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
		
		$themeId     = $this -> getParam( 'theme_id' );
		$talkUserKey = $this -> getParam( 'talk_user_key' );
		$talkSeqNum  = $this -> getParam( 'talk_seq_num' );
		$startSeqNum = $this -> getParam( 'start_seq_num' );
		$dataCount   = $this -> getParam( 'data_count' );
		
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
		// トークユーザNUM
		if ( strlen( $talkUserKey ) > 0 ) {
			$talkUserNum = User::getUserNumByUserKey( $talkUserKey );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkUserNum:' . $talkUserNum );
			$talkObj -> setSearchUserNum( $talkUserNum );
		} else {
			;
		}
		// トークシーケンスNUM
		if ( strlen( $talkSeqNum ) > 0 ) {
			$talkObj -> setSearchTalkSeqNum( $talkSeqNum );
		} else {
			;
		}
		// 検索開始シーケンスNUM
		if ( strlen( $startSeqNum ) > 0 ) {
			$talkObj -> setStartTalkSeqNum( $startSeqNum ); 
		} else {
			;
		}
		// 獲得データ数
		if ( strlen( $dataCount ) > 0 ) {
			$talkObj -> setGetRecordCount( $dataCount );
		} else {
			;
		}
		
		// トークデータ取得
		$talkBeanArray = $talkObj -> getTalkBeanArray();
		
		$talkDataArray = array();
		foreach ( $talkBeanArray as $talkBean ) {
			$talkDataArray[] = array(
				  'talk_seq_num'  => $talkBean -> getTalkSeqNum()
				, 'talk'          => $talkBean -> getTalk()
				, 'theme_id'      => $talkBean -> getThemeId()
				, 'talk_user_name' => User::getUserNameByUserNum( $talkBean -> getTalkUserNum() )
				, 'talk_user_key' => User::getUserKeyByUserNum( $talkBean -> getTalkUserNum() )
				, 'talk_date'     => AK_Gadget::dateFormat( $talkBean -> getTalkDate() )
			);
		}
		
		$this -> setResponseParam( array( 'talk_data' => $talkDataArray ) );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	/**
	 * 全テーマ取得
	 */
	public function getThemeAction() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		$themeId = $this -> getParam( 'theme_id' ) ?: NULL;
		
		$themeArray = Talk::getTheme( $themeId );
		
		$responseArray = array();
		foreach ( $themeArray as $data ) {
			$responseArray[] = array(
				  'theme_id'   => $data['theme_id']
				, 'theme_name' => $data['theme_name']
				, 'template'   => $data['template'] ?: ''
			);
		}
		
		$this -> setResponseParam( array( 'theme_data' => $responseArray ) );
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