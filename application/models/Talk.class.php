<?php

class Talk {
	
	/**
	 * トークビーン配列
	 * @var array[TalkBean]
	 */
	private $talkBeanArray = array();
	public function getTalkBeanArray() {
		return $this -> talkBeanArray;
	}
	
	/**
	 * 検索トークID
	 * @var int
	 */
	private $searchTalkSeqId = NULL;
	public function setSearchTalkSeqId( $searchTalkSeqId ) {
		$this -> searchTalkSeqId = $searchTalkSeqId;
	}
	
	/**
	 * 検索テーマID
	 * @var string
	 */
	private $searchThemeId = NULL;
	public function setSearchThemeId( $searchThemeId ) {
		$this -> searchThemeId = $searchThemeId;
	}
	
	/**
	 * 検索ユーザID
	 * @var string
	 */
	private $searchUserId = NULL;
	public function setSearchId( $searchUserId ) {
		$this -> searchUserId = $searchUserId;
	}
	
	/**
	 * 取得トーク数
	 * @var int
	 */
	private $getRecordCount = 0;
	public function setGetRecordCount( $getRecordCount ) {
		$this -> getRecordCount = $getRecordCount;
	}
	
	/**
	 * 検索開始トークシーケンスID
	 * @var int
	 */
	private $startTalkSeqId = 1;
	public function setStartTalkSeqId( $startTalkSeqId ) {
		$this -> startTalkSeqId = $startTalkSeqId;
	}
	
	/**
	 * トークデータ取得
	 */
	public function getTalkData() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$talkDataValueArray = DataClassFactory::getTalkDataObj() -> getData( $this -> getRecordCount, $this -> searchTalkSeqId, $this -> searchUserId, $this -> searchThemeId, $this -> getRecordCount );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
	}
}