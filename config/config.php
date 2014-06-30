<?php 
return array(
	//调试
	'DEBUG' => true,							//是否开启调试

	//数据库
	'DB_ON' => true,							//是否开启数据库
	'DB_TYPE' => 'mysql',						//数据库类型
	'DB_HOST' => 'localhost',					//数据库域名
	'DB_NAME' => 'sharefun',					//数据库名字
	'DB_USER' => 'root',						//数据库用户名
	'DB_PWD' => '2011',							//数据库密码
	'DB_PORT' => '3306',						//数据库端口
	'DB_PREFIX' => '',							//数据库表前缀

	//系统默认参数
	'SYS_DEFAULT_FORMAT' => 'json',				//默认返回数据格式：json/xml/array
	'SYS_DEFAULT_PROTOCL' => 'http',			//默认请求协议：rpc/soap/http
	'SYS_DEFAULT_CONTROLLER' => 'Default',		//默认控制器
	'SYS_DEFAULT_ACTION' => 'action',			//默认方法
	'SYS_DEFAULT_LANGUAGE' => 'CN',				//默认语言包

	//验证
	'VERIFY_APP_KEY' => false,					//是否开启App Key验证
	'VERIFY_TOKEN' => false,						//是否开启Token验证
	'APP_KEY' => 'quCSUczKBHrKGvjMHIjRurWt',	//App Key
	
	'BAN_IPS' => array(							//禁止的IP段
		array(	'min' => '', 					//起始IP地址
				'max' => '', 					//结束IP地址
				'reason' => '',					//原因
		),
	),
);
?>
