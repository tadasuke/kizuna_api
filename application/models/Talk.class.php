<?php

require_once 'bean/TalkBean.class.php';

class Talk {
	
	const TALK_RESULT_COMPLETE       = '0';
	const TALK_RESULT_THEME_ID_ERROR = '1';
	
	const TALK_USER_DELETE_FLG_FALSE = '0';
	const TALK_USER_DELETE_FLG_TRUE  = '1';
	
	const COMMENT_RESULT_COMPLETE          = '0';
	const COMMENT_RESULT_TALK_SEQ_ID_ERROR = '1';
	
	const COMMENT_USER_DLETE_FLG_FALSE = '0';
	const COMMENT_USER_DLETE_FLG_TRUE  = '1';
	
	// トークシーケンスID
	public static $newTalkSeqNum = NULL;
	
	// コメントシーケンスID
	public static $commentSeqId = NULL;
	
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
			
			
			$test = mb_detect_encoding( $talk );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'test:' . $test );
			
		}
		
		$this -> talkBeanArray = $talkBeanArray;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
	}
	
	//----------------------------------- public static ------------------------------------
	
	/**
	 * トーク実行
	 * @param int $userNum
	 * @param string $themeId
	 * @param string $takl
	 * @return string $result
	 */
	public static function execTalk( $userNum, $themeId, $talk ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:' . $userNum );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'themeId:' . $themeId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talk:'    . $talk );
		
		//------------
		// チェック処理
		//------------
		$result = self::checkTalk( $themeId, $talk );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'result:' . $result );
		if ( strcmp( $result, self::TALK_RESULT_COMPLETE ) != 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
			return $result;
		} else {
			;
		}
		
		// 書き込み
		$talkSeqNum = DataClassFactory::getTalkDataObj() -> insert( $userNum, $themeId, $talk, date( 'YmdHis'), self::TALK_USER_DELETE_FLG_FALSE );
		self::$newTalkSeqNum = $talkSeqNum;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return self::TALK_RESULT_COMPLETE;
		
	}
	
	/**
	 * コメント実行
	 * @param int $userId
	 * @param int $talkSeqId
	 * @param string $comment
	 * @return string $result
	 */
	public static function execComment( $userId, $talkSeqId, $comment ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userId:'    . $userId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkSeqId:' . $talkSeqId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'comment:'   . $comment );
		
		//------------
		// チェック処理
		//------------
		$result = self::checkComment( $talkSeqId );
		if ( strcmp( $result, self::TALK_RESULT_COMPLETE ) != 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
			return $result;
		} else {
			;
		}
		
		// コメント書き込み
		$commentSeqId = DataClassFactory::getCommentDataObj() -> insert( $talkSeqId, $userId, $comment, date( 'YmdHis' ), self::COMMENT_USER_DLETE_FLG_FALSE );
		self::$commentSeqId = $commentSeqId;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
		return $result;
		
	}
	
	//----------------------------------- priavte static ------------------------------------
	
	/**
	 * トークチェック
	 * @param string $themeId
	 * @param string $talk
	 * @return string $result
	 */
	private static function checkTalk( $themeId, $talk ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'themeId:' . $themeId );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talk:'    . $talk );
		
		//---------------
		// テーマIDチェック
		//---------------
		$themeMasterValueArray = DataClassFactory::getThemeMasterObj() -> getDataByThemeId( $themeId );
		
		if ( count( $themeMasterValueArray ) == 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'theme_id_error!!' );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
			return self::TALK_RESULT_THEME_ID_ERROR;
		} else {
			;
		}
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return self::TALK_RESULT_COMPLETE;
		
	}
	
	
	/**
	 * コメントチェック
	 * @param int $talkSeqId
	 */
	private static function checkComment( $talkSeqId ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkSeqId:' . $talkSeqId );
		
		//-----------------------
		// トークシーケンスIDチェック
		//-----------------------
		$talkDataValueArray = DataClassFactory::getTalkDataObj() -> getData( NULL, $talkSeqId );
		if ( count( $talkDataValueArray ) == 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talk_seq_id_error!!' );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
			return self::COMMENT_RESULT_TALK_SEQ_ID_ERROR;
		} else {
			;
		}
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return self::COMMENT_RESULT_COMPLETE;
		
	}
	
}