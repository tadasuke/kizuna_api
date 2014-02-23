<?php

class UserBean {
	
	/**
	 * ユーザNum
	 * @var int
	 */
	private $userNum = NULL;
	public function setUserNum( $userNum ) {
		$this -> userNum = $userNum;
	}
	public function getUserNum() {
		return $this -> userNum;
	}
	
	
	/**
	 * ユーザキー
	 * @var int
	 */
	private $userKey = NULL;
	public function setUserKey( $userKey ) {
		$this -> userKey = $userKey;
	}
	public function getUserKey() {
		return $this -> userKey;
	}
	
	
	/**
	 * メールアドレス
	 * @var int
	 */
	private $mailAddress = NULL;
	public function setMailAddress( $mailAddress ) {
		$this -> mailAddress = $mailAddress;
	}
	public function getMailAddress() {
		return $this -> mailAddress;
	}
	
	
	/**
	 * ユーザ名
	 * @var string
	 */
	private $userName = NULL;
	public function setUserName( $userName ) {
		$this -> userName = $userName;
	}
	public function getUserName() {
		return $this -> userName;
	}
	
	/**
	 * 性別
	 * @var string
	 */
	private $gender = NULL;
	public function setGender( $gender ) {
		$this -> gender = $gender;
	}
	public function getGender() {
		return $this -> gender;
	}
	
	/**
	 * 誕生日
	 * @var string
	 */
	private $birthday = NULL;
	public function setBirthday( $birthday ) {
		$this -> birthday = $birthday;
	}
	public function getBirthday() {
		return $this -> birthday;
	}
	
	/**
	 * 住所
	 * @var string
	 */
	private $address = NULL;
	public function setAddress( $address ) {
		$this -> address = $address;
	}
	public function getAddress() {
		return $this -> address;
	}
	
	/**
	 * 電話番号１
	 * @var string
	 */
	private $telephoneNumber_1 = NULL;
	public function setTelephoneNumber1( $telephoneNumber_1 ) {
		$this -> telephoneNumber_1 = $telephoneNumber_1;
	}
	public function getTelephoneNumber1() {
		return $this -> telephoneNumber_1;
	}
	
	/**
	 * 電話番号２
	 * @var string
	 */
	private $telephoneNumber_2 = NULL;
	public function setTelephoneNumber2( $telephoneNumber_2 ) {
		$this -> telephoneNumber_2 = $telephoneNumber_2;
	}
	public function getTelephoneNumber2() {
		return $this -> telephoneNumber_2;
	}
	
	/**
	 * プロフィール画像キー
	 * @var string
	 */
	private $profileImgKey = NULL;
	public function setProfileImgKey( $profileImgKey ) {
		$this -> profileImgKey = $profileImgKey;
	}
	public function getProfileImgKey() {
		return $this -> profileImgKey;
	}
}