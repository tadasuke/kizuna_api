<?php

require_once 'Akatsuki/AK_Ini.php';
require_once 'Akatsuki/AK_Core.php';
require_once 'Akatsuki/AK_Registry.php';
require_once 'Akatsuki/AK_Log.php';
require_once 'Akatsuki/AK_Db.php';
require_once 'Akatsuki/AK_Gadget.php';

define( 'BASE_PATH', '/web/api_ki2na/' );

set_include_path( get_include_path() . PATH_SEPARATOR . BASE_PATH );
require_once 'application/controller/KizunaBaseController.php';
require_once 'application/models/db/DataClassFactory.class.php';
require_once 'application/models/UserFactory.class.php';
require_once 'application/models/KizunaException.class.php';
require_once 'application/models/ini/DbIni.class.php';
require_once 'application/models/ini/SystemIni.class.php';
require_once 'application/lib/Define.php';

// 設定情報登録
AK_Ini::setConfigFromArray( DbIni::$configArray );
AK_Ini::setConfigFromArray( SystemIni::$configArray );

// インスタンス取得
$akCoreClass = AK_Core::getInstance();
// コントローラディレクトリ設定
$akCoreClass -> setControllerDir( BASE_PATH . 'application/controller' );
// 処理開始
$akCoreClass -> run();
