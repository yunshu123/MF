<?php
use MF\Libraries;

function snake_case($value, $delimiter = '_')
{
	static $snakeCache = [];
	$key = $value . $delimiter;

	if (isset($snakeCache[$key])) {
		return $snakeCache[$key];
	}

	if ( ! ctype_lower($value)) {
		$value = preg_replace('/\s+/u', '', $value);
		$value = mb_strtolower(preg_replace('/(.)(?=[A-Z])/u',
			'$1' . $delimiter, $value), 'UTF-8');
	}

	return $snakeCache[$key] = $value;
}

function dump($var, $exit=false)
{
	ob_start();
	var_dump($var);
	$output = ob_get_clean();
	if ( ! extension_loaded('xdebug')) {
		$output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
		$output = '<pre>' . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
	}

	echo($output);
    $exit && exit(1);
}

function redirect($url, $time = 0, $msg = '')
{
	//多行URL地址支持
	$url = str_replace(array("\n", "\r"), '', $url);
	if (empty($msg)) {
		$msg = "系统将在{$time}秒之后自动跳转到{$url}！";
	}
	if ( ! headers_sent()) {
		// redirect
		if (0 === $time) {
			header('Location: ' . $url);
		} else {
			header("refresh:{$time};url={$url}");
			echo($msg);
		}
		exit();
	} else {
		$str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
		if ($time != 0) {
			$str .= $msg;
		}
		exit($str);
	}
}

function http_request($url, $post_data = null, $timeout = 3)
{
	if ( ! extension_loaded('curl')) {
		return false;
	}

	$ch = curl_init($url);

	$ar_url = parse_url($url);
	if ($ar_url['scheme'] == 'https') {
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	}

	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	if ( ! empty($post_data)) {
		curl_setopt($ch, CURLOPT_POST, true);
		if (is_array($post_data)) {
			$post_data = http_build_query($post_data);
		}
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	}

	$data = curl_exec($ch);
	curl_close($ch);

	if ( ! $data) {
		return false;
	}

	return $data;
}

/**
 * 统一化时间格式
 * 时间差小于60分钟: XX分钟前
 * 时间差大于60分钟并在昨天0点以内: 今天/昨天 H:i
 * 时间差在昨天0点以前: Y月m日 H:i
 *
 * @params string $datetime 任意strtotime()函数可以解析的时间格式
 *
 * @return string
 */
function time_formater($datetime = '')
{
	$datetime = trim($datetime);
	if (strlen($datetime) == 0) {
		return '';
	}

	if (strlen($datetime) <= 10 && is_numeric($datetime)) {
		$timestamp = $datetime;
	} else if (strlen($datetime) == 13 && is_numeric($datetime)) {
		$timestamp = intval($datetime / 1000);
	} else {
		$timestamp = strtotime($datetime);
		if ($timestamp === false || $timestamp == -1) {
			return '';
		}
	}

	$now = time();
	if (date('Y', $timestamp) == date('Y', $now)) {
		$delta          = $now - $timestamp;
		$today_midnight = strtotime(date('Y-m-d') . ' 00:00:00');

		if ($delta <= 60) {
			// 1分钟内
			$formater = $delta . '秒前';
		} elseif ($delta <= 60 * 60 && $delta > 60) {
			// 60分钟内
			$formater = intval($delta / 60) . '分钟前';
		} elseif ($delta > 60 * 60 && $delta <= 6 * 60 * 60) {
			// 6小时内
			$formater = intval($delta / 60 / 60) . '小时前';
		} elseif ($delta > 6 * 60 * 60 && $timestamp >= $today_midnight) {
			// 当天内超过6小时
			$formater = '今天 ' . date('H:i', $timestamp);
		} else {
			$formater = date('m月d日 H:i', $timestamp);
		}
	} else {
		$formater = date('Y年m月d日 H:i', $timestamp);
	}

	return $formater;
}

function get_config($config, $type='app')
{
	static $_config = [];
	$path = ($type=='app') ? CONF_PATH : MF_CONF_PATH;

	if (false !== strpos($config, '.')) {
		$config_arr = explode('.', $config);
//		var_dump($config_arr);
		$config_file = $config_arr[0];
		$name = $type.'.'.$config_file;
		$key         = $config_arr[1];
	} else {
		$config_file = $config;
		$name = $type.'.'.$config_file;
		$key = null;
	}

	if (isset($_config[$name])) {
		return ($key ? $_config[$name][$key] : $_config[$name]);
	}

	if (file_exists($path . $config_file . '.php')) {
		$_config[$name] = include $path . $config_file . '.php';
		return ($key ? $_config[$name][$key] : $_config[$name]);
	} else {
		throw new Exception("config file {$config_file}.php does not exists!!");
	}
}

/**
 * XML编码
 *
 * @param mixed  $data     数据
 * @param string $root     根节点名
 * @param string $item     数字索引的子节点名
 * @param string $attr     根节点属性
 * @param string $id       数字索引子节点key转换的属性名
 * @param string $encoding 数据编码
 *
 * @return string
 */
function xml_encode($data, $root = 'mf', $item = 'item', $attr = '', $id = 'id', $encoding = 'utf-8')
{
	if (is_array($attr)) {
		$_attr = array();
		foreach ($attr as $key => $value) {
			$_attr[] = "{$key}=\"{$value}\"";
		}
		$attr = implode(' ', $_attr);
	}
	$attr = trim($attr);
	$attr = empty($attr) ? '' : " {$attr}";
	$xml  = "<?xml version=\"1.0\" encoding=\"{$encoding}\"?>";
	$xml .= "<{$root}{$attr}>";
	$xml .= data_to_xml($data, $item, $id);
	$xml .= "</{$root}>";

	return $xml;
}

/**
 * 数据XML编码
 *
 * @param mixed  $data 数据
 * @param string $item 数字索引时的节点名称
 * @param string $id   数字索引key转换为的属性名
 *
 * @return string
 */
function data_to_xml($data, $item = 'item', $id = 'id')
{
	$xml = $attr = '';
	foreach ($data as $key => $val) {
		if (is_numeric($key)) {
			$id && $attr = " {$id}=\"{$key}\"";
			$key = $item;
		}
		$xml .= "<{$key}{$attr}>";
		$xml .= (is_array($val) || is_object($val)) ? data_to_xml($val, $item,
			$id) : $val;
		$xml .= "</{$key}>";
	}

	return $xml;
}