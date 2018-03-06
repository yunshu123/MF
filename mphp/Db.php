<?php
namespace mphp;

use Medoo\Medoo;

class Db
{
    private static $instance;

    private function __construct()
    {
    }

    public static function instance($tag)
    {
        if (! isset(self::$instance[$tag])) {
            $dbConfig = require CONFIG_PATH . 'database.php';
            if (! isset($dbConfig[$tag])) {
                throw new \Exception('对应数据库配置不存在');
            }
            self::$instance = new Medoo($dbConfig[$tag]);
        }

        return self::$instance;
    }
}