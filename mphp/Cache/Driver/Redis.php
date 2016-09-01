<?php
namespace Mphp\Cache\Driver;

use Mphp\Cache;

class Redis extends Cache
{
	protected $database;

	public function __construct($options)
	{
		$redis_config  = get_config('redis');
		$options       = array_merge([
			'host'     => $redis_config['host'] ?: '127.0.0.1',
			'passwd'   => $redis_config['passwd'] ?: '',
			'port'     => $redis_config['port'] ?: 6379,
			'database' => $redis_config['database'] ?: 0,
			'timeout'  => $redis_config['timeout'] ?: false,
			'prefix'   => $redis_config['prefix'] ?: '',
			'expire'   => $redis_config['expire']?: 0,
		], $options);

		$this->options = $options;
		$this->handler = new \Redis();
		if ($options['passwd']) {
			$this->handler->auth($options['passwd']);
		}
		if ($options['timeout']) {
			$this->handler->connect($options['host'], $options['port'],
				$options['timeout']);
		} else {
			$this->handler->connect($options['host'], $options['port'],
				$options['timeout']);
		}
		$this->database = $options['database'];
		$this->handler->select($options['database']);
	}

	public function select($db)
	{
		$this->handler->select($db);
	}

	public function set($name, $value, $expire=null)
	{
		if (is_null($expire)) {
			$expire = $this->options['expire'];
		}
		$name  = $this->options['prefix'] . $name;
		$value = (is_object($value) || is_array($value)) ? json_encode($value)
			: $value;
		if (is_int($expire) && $expire) {
			$result = $this->handler->setex($name, $expire, $value);
		} else {
			$result = $this->handler->set($name, $value);
		}

		return $result;
	}

	public function get($name)
	{
		$this->select($this->database);

		$name   = $this->options['prefix'] . $name;
		$result = $this->handler->get($name);
		$data   = json_decode($result, true);

		return ($data === null ? $result : $data);
	}

	public function rm($name)
	{
		$this->select($this->database);
		$name = $this->options['prefix'] . $name;

		return $this->handler->delete($name);
	}

	public function clear()
	{
		$this->select($this->database);
		$this->handler->flushDB();
	}
}