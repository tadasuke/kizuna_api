<?php

class CommentBean {
	
	/**
	 * コメントシーケンスNUM
	 * @var int
	 */
	private $commentSeqId = NULL;
	public function setCommentSeqNum( $commentSeqNum ) {
		$this -> commentSeqNum = $commentSeqNum;
	}
	public function getCommentSeqNum() {
		return $this -> commentSeqNum;
	}
	
	/**
	 * コメントをしたトークシーケンスNUM
	 * @var int
	 */
	private $talkSeqNum = NULL;
	public function setTalkSeqNum( $talkSeqNum ) {
		$this -> talkSeqNum = $talkSeqNum;
	}
	public function getTalkSeqNum() {
		return $this -> talkSeqNum;
	}
	
	/**
	 * コメントユーザNUM
	 * @var string
	 */
	private $commentUserNum = NULL;
	public function setCommentUserNum( $commentUserNum ) {
		$this -> commentUserNum = $commentUserNum;
	}
	public function getCommentUserNum() {
		return $this -> commentUserNum;
	}
	
	/**
	 * コメント
	 * @var string
	 */
	private $comment = NULL;
	public function setComment( $comment ) {
		$this -> comment = $comment;
	}
	public function getComment() {
		return $this -> comment;
	}
	
	/**
	 * コメント日時
	 * @var string
	 */
	private $commentDate = NULL;
	public function setCommentDate( $commentDate ) {
		$this -> commentDate = $commentDate;
	}
	public function getCommentDate() {
		return $this -> commentDate;
	}
	
}