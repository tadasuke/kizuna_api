<?php

class SystemIni {
	
	public static $configArray = array(
		'system_config' => array(
			'cookie_config' => array(
				  'login_key_name'      => 'login_key'
				, 'keep_time'           => 604800 // 一週間
				, 'login_key_delimiter' => '__'
			)
			, 'log_config' => array(
				'path' => '/var/log/kizuna/api_dev'
			)
		)
	);
	
}