<?php

class UserController extends KizunaBaseController {
	
	/**
	 * ユーザ名取得
	 */
	public function getUserDataAction() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$targetUserKey = $this -> getParam( 'target_user_key' );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'targetUserKey:' . $targetUserKey );
		
		$targetUserNum = User::getUserIdFromUserKey( $targetUserKey );
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'targetUserNum:' . $targetUserNum );
		
		$targetUserObj = UserFactory::get( $targetUserNum );
		
		// ユーザデータ取得
		$userBean = $targetUserObj -> getUserBean();
		
		// レスポンス作成
		$userDataArray = array( 'user_data' => array( 
			  'user_key'           => $targetUserKey
			, 'name'               => $userBean -> getUserName()
			, 'gender'             => $userBean -> getGender() ?: ''
			, 'birthday'           => $userBean -> getBirthday() ?: ''
			, 'telephone_number_1' => $userBean -> getTelephoneNumber1() ?: ''
			, 'telephone_number_2' => $userBean -> getTelephoneNumber2() ?: ''
		) );
		
		$this -> setResponseParam( $userDataArray );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
}