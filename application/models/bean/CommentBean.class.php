<?php

class CommentBean {
	
	/**
	 * コメントシーケンスID
	 * @var int
	 */
	private $commentSeqId = NULL;
	public function setCommentSeqId( $commentSeqId ) {
		$this -> commentSeqId = $commentSeqId;
	}
	public function getCommentSeq() {
		return $this -> commentSeqId;
	}
	
	/**
	 * コメントをしたトークシーケンスID
	 * @var int
	 */
	private $talkSeqId = NULL;
	public function setTalkSeqId( $talkSeqId ) {
		$this -> talkSeqId = $talkSeqId;
	}
	public function getTalkSeqId() {
		return $this -> talkSeqId;
	}
	
	/**
	 * コメントユーザID
	 * @var string
	 */
	private $commentUserId = NULL;
	public function setCommentUserId( $commentUserId ) {
		$this -> commentUserId = $commentUserId;
	}
	public function getCommentUserId() {
		return $this -> commentUserId;
	}
	
	private $comment = NULL;
	private $commentDate = NULL;
	
	
	
}