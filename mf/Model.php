<?php
namespace MF;

class Model
{

	private static $instances = [];

	public function __construct()
	{

	}

	protected static function model($class = __CLASS__)
	{
		if (! isset(self::$instances[$class])) {
			self::$instances[$class] = new $class();
		}

		return self::$instances[$class];
	}

	public function __destruct()
	{

	}
}