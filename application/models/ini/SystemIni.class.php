<?php

class SystemIni extends AK_Ini {
	
	public $configArray = array(
		// システム設定
		'system_config' => array(
			'cookie_config' => array(
				  'login_key_name'      => 'login_key'
				, 'keep_time'           => 604800 // 一週間
				, 'login_key_delimiter' => '__'
			)
			, 'log_config' => array(
				'path' => '/var/log/ki2na/api'
			)
		)
		// トーク設定
		, 'talk_config' => array(
			  'def_get_talk_data_count' => 10
			, 'max_get_talk_data_count' => 50
		)
	);
	
}