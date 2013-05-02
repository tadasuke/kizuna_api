<?php

require_once 'CommentBean.class.php';

class TalkBean {
	
	/**
	 * トークシーケンスNUM
	 * @var int
	 */
	private $talkSeqNum = NULL;
	public function setTaklSeqNum( $talkSeqNum ) {
		$this -> talkSeqNum = $talkSeqNum;
	}
	public function getTalkSeqNum() {
		return $this -> talkSeqNum;
	}
	
	/**
	 * トークユーザID
	 * @var int
	 */
	private $talkUserNum = NULL;
	public function setTalkUserNum( $talkUserNum ) {
		$this -> talkUserNum = $talkUserNum;
	}
	public function getTalkUserNum() {
		return $this -> talkUserNum;
	}
	
	/**
	 * テーマID
	 * @var string
	 */
	private $themeId = NULL;
	public function setThemeId( $themeId ) {
		$this -> themeId = $themeId;
	}
	public function getThemeId() {
		return $this -> themeId;
	}
	
	/**
	 * トーク
	 * @var string
	 */
	private $talk = NULL;
	public function setTalk( $talk ) {
		$this -> talk = $talk;
	}
	public function getTalk() {
		return $this -> talk;
	}
	
	/**
	 * トーク日時
	 * @var string
	 */
	private $talkDate = NULL;
	public function setTalkDate( $talkDate ) {
		$this -> talkDate = $talkDate;
	}
	public function getTalkDate() {
		return $this -> talkDate;
	}
	
	/**
	 * コメントビーン配列
	 * @var array[CommentBean]
	 */
	private $commentBeanArray = array();
	public function setCommentBeanArray() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		// トークシーケンスNUMが未設定の場合は何もしない
		if ( is_null( $this -> talkSeqNum ) === TRUE ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'no_talk_seq_num' );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
			return;
		} else {
			;
		}
		
		// コメントデータを取得
		$commentDataValueArray = DataClassFactory::getCommentDataObj() -> getDataByTalkSeqNum( $this -> talkSeqNum, Talk::COMMENT_USER_DLETE_FLG_FALSE );
		
		$commentBeanArray = array();
		foreach ( $commentDataValueArray as $data ) {
			$commentBean = new CommentBean();
			$commentBean -> setCommentSeqNum( $data['comment_seq_num'] );
			$commentBean -> setTalkSeqNum( $data['talk_seq_num'] );
			$commentBean -> setCommentUserNum( $data['user_num'] );
			$commentBean -> setComment( $data['comment'] );
			$commentBean -> setCommentDate( $data['comment_date'] );
			$commentBeanArray[] = $commentBean;
		}
		
		$this -> commentBeanArray = $commentBeanArray;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
	}
	public function getCommentBeanArray() {
		return $this -> commentBeanArray;
	}
	
}