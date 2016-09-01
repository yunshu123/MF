<?php
namespace Mphp;

class Cache
{
	protected $handler;

	protected $options;

	public static function getInstance($type = 'redis', $options = [])
	{
		static $_instance = [];
		$guid = $type . md5(serialize($options));

		if ( ! isset($_instance[$guid])) {
			$type = 'Mphp\\Cache\\Driver\\' . ucwords(strtolower($type));
			if (class_exists($type)) {
				$class            = new $type($options);
				$_instance[$guid] = $class;
			} else {
				throw new \Exception("class {$type} don't exist");
			}
		}

		return $_instance[$guid];
	}
}