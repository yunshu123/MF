<?php
namespace Mphp\Libraries;

//对错误进行处理
class Fake
{

	private $errno;

	private $error;

	public function __construct($errno, $error = null)
	{
		$this->errno = $errno;
		$this->error = $error;
	}

	public function __call($method, $args)
	{
		return self::error($this->errno, $this->error);
	}

	public static function check($error)
	{
		return (is_array($error) and isset($error['errno']));
//		return (is_array($error) and isset($error['errno']) or $error === false);
	}

	/**
	 * @param        $errno   错误代码
	 * @param mixed  $error   错误信息或者行号
	 * @param string $file    错误文件
	 *
	 * @return array
	 */
	public static function error($errno, $error = null, $file = null)
	{
		$arr_error = get_config('error', 'system');
		is_numeric($errno) or $errno = 2000;
		if ($error && is_string($error)) {
			$arr_error[$errno] = $error;
		}

		$err = ['errno' => $errno];

		if ($file and $error > 0) {
			$err['error'] = array(
				'code' => $arr_error[$errno],
				'line' => $error,
				'file' => $file,
			);
		} else {
			$err['error'] = $arr_error[$errno] ? $arr_error[$errno] : $arr_error[2000];
		}

		return $err;
	}
}