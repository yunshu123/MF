<?php
namespace MF\Cache\Driver;

use MF\Cache;

class Memcache extends Cache
{
	protected static $_instance;

	public function __construct($options)
	{
		$mc_config     = get_config('memcache');
		$options       = array_merge([
			'host'    => $mc_config['host'] ?: '127.0.0.1',
			'passwd'  => $mc_config['passwd'] ?: '',
			'port'    => $mc_config['port'] ?: 6379,
			'timeout' => $mc_config['timeout'] ?: false,
			'prefix'  => $mc_config['prefix'] ?: '',
		], $options);
		$this->options = $options;
		$this->handler = new \Memcache();
		if ($options['timeout']) {
			$this->handler->connect($options['host'], $options['port'],
				$options['timeout']);
		} else {
			$this->handler->connect($options['host'], $options['port'],
				$options['timeout']);
		}
	}

	public function set($name, $value, $expire)
	{
		if (is_null($expire)) {
			$expire = $this->options['expire'];
		}
		$name   = $this->options['prefix'] . $name;
		$value  = (is_object($value) || is_array($value)) ? json_encode($value)
			: $value;
		$result = $this->handler->set($name, $value, 0, $expire);

		return $result;
	}

	public function get($name)
	{
		$name   = $this->options['prefix'] . $name;
		$result = $this->handler()->get($name);
		$data   = json_decode($result, true);

		return ($data === null ? $result : $data);
	}

	public function rm($name)
	{
		$name = $this->options['prefix'] . $name;

		return $this->handler->delete($name);
	}

	public function clear()
	{
		$this->handler->flush();
	}
}