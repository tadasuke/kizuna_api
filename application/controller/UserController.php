<?php

class UserController extends KizunaBaseController {
	
	/**
	 * ユーザデータ取得
	 */
	public function getUserDataAction() {
		
		AK_Log::getLogClass() -> log( AK_Log::INFO, __METHOD__, __LINE__, 'START' );
		
		$userDataArray = array();
		
		$targetUserKeyCsv = $this -> getGetAndPostParam( 'target_user_key' );
		$getParamCsv = $this -> getGetAndPostParam( 'get_param' );
		
		//---------------------
		// 取得パラメータ配列を作成
		//---------------------
		$getParamArray = array( 'user_key', 'name' );
		if ( strlen( $getParamCsv ) > 0 ) {
			foreach ( explode( ',', $getParamCsv ) as $param ) {
				$getParamArray[] = $param;
			}
		}
		$getParamArray = array_unique( $getParamArray );
		
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
				$userData = array(
					  'user_key'           => $userBean -> getUserKey()
					, 'name'               => $userBean -> getUserName()
				);
				// 性別
				if ( in_array( 'gender', $getParamArray ) === TRUE ) {
					$userData['gender'] = $userBean -> getGender();
				} else {
					;
				}
				// 誕生日
				if ( in_array( 'birthday', $getParamArray ) === TRUE ) {
					$userData['birthday'] = $userBean -> getBirthday();
				} else {
					;
				}
				// 電話番号１
				if ( in_array( 'telephone_number_1', $getParamArray ) === TRUE ) {
					$userData['telephone_number_1'] = $userBean -> getTelephoneNumber1();
				} else {
					;
				}
				// 電話番号２
				if ( in_array( 'telephone_number_2', $getParamArray ) === TRUE ) {
					$userData['telephone_number_2'] = $userBean -> getTelephoneNumber2();
				} else {
					;
				}
				// プロフィール画像キー
				if ( in_array( 'profile_img_key', $getParamArray ) === TRUE ) {
					$userData['profile_img_key'] = $userBean -> getProfileImgKey();
				} else {
					;
				}
				// ユーザ属性
				if ( strcmp( $this -> playerUserNum, $targetUserNum ) == 0 ) {
					$userData['identify_person_type'] = User::PERSONAL_USER_DATA;
				} else {
					$userData['identify_person_type'] = User::OTHER_USER_DATA;
				}
				
				$userDataArray[] = $userData;
			} else {
				;
			}
			
		}
		
		// レスポンス設定
		$this -> setResponseParam( array( 'user_data' => $userDataArray ) );
		
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