<?php

require_once 'bean/TalkBean.class.php';

class Talk {
	
	//---------------------------
	// シングルトンにするためのモロモロ
	//---------------------------
	/**
	 * インスタンス
	 * @var Talk
	 */
	private static $instance = NULL;
	public static function getInstance() {
		if ( is_null( self::$instance ) === TRUE ) {
			self::$instance = new self();
		} else {
			;
		}
		return self::$instance;
	}
	private function __construct() {
		;
	}
	
	/**
	 * トークビーン配列
	 * @var array[TalkBean]
	 */
	private $talkBeanArray = NULL;
	public function getTalkBeanArray( $regetFlg = FALSE ) {
		if ( is_null( $this -> talkBeanArray ) === TRUE || $regetFlg === TRUE ) {
			$this -> setTalkBeanArray();
		} else {
			;
		}
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
	public function setSearchUserId( $searchUserId ) {
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
	
	//-------------------------------------- public -----------------------------------------
	
	/**
	 * トークビーン配列初期化
	 */
	public function resetTalkBeanArray() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$this -> talkBeanArray = NULL;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	//--------------------------------------- private ---------------------------------------------
	
	/**
	 * トークデータ取得
	 */
	private function setTalkBeanArray() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$talkDataValueArray = DataClassFactory::getTalkDataObj() -> getData( $this -> getRecordCount, $this -> searchTalkSeqId, $this -> searchUserId, $this -> searchThemeId, $this -> startTalkSeqId );
		
		$talkBeanArray = array();
		foreach ( $talkDataValueArray as $data ) {
			$seqId    = $data['seq_id'];
			$userId   = $data['user_id'];
			$themeId  = $data['theme_id'];
			$talk     = $data['talk'];
			$talkType = $data['talk_type'];
			$talkDate = $data['talk_date'];
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'seqId:'    . $seqId );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userId:'   . $userId );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'themeId:'  . $themeId );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talk:'     . $talk );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkType:' . $talkType );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkDate:' . $talkDate );
			
			$talkBean = new TalkBean();
			$talkBean -> setTaklSeqId( $seqId );
			$talkBean -> setTalkUserId( $userId );
			$talkBean -> setThemeId( $themeId );
			$talkBean -> setTalk( $talk );
			$talkBean -> setTalkType( $talkType );
			$talkBean -> setTalkDate( $talkDate );
			$talkBeanArray[] = $talkBean;
		}
		
		$this -> talkBeanArray = $talkBeanArray;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
	}
	
	
	
}