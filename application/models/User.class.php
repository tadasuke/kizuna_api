<?php

require_once 'bean/UserBean.class.php';

class User {
	
	private $userId = NULL;
	
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
	 * コンストラクタ
	 * @param int $userId
	 */
	public function __construct( $userId ) {
		$this -> userId = $userId;
	}
	
	//--------------------------- private ---------------------------------
	
	/**
	 * ユーザビーン設定
	 */
	private function setUserBean() {
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		// ユーザパーソナルデータ取得
		$userPersonalDataValueArray = DataClassFactory::getUserPersonalDataObj() -> getDataByUserId( $this -> userId );
		$name              = $userPersonalDataValueArray[0]['name'];
		$gender            = $userPersonalDataValueArray[0]['gender'];
		$birthday          = AK_Gadget::dateFormat( $userPersonalDataValueArray[0]['birthday'], 'Ymd'  );
		$telephoneNumber_1 = $userPersonalDataValueArray[0]['telephone_number_1'];
		$telephoneNumber_2 = $userPersonalDataValueArray[0]['telephone_number_2'];
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'name:'              . $name );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'gender:'            . $gender );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'birthday:'          . $birthday );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'telephoneNumber_1:' . $telephoneNumber_1 );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'telephoneNumber_2:' . $telephoneNumber_2 );
		
		$userBean = new UserBean();
		$userBean -> setUserId( $this -> userId );
		$userBean -> setUserName( $name );
		$userBean -> setGender( $gender );
		$userBean -> setBirthday( $birthday );
		$userBean -> setTelephoneNumber1( $telephoneNumber_1 );
		$userBean -> setTelephoneNumber2( $telephoneNumber_2 );
		
		$this -> userBean = $userBean;
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	//-------------------------- public static -----------------------------------
	
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
	 * ユーザID取得
	 * @param string $userKey
	 * @return int $userId
	 */
	public static function getUserIdFromUserKey( $userKey ) {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'userKey:' . $userKey );
		
		$userId = NULL;
		
		$userBasicDataValueArray = DataClassFactory::getUserBaslcDataObj() -> getDataByUserKey( $userKey );
		if ( count( $userBasicDataValueArray ) > 0 ) {
			$userId = $userBasicDataValueArray[0]['user_id'];
		} else {
			;
		}
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		return $userId;
		
	}
	
}