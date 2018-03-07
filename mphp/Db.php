<?php
namespace mphp;

use Medoo\Medoo;
use Noodlehaus\Config;

class Db
{
    private static $instance;

    private function __construct()
    {
    }

    public static function instance($tag)
    {
        if (! isset(self::$instance[$tag])) {
            $config = Config::load(CONFIG_PATH.'database.php');
            $dbConfig = $config->get($tag);
            if (! $dbConfig) {
                throw new \Exception('对应数据库配置不存在');
            }
            self::$instance[$tag] = new Medoo($dbConfig);
        }

        return self::$instance[$tag];
    }
}