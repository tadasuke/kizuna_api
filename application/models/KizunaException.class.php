<?php

class KizunaException extends Exception {
	
	public function __construct( $errno, $errstr, $errfile, $errline ) {
		$this -> message = $errstr;
		$this -> file    = $errfile;
		$this -> line    = $errline;
	}
}
	
function myErrorHandler( $errno, $errstr, $errfile, $errline ) {

	if (!(error_reporting() & $errno)) {
		return;
	}
	
	switch ( $errno ) {
		case E_USER_NOTICE :
			return;
			break;
	}
	
	throw( new KizunaException( $errno, $errstr, $errfile, $errline) );

}
	