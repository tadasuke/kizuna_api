<?php

/**
 * 画像ビーン
 * @author tadasuke
 */
class ImgBean {
	
	/**
	 * 画像NUM
	 * @var int
	 */
	private $imgSeqNum = NULL;
	public function setImgSeqNum( $imgSeqNum ) {
		$this -> imgSeqNum = $imgSeqNum;
	}
	public function getImgSeqNum() {
		return $this -> imgSeqNum;
	}
	
	/**
	 * 画像キー
	 * @var int
	 */
	private $imgKey = NULL;
	public function setImgKey( $imgKey ) {
		$this -> imgKey = $imgKey;
	}
	public function getImgKey() {
		return $this -> imgKey;
	}
	
	/**
	 * 画像データ
	 * @var string
	 */
	private $img = NULL;
	public function setImg( $img ) {
		$this -> img = $img;
	}
	public function getImg() {
		return $this -> img;
	}
	
	/**
	 * 画像ファイル名
	 * @var unknown_type
	 */
	private $imgFileName = NULL;
	public function setImgFileName( $imgFileName ) {
		$this -> imgFileName = $imgFileName;
	}
	public function getImgFileName() {
		return $this -> imgFileName;
	}
	
	/**
	 * 画像タイプ
	 * @var string
	 */
	private $imgType = NULL;
	public function setImgType( $imgType ) {
		$this -> imgType = $imgType;
	}
	public function getImgType() {
		return $this -> imgType;
	}
	
	/**
	 * 画像サイズ
	 * @var int
	 */
	private $imgSize = NULL;
	public function setImgSize( $imgSize ) {
		$this -> imgSize = $imgSize;
	}
	public function getImgSize() {
		return $this -> imgSize;
	}
	
	
	
	
	
}