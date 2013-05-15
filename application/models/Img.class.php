<?php

require_once 'application/models/bean/ImgBean.class.php';

class Img {
	
	const UPLOAD_IMG_COMPLETE = '0';
	const UPLOAD_IMG_ERROR    = '1';
	
	const USER_DELETE_FLG_FALSE = '0';
	const USER_DELETE_FLG_TRUE  = '1';
	
	/**
	 * ユーザNUM
	 * @var int
	 */
	private $userNum = NULL;
	
	/**
	 * 画像ビーン配列
	 * @var array[ImgBean]
	 */
	private $imgBeanArray = NULL;
	
	/**
	 * コンストラクタ
	 * @param int $userNum
	 */
	public function __construct( $userNum ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:' . $userNum );
		
		$this -> userNum = $userNum;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	/**
	 * アルバムに画像追加
	 * @param int $userNum
	 * @param ImgBean $imgBean
	 */
	public function addAlbum( ImgBean $imgBean ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		DataClassFactory::getAlbumDataObj() -> insert( $this -> userNum, $imgBean -> getImgSeqNum(), self::USER_DELETE_FLG_FALSE );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	/**
	 * 画像ビーン配列取得
	 * @return array[ImgBean]
	 */
	public function getImgBeanArray() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	//---------------------------------------- private ----------------------------------------------
	
	/**
	 * 画像ビーン配列設定
	 */
	private function setImgBeanArray() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		
		
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	
	//---------------------------------------- static ----------------------------------------------
	public static $newImgSeqNum = NULL;
	public static $newImgKey = NULL;
	
	/**
	 * 画像アップロード
	 * @param string $img
	 * @param string $imgFileName
	 * @param string $imgType
	 * @param int $imgSize
	 */
	public static function uploadImg( $img, $imgFileName, $imgType, $imgSize ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgFileName:' . $imgFileName );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgType:'     . $imgType );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgSize:'     . $imgSize );
		
		// 画像キー取得
		$imgKey = Library::string2hash( microtime() . $fileName . $imgSize );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgKey:' . $imgKey );
		
		// 画像データインサート
		$imgSeqNum = DataClassFactory::getImgDataObj() -> insert( $imgKey, $img, $imgFileName, $imgType, $imgSize );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgSeqNum:' . $imgSeqNum );
		
		self::$newImgSeqNum = $imgSeqNum;
		self::$newImgKey    = $imgKey;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return self::UPLOAD_IMG_COMPLETE;
		
	}
	
	
	/**
	 * 画像取得
	 * @param string $imgKey
	 * @return ImgBean
	 */
	public static function getImgByImgKey( $imgKey ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'imgKey:' . $imgKey );
		
		$imgBean = NULL;
		
		$valueArray = DataClassFactory::getImgDataObj() -> getDataByImgKey( $imgKey );
		if ( count( $valueArray ) > 0 ) {
			$imgBean = new ImgBean();
			$imgBean -> setImgSeqNum( $valueArray[0]['img_seq_num'] );
			$imgBean -> setImgKey( $valueArray[0]['img_key'] );
			$imgBean -> setImg( $valueArray[0]['img'] );
			$imgBean -> setImgFileName( $valueArray[0]['img_file_name'] );
			$imgBean -> setImgType( $valueArray[0]['img_type'] );
			$imgBean -> setImgSize( $valueArray[0]['img_size'] );
		} else {
			;
		}
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $imgBean;
		
	}
}