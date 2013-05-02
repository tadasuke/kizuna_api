<?php

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
	
	
}