<?php
use MF\Libraries;

function slog_config($config=[])
{
	$config =array_merge($config, get_config('debug.socketlog_config'));
	slog($config,'set_config');
}

function is_log_level_off($log_level)
{
	if (file_exists(CONF_PATH . 'logoff/NO_' . $log_level)) {
		return true;
	}
	return false;
}

function logs($conf_name, $log_level, $err_code, $err_msg='')
{
	$log_level = strtoupper($log_level);
	if (is_log_level_off($log_level)) {
		return;
	}

	$st = debug_backtrace();
//	dump($st);
	$function = ''; //调用api_log的函数名
	$file = '';     //调用api_log的文件名
	$line = '';     //调用api_log的行号
	foreach($st as $item) {
		if($file) {
			$function = $item['function'];
			break;
		}
		if($item['function'] == 'api_log') {
			$file = $item['file'];
			$line = $item['line'];
		}
	}

	$function = $function ? $function : 'main';

	//为了缩短日志的输出，file只取最后一截文件名
	$file = explode("/", rtrim($file, '/'));
	$file = $file[count($file)-1];
	$err_msg = get_error($err_code) . '|' . $err_msg;
	$prefix = "[$file][$function][$line][$log_level][$err_code]";
	if($log_level == INFO || $log_level == STAT) {
		$prefix = "[$log_level]" ;
	}

	$log_file = $conf_name . "_" . strtolower($log_level);
	Libraries\Log::getInstance(LOG_PATH)->log($log_file, $prefix . $err_msg);
}

function get_error($err_code)
{
	$arr = get_config('error_code');

	if (isset($arr[$err_code])) {
		return $arr[$err_code];
	}
	return '';
}

function api_log($log_level, $err_code, $err_msg)
{
	logs('api', $log_level, $err_code, $err_msg);
}

function slog($log, $type = 'log', $css = '')
{
	if (is_string($type)) {
		$type = preg_replace_callback('/_([a-zA-Z])/',
			create_function('$matches', 'return strtoupper($matches[1]);'),
			$type);
		if (method_exists('MF\Libraries\SocketLog', $type)
		    || in_array($type, Libraries\SocketLog::$log_types)
		) {
			return call_user_func(array('MF\Libraries\SocketLog', $type), $log, $css);
		}
	}

	if (is_object($type) && 'mysqli' == get_class($type)) {
		return Libraries\SocketLog::mysqlilog($log, $type);
	}

	if (is_resource($type)
	    && ('mysql link' == get_resource_type($type)
	        || 'mysql link persistent' == get_resource_type($type))
	) {
		return Libraries\SocketLog::mysqllog($log, $type);
	}


	if (is_object($type) && 'PDO' == get_class($type)) {
		return Libraries\SocketLog::pdolog($log, $type);
	}

	throw new Exception($type . ' is not SocketLog method');
}

function array_map_recursive($filter, $data)
{
	$result = array();
	foreach ($data as $key => $val) {
		$result[$key] = is_array($val)
			? array_map_recursive($filter, $val)
			: call_user_func($filter, $val);
	}
	return $result;
}

function filter(&$value, $default='', $callback='htmlspecialchars')
{
	if (! isset($value)) {
		return $default;
	}

	if (is_array($value)) {
		$value = array_map_recursive('htmlspecialchars', $value);
	} else {
		$value = call_user_func($callback, $value);
	}

	return $value;
}

// eg:set_localization(I18N."Locale", 'message', 'zh_CN', 'UTF-8');
function set_localization($locale, $domain, $lang, $charset)
{
	putenv('LANG='.$lang);
	setlocale(LC_ALL, $lang);
//	putenv('LANGUAGE=' . $lang);
	bindtextdomain($domain, $locale);
	bind_textdomain_codeset($domain, $charset);
    textdomain($domain);
}
