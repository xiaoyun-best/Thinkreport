<?php
return array(
	'DEFAULT_MODULE'=>'Admin',
	'LAYOUT_ON'=>true,//开启模板布局
	'LAYOUT_NAME'=>'Layouts/admin',
	'URL_MODEL'          => '2', //URL模式
             'SESSION_AUTO_START' => true, //是否开启session
             'DEFAULT_AJAX_RETURN'   =>  'JSON',
	//数据库配置信息
	'DB_TYPE'           => 'mysql',
	'DB_HOST'           => '127.0.0.1',
	'DB_NAME'           =>'pet',
	'DB_USER'           =>'root',
	'DB_PWD'            =>'root',
	'DB_PORT'           =>'3306',
	'DB_PREFIX'         =>'tbl',

);