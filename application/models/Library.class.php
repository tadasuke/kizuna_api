<?php

class Library {
	
	/**
	 * 文字列をハッシュ化する
	 * @param string $string
	 * @return string
	 */
	public static function string2hash( $string ) {
		return sha1( $string );
	}
	
	
}