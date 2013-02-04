<?php

class TaklBean {
	
	/**
	 * トークシーケンスID
	 * @var int
	 */
	private $talkSeqId = NULL;
	public function setTaklSeqId( $talkSeqId ) {
		$this -> talkSeqId = $talkSeqId;
	}
	public function getTalkSeqId() {
		return $this -> talkSeqId;
	}
	
	/**
	 * トークユーザID
	 * @var int
	 */
	private $talkUserId = NULL;
	public function setTalkUserId( $talkUserId ) {
		$this -> talkUserId = $talkUserId;
	}
	public function getTalkUserId() {
		return $this -> talkUserId;
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
		return $this -> getTalkDate();
	}
	
	
}