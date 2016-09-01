<?php

//mysql配置
$database = [];

switch (PROJ_ENV) {
	case 'test':
		$database['A'] = [
			'type' => 'mysql',
			'host' => '192.168.10.1',
			'port' => '3306',
			'user' => 'root',
			'pass' => 'root',
		];
		$database['B'] = [
			'type' => 'mysql',
			'host' => '192.168.10.1',
			'port' => '3306',
			'user' => 'root',
			'pass' => 'root',
		];
		break;

	case 'live':
		$database['A'] = [
			'type' => 'mysql',
			'host' => '192.168.10.1',
			'port' => '3306',
			'user' => 'root',
			'pass' => 'root',
		];
		$database['B'] = [
			'type' => 'mysql',
			'host' => '192.168.10.1',
			'port' => '3306',
			'user' => 'root',
			'pass' => 'root',
		];
		break;
	//dev
	default:
		$database['A'] = [
			'type' => 'mysql',
			'host' => '192.168.10.1',
			'port' => '3306',
			'user' => 'root',
			'pass' => 'root',
		];
		$database['B'] = [
			'type' => 'mysql',
			'host' => '192.168.10.1',
			'port' => '3306',
			'user' => 'root',
			'pass' => 'root',
		];
		break;
}

return $database;