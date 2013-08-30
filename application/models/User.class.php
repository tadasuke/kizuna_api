<?php

require_once 'application/models/bean/UserBean.class.php';
require_once 'application/models/Img.class.php';

class User {
	
	const NEW_ENTRY_CHECK_NORMAL             = '0';
	const NEW_ENTRY_CHECK_MAIL_ADDRESS_ERROR = '1';
	const NEW_ENTRY_CHECK_PASSWORD_ERROR     = '2';
	const NEW_ENTRY_CHECK_NAME_ERROR         = '3';
	const NEW_ENTRY_CHECK_REGISTERED_ERROR   = '4';
	
	const USER_STATUS_PRE_MENBER = '0';
	const USER_STATUS_MENBER     = '1';
	 
	const CANCEL_FLG_FALSE = '0';
	const CANCEL_FLG_TRUE  = '1';
	
	/**
	 * ユーザNum
	 * @var int
	 */
	private $userNum = NULL;
	
	/**
	 * ユーザビーン
	 * @var UserBean
	 */
	private $userBean = NULL;
	public function getUserBean( $regetFlg = FALSE ) {
		if ( is_null( $this -> userBean ) === TRUE || $regetFlg === TRUE ) {
			$this -> setUserBean();
		} else {
			;
		}
		return $this -> userBean;
	}
	
	/**
	 * 画像オブジェクト
	 * @var Img
	 */
	private $imgObj = NULL;
	public function getImgObj() {
		if ( is_null( $this -> imgObj ) === TRUE ) {
			$this -> imgObj = new Img( $this -> userNum );
		} else {
			;
		}
		return $this -> imgObj;
	}
	
	
	/**
	 * コンストラクタ
	 * @param int $userNum
	 */
	public function __construct( $userNum ) {
		$this -> userNum = $userNum;
	}
	
	
	/**
	 * ユーザ情報更新
	 * @param string $gender
	 * @param string $birthday
	 * @param string $address
	 * @param string $telephoneNumber1
	 * @param string $telephoneNumber2
	 * @param string $profileImgKey
	 */
	public function updateUserData( $gender, $birthday, $address, $telephoneNumber1, $telephoneNumber2, $profileImgKey ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'gender:'           . $gender );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'birthday:'         . $birthday );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'address:'          . $address );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'telephoneNumber1:' . $telephoneNumber1 );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'telephoneNumber2:' . $telephoneNumber2 );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'profileImgKey:'    . $profileImgKey );
		
		$updateArray = array();
		if ( strlen( $gender ) > 0 ) {
			$updateArray['gender'] = $gender;
		} else {
			;
		}
		if ( strlen( $birthday ) > 0 ) {
			$updateArray['birthday'] = $birthday;
		} else {
			;
		}
		if ( strlen( $address ) > 0 ) {
			$updateArray['address'] = $address;
		} else {
			;
		}
		if ( strlen( $telephoneNumber1 ) > 0 ) {
			$updateArray['telephone_number_1'] = $telephoneNumber1;
		} else {
			;
		}
		if ( strlen( $telephoneNumber2 ) > 0 ) {
			$updateArray['telephpne_number_2'] = $telephoneNumber2;
		} else {
			;
		}
		
		DataClassFactory::getUserPersonalDataObj() -> updatePersonalData( $this -> userNum, $updateArray );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	//--------------------------- private ---------------------------------
	
	/**
	 * ユーザビーン設定
	 */
	private function setUserBean() {
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		// ユーザパーソナルデータ取得
		$userPersonalDataValueArray = DataClassFactory::getUserPersonalDataObj() -> getDataByUserNum( $this -> userNum );
		
		// データが取得できた場合
		if ( count( $userPersonalDataValueArray ) > 0 ) {
			$name              = $userPersonalDataValueArray[0]['name'];
			$gender            = $userPersonalDataValueArray[0]['gender'];
			$birthday          = AK_Gadget::dateFormat( $userPersonalDataValueArray[0]['birthday'], 'Ymd'  );
			$telephoneNumber_1 = $userPersonalDataValueArray[0]['telephone_number_1'];
			$telephoneNumber_2 = $userPersonalDataValueArray[0]['telephone_number_2'];
			$profileImgKey     = $userPersonalDataValueArray[0]['profile_img_key'];
			$userKey           = self::getUserKeyByUserNum( $this -> userNum );
			AK_Log::getLogClass() -> log( AK_Log::DEBUG, __METHOD__, __LINE__, 'name:'              . $name );
			AK_Log::getLogClass() -> log( AK_Log::DEBUG, __METHOD__, __LINE__, 'gender:'            . $gender );
			AK_Log::getLogClass() -> log( AK_Log::DEBUG, __METHOD__, __LINE__, 'birthday:'          . $birthday );
			AK_Log::getLogClass() -> log( AK_Log::DEBUG, __METHOD__, __LINE__, 'telephoneNumber_1:' . $telephoneNumber_1 );
			AK_Log::getLogClass() -> log( AK_Log::DEBUG, __METHOD__, __LINE__, 'telephoneNumber_2:' . $telephoneNumber_2 );
			AK_Log::getLogClass() -> log( AK_Log::DEBUG, __METHOD__, __LINE__, 'profileImgKey:'     . $profileImgKey );
			AK_Log::getLogClass() -> log( AK_Log::DEBUG, __METHOD__, __LINE__, 'userKey:'           . $userKey );
			
			$userBean = new UserBean();
			$userBean -> setUserNum( $this -> userNum );
			$userBean -> setUserName( $name );
			$userBean -> setGender( $gender );
			$userBean -> setBirthday( $birthday );
			$userBean -> setTelephoneNumber1( $telephoneNumber_1 );
			$userBean -> setTelephoneNumber2( $telephoneNumber_2 );
			$userBean -> setProfileImgKey( $profileImgKey );
			$userBean -> setUserKey( $userKey );
			
			$this -> userBean = $userBean;
			
		} else {
			;
		}
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	//-------------------------- public static -----------------------------------
	
	public static $newUserKey      = NULL;
	public static $newHashPassword = NULL;
	
	/**
	 * 新規登録
	 * @param string $mailAddress
	 * @param string $password
	 * @param string $name
	 */
	public static function newEntry( $mailAddress, $password, $name ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'mailAddress:' . $mailAddress );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'password:'    . $password );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'name:'        . $name );
		
		// 登録可否チェック
		$result = self::checkNewEntry( $mailAddress, $password, $name );
		
		if ( strcmp( $result, self::NEW_ENTRY_CHECK_NORMAL ) != 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'new_entry_error!!' );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
			return $result;
		} else {
			;
		}
		
		// パスワードをハッシュ化
		$hashPassword = Library::string2hash( $password );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'hashPassword:' . $hashPassword );
		
		// ユーザキー作成
		$userKey = $mailAddress + time();
		$userKey = Library::string2hash( $userKey );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userKey:' . $userKey );
		
		//---------
		// 新規登録
		//---------
		// ユーザ基本データ作成
		$userNum = self::createUserBasicData( $userKey, $mailAddress, $hashPassword );
		// ユーザパーソナルデータ作成
		self::createUserPersonalData( $userNum, $name );
		
		self::$newUserKey      = $userKey;
		self::$newHashPassword = $hashPassword;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $result;
		
	}
	
	
	/**
	 * 仮登録
	 * @param string $mailAddress
	 * @param string $password
	 * @param string $name
	 */
	public static function newTempEntry( $mailAddress, $password, $name ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'mailAddress:' . $mailAddress );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'password:'    . $password );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'name:'        . $name );
		
		// 登録可否チェック
		$result = self::checkNewEntry( $mailAddress, $password, $name );
		
		if ( strcmp( $result, self::NEW_ENTRY_CHECK_NORMAL ) != 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'new_entry_error!!' );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
			return $result;
		} else {
			;
		}
		
		// パスワードをハッシュ化
		$hashPassword = Library::string2hash( $password );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'hashPassword:' . $hashPassword );
		
		// ユーザキー作成
		$userKey = $mailAddress + time();
		$userKey = Library::string2hash( $userKey );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userKey:' . $userKey );
		
		//------------
		// 新規仮登録
		//------------
		// ユーザ基本データ作成
		$userNum = self::createUserBasicData( $userKey, $mailAddress, $hashPassword );
		// ユーザパーソナルデータ作成
		self::createUserPersonalData( $userNum, $name );
		
		self::$newUserKey      = $userKey;
		self::$newHashPassword = $hashPassword;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $result;
		
	}
	
	
	/**
	 * ユーザデータ取得
	 * メールアドレスとパスワードを元にユーザデータを取得する
	 * @param string $mailAddress
	 * @param string $password
	 * @return array
	 */
	public static function getUserData( $mailAddress, $password ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'mailAddress:' . $mailAddress );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'password:'    . $password );
		
		$retrunArray = array();
		
		// メールアドレスを元にデータを取得
		$userBasicDataObj = DataClassFactory::getUserBaslcDataObj();
		$valueArray = $userBasicDataObj -> getDataByMailAddress( $mailAddress );
		
		// データが取得できなければログイン失敗
		if ( count( $valueArray ) == 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'no_mail_address' );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
			return $retrunArray;
		} else {
			;
		}
		
		// パスワードチェック
		$password = sha1( $password );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'password:' . $password );
		if ( strcmp( $password, $valueArray[0]['password'] ) != 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'password_error' );
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
			return $retrunArray;
		} else {
			;
		}
		
		$retrunArray = array(
			  'user_key' => $valueArray[0]['user_key']
			, 'password' => $valueArray[0]['password']
		);
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $retrunArray;
		
	}
	
	
	/**
	 * ユーザNUM取得
	 * @param string $userKey
	 * @return int $userNum
	 */
	public static function getUserNumByUserKey( $userKey ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userKey:' . $userKey );
		
		$userNum = NULL;
		
		$userBasicDataValueArray = DataClassFactory::getUserBaslcDataObj() -> getDataByUserKey( $userKey );
		if ( count( $userBasicDataValueArray ) > 0 ) {
			$userNum = $userBasicDataValueArray[0]['user_num'];
		} else {
			;
		}
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $userNum;
		
	}
	
	
	/**
	 * ユーザーキー取得
	 * @param int $userNum
	 * @return string $userKey
	 */
	public static function getUserKeyByUserNum( $userNum ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:' . $userNum );
		
		$userKey = NULL;
		
		$valueArray = DataClassFactory::getUserBaslcDataObj() -> getDataByUserNum( $userNum );
		if ( count( $valueArray ) > 0 ) {
			$userKey = $valueArray[0]['user_key'];
		} else {
			;
		}
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userKey:' . $userKey );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $userKey;
		
	}
	
	
	/**
	 * ユーザ名取得
	 * ユーザNUMを元にユーザ名を取得
	 * @param int $userNum
	 */
	public static function getUserNameByUserNum( $userNum ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:' . $userNum );
		
		$userName = '';
		
		$valueArray = DataClassFactory::getUserPersonalDataObj() -> getDataByUserNum( $userNum );
		if ( count( $valueArray ) > 0 ) {
			$userName = $valueArray[0]['name'];
		} else {
			;
		}
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $userName;
		
	}
	
	
	/**
	 * 全ユーザ基本データ取得
	 */
	public static function getAllUserBaiscData() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$valueArray = DataClassFactory::getUserBaslcDataObj() -> getAllData();
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $valueArray;
		
	}
	
	
	//------------------------------- private static ----------------------------------
	
	/**
	 * 新規登録可否チェック
	 * @param string $mailAddress
	 * @param string $password
	 * @param string $name
	 */
	private static function checkNewEntry( $mailAddress, $password, $name ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'mailAddress:' . $mailAddress );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'password:'    . $password );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'name:'        . $name );
		
		//--------------------
		// メールアドレスチェック
		//--------------------
		if ( strlen( $mailAddress ) <= 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'mail_address_error' );
			return self::NEW_ENTRY_CHECK_MAIL_ADDRESS_ERROR;
		} else {
			;
		}
		
		//-----------------
		// パスワードチェック
		//-----------------
		if ( strlen( $password ) <= 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'password_error' );
			return self::NEW_ENTRY_CHECK_PASSWORD_ERROR;
		} else {
			;
		}
		
		//------------
		// 名前チェック
		//------------
		if ( strlen( $name ) <= 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'name_error' );
			return self::NEW_ENTRY_CHECK_NAME_ERROR;
		} else {
			;
		}
		
		//-------------------------
		// メールアドレス登録済チェック
		//-------------------------
		$valueArray = DataClassFactory::getUserBaslcDataObj() -> getDataByMailAddress( $mailAddress );
		if ( count( $valueArray ) > 0 ) {
			AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'regstered_mail_address!!' );
			return self::NEW_ENTRY_CHECK_REGISTERED_ERROR;
		} else {
			;
		}
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return self::NEW_ENTRY_CHECK_NORMAL;
		
	}
	
	
	/**
	 * ユーザ基本データ作成
	 * @param string $userKey
	 * @param string $mailAddress
	 * @param string $password
	 * @return int $userNum
	 */
	private static function createUserBasicData( $userKey, $mailAddress, $hashPassword ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userKey:'      . $userKey );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'mailAddress:'  . $mailAddress );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'hashPassword:' . $hashPassword );
		
		$userNum = DataClassFactory::getUserBaslcDataObj() -> insert( $userKey, $mailAddress, $hashPassword, self::USER_STATUS_PRE_MENBER, date( 'YmdHis' ), self::CANCEL_FLG_FALSE );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:' . $userNum );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $userNum;
		
	}
	
	
	/**
	 * ユーザパーソナルデータ作成
	 * @param int $userNum
	 * @param string $name
	 */
	private static function createUserPersonalData( $userNum, $name ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userNum:' . $userNum );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'name:'    . $name );
		
		DataClassFactory::getUserPersonalDataObj() -> simpleInsert( $userNum, $name );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
}