<?php


require_once '/usr/local/include/php/Zend/Debug.php';





require_once '/usr/local/include/php/Akatsuki/AK_Ini.php';
require_once '/usr/local/include/php/Akatsuki/AK_Config.php';
require_once '/usr/local/include/php/Akatsuki/AK_Core.php';
require_once '/usr/local/include/php/Akatsuki/AK_Registry.php';
require_once '/usr/local/include/php/Akatsuki/AK_Log.php';
require_once '/usr/local/include/php/Akatsuki/AK_Db.php';
require_once '/usr/local/include/php/Akatsuki/AK_Gadget.php';
require_once '/usr/local/include/php/Akatsuki/AK_Exception.php';

//define( 'BASE_PATH', '/web/api_ki2na/' );
define( 'BASE_PATH', '/web/miyashita_api_ki2na/' );

set_include_path( get_include_path() . PATH_SEPARATOR . BASE_PATH );

define( 'MODELS_PATH', 'application/models/' );

require_once 'application/controller/KizunaBaseController.php';
require_once MODELS_PATH . 'db/DataClassFactory.class.php';
require_once MODELS_PATH . 'UserFactory.class.php';
require_once MODELS_PATH . 'common/KizunaException.class.php';
require_once MODELS_PATH . 'Library.class.php';
require_once MODELS_PATH . 'ini/DbIni.class.php';
require_once MODELS_PATH . 'ini/SystemIni.class.php';
require_once 'application/Define.php';

// 設定情報登録
$ini = new DbIni();
AK_Config::setConfigFromArray( $ini -> configArray );
$ini = new SystemIni();
AK_Config::setConfigFromArray( $ini -> configArray );

// インスタンス取得
$akCoreClass = AK_Core::getInstance();
// コントローラディレクトリ設定
$akCoreClass -> setControllerDir( BASE_PATH . 'application/controller' );

try {

	// 処理開始
	$akCoreClass -> run();

	// 例外処理
} catch ( Exception $e ) {

	if ( $e instanceof KizunaException ) {
		$logLevel = $e -> getOutLogLevel();
		$responseErrorType = $e -> getResponseErrType();
	} else {
		$logLevel = AK_Log::EMERG;
		$responseErrorType = RESULT_SERVER_ERROR;
	}
	
	// エラーログ出力
	AK_Log::getLogClass() -> log( $logLevel, $e -> getFile(), $e -> getLine(), $e -> getCode() . ':' . $e -> getMessage() );

	// リクエストオブジェクト取得
	$requestObj = $akCoreClass -> getRequestObj();

	// リクエストオブジェクトが取得できた場合
	if ( is_null( $requestObj ) === FALSE ) {

		// サーバエラーコード設定
		AK_Registry::set( REGISTRY_SERVER_ERROR_KEY_NAME, $responseErrorType );
		// DBコミットフラグを下げる
		AK_Registry::set( REGISTRY_DB_COMMIT_FLG_KEY_NAME, FALSE );
		
		$requestObj -> afterRun();
		$requestObj -> terminal();

	} else {
		;
	}

}
