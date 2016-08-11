<?php
namespace MF\Libraries;

class Log
{
	private static $_instance;
	private $_path;
	private $_pid;
	private $_handleArr;

	function __construct($path)
	{
		$this->_path = rtrim($path, '/');
		$this->_pid  = getmypid();  //本函数返回 PHP 的行程代号值 (PID)
	}

	private function __clone()
	{

	}

	public static function getInstance($path = '/tmp/')
	{
		if ( ! (self::$_instance instanceof self)) {
			self::$_instance = new self($path);
		}

		return self::$_instance;
	}

	private function getHandle($fileName)
	{
		if (isset($this->_handleArr[$fileName])) {
			return $this->_handleArr[$fileName];
		}

		$nowTime                     = time();
		$logSuffix                   = date('Ymd', $nowTime);
//		echo $this->_path . '/' . $fileName . $logSuffix . ".log";
		$handle                      = fopen($this->_path . '/' . $fileName
		                                     . $logSuffix . ".log", 'a');
		$this->_handleArr[$fileName] = $handle;

		return $handle;
	}

	public function log($fileName, $message)
	{
//		echo $fileName;
		$handle     = $this->getHandle($fileName);
		$nowTime    = time();
		$logPreffix = date('Y-m-d H:i:s', $nowTime);
		fwrite($handle, "[{$logPreffix}][{$this->_pid}]{$message}\n");

		return true;
	}

	function __destruct()
	{
		foreach ($this->_handleArr as $key => $item) {
			if ($item) {
				fclose($item);
			}
		}
	}
}

?>