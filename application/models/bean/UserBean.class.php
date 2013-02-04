<?php

class UserBean {
	
	/**
	 * ユーザID
	 * @var int
	 */
	private $userId = NULL;
	public function setUserId( $userId ) {
		$this -> userId = $userId;
	}
	public function getUserId() {
		return $this -> userId;
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
	
}