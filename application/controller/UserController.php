<?php

class UserController extends KizunaBaseController {
	
	/**
	 * ユーザデータ取得
	 */
	public function getUserDataAction() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$userDataArray = array();
		
		$targetUserKeyCsv = $this -> getGetAndPostParam( 'target_user_key' );
		
		$targetUserNumArray = array();
		
		// ターゲットユーザキーが設定されていた場合
		if ( strlen( $targetUserKeyCsv ) > 0 ) {
			// カンマ区切りのCSVを配列にする
			$targetUserKeyArray = explode( ',', $targetUserKeyCsv );
			foreach ( $targetUserKeyArray as $targetUserKey ) {
				AK_Log::getLogClass() -> log( AK_Log::DEBUG, __METHOD__, __LINE__, 'targetUserKey:' . $targetUserKey );
				// ユーザキーを元にユーザNUMを取得
				$targetUserNumArray[] = User::getUserNumByUserKey( $targetUserKey );
			}
		// ターゲットユーザキーが設定されていなかった場合
		} else {
			// DBから全ユーザ基本データを取得
			$userBascicDataArray = User::getAllUserBaiscData();
			foreach ( $userBascicDataArray as $data ) {
				$targetUserNumArray[] = $data['user_num'];
			}
		}
		
		foreach ( $targetUserNumArray as $targetUserNum ) {
			$targetUserObj = UserFactory::get( $targetUserNum );
			
			// ユーザデータ取得
			$userBean = $targetUserObj -> getUserBean();
			
			// ユーザビーンが取得できた場合
			if ( is_null( $userBean ) === FALSE ) {
				$userData[] = array(
					  'user_key'           => $userBean -> getUserKey()
					, 'name'               => $userBean -> getUserName()
					, 'gender'             => $userBean -> getGender() ?: ''
					, 'birthday'           => $userBean -> getBirthday() ?: ''
					, 'telephone_number_1' => $userBean -> getTelephoneNumber1() ?: ''
					, 'telephone_number_2' => $userBean -> getTelephoneNumber2() ?: ''
					, 'profile_img_key'    => $userBean -> getProfileImgKey() ?: ''
				);
			} else {
				;
			}
			
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
		
		$gender           = $this -> getGetAndPostParam( 'gender' );
		$birthday         = $this -> getGetAndPostParam( 'birthday' );
		$address          = $this -> getGetAndPostParam( 'address' );
		$telephoneNumber1 = $this -> getGetAndPostParam( 'telephone_number_1' );
		$telephoneNumber2 = $this -> getGetAndPostParam( 'telephone_number_2' );
		$profileImgKey    = $this -> getGetAndPostParam( 'profile_img_key' );
		
		$userObj = UserFactory::get( $this -> playerUserNum );
		$userObj -> updateUserData( $gender, $birthday, $address, $telephoneNumber1, $telephoneNumber2, $profileImgKey );
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'END' );
		$this -> setResponseParam( array( 'result' => '0' ) );
		
	}
	
}