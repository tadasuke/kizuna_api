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
	public static $newCommentSeqNum = NULL;
	
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
	 * 検索トークNum
	 * @var int
	 */
	private $searchTalkSeqNum = NULL;
	public function setSearchTalkSeqNum( $searchTalkSeqNum ) {
		$this -> searchTalkSeqNum = $searchTalkSeqNum;
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
	 * 検索ユーザNum
	 * @var string
	 */
	private $searchUserNum = NULL;
	public function setSearchUserNum( $searchUserNum ) {
		$this -> searchUserNum = $searchUserNum;
	}
	
	/**
	 * 取得トーク数
	 * @var int
	 */
	private $getRecordCount = NULL;
	public function setGetRecordCount( $getRecordCount ) {
		$this -> getRecordCount = $getRecordCount;
	}
	
	/**
	 * 検索開始トークシーケンスNum
	 * @var int
	 */
	private $startTalkSeqNum = NULL;
	public function setStartTalkSeqNum( $startTalkSeqNum ) {
		$this -> startTalkSeqNum = $startTalkSeqNum;
	}

	/**
	 * 検索ワード
	 * @var string
	 */
	private $searchWord = NULL;
	public function setSearchWord( $searchWord ) {
		$this -> searchWord = $searchWord;
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
		
		$talkDataValueArray = DataClassFactory::getTalkDataObj() -> getData(
				  $this -> getRecordCount
				, $this -> searchTalkSeqNum
				, $this -> searchUserNum
				, $this -> searchThemeId
				, $this -> startTalkSeqNum
				, self::TALK_USER_DELETE_FLG_FALSE
				, $this -> searchWord
		);
		
		$talkBeanArray = array();
		foreach ( $talkDataValueArray as $data ) {
			$seqNum   = $data['seq_num'];
			$userNum  = $data['user_num'];
			$themeId  = $data['theme_id'];
			$talk     = $data['talk'];
			$talkDate = $data['talk_date'];
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'seqNum:'   . $seqNum );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:'  . $userNum );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'themeId:'  . $themeId );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talk:'     . $talk );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkDate:' . $talkDate );
			
			$talkBean = new TalkBean();
			$talkBean -> setTaklSeqNum( $seqNum );
			$talkBean -> setTalkUserNum( $userNum );
			$talkBean -> setThemeId( $themeId );
			$talkBean -> setTalk( $talk );
			$talkBean -> setTalkDate( $talkDate );
			$talkBeanArray[] = $talkBean;
			
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
	 * @param int $userNUm
	 * @param int $talkSeqNum
	 * @param string $comment
	 * @return string $result
	 */
	public static function execComment( $userNUm, $talkSeqNum, $comment ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNUm:'    . $userNUm );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkSeqNum:' . $talkSeqNum );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'comment:'    . $comment );
		
		//------------
		// チェック処理
		//------------
		$result = self::checkComment( $talkSeqNum );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'result:' . $result );
		if ( strcmp( $result, self::TALK_RESULT_COMPLETE ) != 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
			return $result;
		} else {
			;
		}
		
		// コメント書き込み
		$commentSeqNum = DataClassFactory::getCommentDataObj() -> insert( $talkSeqNum, $userNUm, $comment, date( 'YmdHis' ), self::COMMENT_USER_DLETE_FLG_FALSE );
		self::$newCommentSeqNum = $commentSeqNum;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
		return $result;
		
	}
	
	
	/**
	 * テーマ取得
	 * @param string $themeId
	 * @return array
	 */
	public static function getTheme( $themeId = NULL ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'themeId:' . $themeId );
		
		$themeArray = array();
		
		$valueArray = DataClassFactory::getThemeMasterObj() -> getDataByThemeId( $themeId );
		
		foreach ( $valueArray as $data ) {
			$themeArray[] = array(
				  'theme_id'   => $data['theme_id']
				, 'theme_name' => $data['theme_name']
				, 'templete'   => $data['template']
			);
		}
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $themeArray;
		
	}
	
	/**
	 * トークデータ更新
	 * @param string $userNum
	 * @param string $seq_num
	 * @param string $theme_id
	 * @param string $talk
	 */
	public static function updateTalkData( $userNum, $seq_num, $theme_id, $talk ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:'  . $userNum );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'seq_num:'  . $seq_num );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'theme_id:' . $theme_id );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talk:'     . $talk );

		//------------
		// チェック処理
		//------------
		$result = self::checkTalk( $theme_id, $talk );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'result:' . $result );
		if ( strcmp( $result, self::TALK_RESULT_COMPLETE ) != 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
			return $result;
		} else {
			;
		}

        // 更新カラム配列の設定
        $updateArray = array();
		if ( strlen( $talk ) > 0 ) {
			$updateArray['talk'] = $talk;
		} else {
			;
		}
		$updateArray['talk_date'] = date( 'YmdHis' );
		$updateArray['update_time'] = date( 'YmdHis' );
		
        // 書き込み
		DataClassFactory::getTalkDataObj() -> update( $userNum, $seq_num, self::TALK_USER_DELETE_FLG_FALSE, $updateArray );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
        
	}

    /**
	 * トークデータ削除
	 * @param string $userNum
	 * @param string $seq_num
	 */
	public static function deleteTalkData( $userNum, $seq_num ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:'  . $userNum );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'seq_num:'  . $seq_num );

        // 更新カラム配列の設定
        $updateArray = array();
		$updateArray['user_delete_flg'] = self::TALK_USER_DELETE_FLG_TRUE;
		$updateArray['update_time'] = date( 'YmdHis' );

        // 書き込み
		DataClassFactory::getTalkDataObj() -> update( $userNum, $seq_num, self::TALK_USER_DELETE_FLG_FALSE, $updateArray );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
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
	 * @param int $talkSeqNum
	 */
	private static function checkComment( $talkSeqNum ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'talkSeqNum:' . $talkSeqNum );
		
		//-----------------------
		// トークシーケンスIDチェック
		//-----------------------
		$talkDataValueArray = DataClassFactory::getTalkDataObj() -> getData( NULL, $talkSeqNum );
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