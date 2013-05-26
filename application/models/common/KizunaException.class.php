<?php

class KizunaException extends AK_Excepiton {
	
	/**
	 * 出力ログレベル
	 * @var int
	 */
	private $outLogLevel = NULL;
	public function setOutLogLevel( $outLogLevel ) {
		$this -> outLogLevel = $outLogLevel;
	}
	public function getOutLogLevel() {
		return $this -> outLogLevel;
	}
	
	/**
	 * レスポンスエラータイプ
	 * @var string
	 */
	private $responseErrType = NULL;
	public function setResponseErrType( $responseErrType ) {
		$this -> responseErrType = $responseErrType;
	}
	public function getResponseErrType() {
		return $this -> responseErrType;
	}
	
	/**
	 * コンストラクタ
	 * @param string $errstr
	 * @param string $errfile
	 * @param string $errline
	 * @param string $outLogLevel
	 * @param string $responseErrType
	 */
	public function __construct( $errstr, $errfile, $errline, $outLogLevel, $responseErrType ) {
		
		echo( 'hoge!!' );
		exit;
		
		$this -> outLogLevel = $outLogLevel;
		$this -> responseErrType = $responseErrType;
		
		parent::__construct( '', $errstr, $errfile, $errline );
		
	}
	
}

function kizunaErrorHandler( $errno, $errstr, $errfile, $errline ) {

	throw new KizunaException( $errstr, $errfile, $errline, AK_Log::EMERG, RESULT_SERVER_ERROR );

}