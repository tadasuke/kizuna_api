<?php

/**
 * 共通処理コントローラ
 * @author tadasuke
 */
class SampleController extends AK_BaseController {
	
	public function getNameAction() {
		
		$userId = $this -> getGetParam( 'user_id' );
		
		$name = '';
		switch ( $userId ) {
			case '1' :
				$name = 'naoya';
				break;
			case '2' :
				$name = 'tadasuke';
				break;
			case '3' :
				$name = 'yosuke';
				break;
			case '4' :
				$name = 'hideyuki';
				break;
			case '5' :
				$name = 'yuichi';
				break;
			case '6' :
				$name = 'hideki';
				break;
			case '7' :
				$name = 'naoya_sub';
				break;
			case '8' :
				$name = 'naoto';
				break;
			default :
				$name = 'no_user';
				break;
		}
		
		$responseArray = array( 'name' => $name );
		
		$this -> setResponseParam( $responseArray );
		
	}
	
}