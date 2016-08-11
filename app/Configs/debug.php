<?php

//Socketlog配置
return [
	//socketlog影响性能,仅仅在开发环境上使用
	'socketlog_config'  =>  [
		'host'=>'',//websocket服务器地址，默认localhost
		'port'=>'1229',//websocket服务器端口，默认端口是1229
		'optimize'=>true,//是否显示利于优化的参数，如果运行时间，消耗内存等，默认为false
		'show_included_files'=>true,//是否显示本次程序运行加载了哪些文件，默认为false
		'error_handler'=>true,//是否接管程序错误，将程序错误显示在console中，默认为false
		'force_client_id'=>'',//日志强制记录到配置的client_id,默认为空
		'allow_client_ids'=>array('')////限制允许读取日志的client_id
	],
];