<?php

class UserController extends KizunaBaseController {
	
	/**
	 * ユーザデータ取得
	 */
	public function getUserDataAction() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$targetUserKey = $this -> getParam( 'target_user_key' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'targetUserKey:' . $targetUserKey );
		
		$targetUserNum = User::getUserNumByUserKey( $targetUserKey );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'targetUserNum:' . $targetUserNum );
		
		$targetUserObj = UserFactory::get( $targetUserNum );
		
		// ユーザデータ取得
		$userBean = $targetUserObj -> getUserBean();
		
		// ユーザビーンが取得できた場合
		if ( is_null( $userBean ) === FALSE ) {
			$userData = array(
				  'user_key'           => $targetUserKey
				, 'name'               => $userBean -> getUserName()
				, 'gender'             => $userBean -> getGender() ?: ''
				, 'birthday'           => $userBean -> getBirthday() ?: ''
				, 'telephone_number_1' => $userBean -> getTelephoneNumber1() ?: ''
				, 'telephone_number_2' => $userBean -> getTelephoneNumber2() ?: ''
				, 'profile_img_key'    => $userBean -> getProfileImgKey() ?: ''
			);
		} else {
			$userData = array();
		}
		
		// レスポンス設定
		$this -> setResponseParam( array( 'user_data' => $userData ) );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	/**
	 * ユーザデータ変更
	 */
	public function updateUserDataAction() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$gender           = $this -> getParam( 'gender' );
		$birthday         = $this -> getParam( 'birthday' );
		$address          = $this -> getParam( 'address' );
		$telephoneNumber1 = $this -> getParam( 'telephone_number_1' );
		$telephoneNumber2 = $this -> getParam( 'telephone_number_2' );
		$profileImgKey    = $this -> getParam( 'profile_img_key' );
		
		$userObj = UserFactory::get( $this -> playerUserNum );
		$userObj -> updateUserData( $gender, $birthday, $address, $telephoneNumber1, $telephoneNumber2, $profileImgKey );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		$this -> setResponseParam( array( 'result' => '0' ) );
		
	}
	
}