<?php
namespace app\library;

use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;

class Logger
{
    public static function write($name, $data, $level = Log::INFO)
    {
        $path = ROOT_PATH . '/storage/logs/';
        if (! is_dir($path)) {
            mkdir($path, 0700);
        }
        $log = new Log($name);
        $log->pushHandler(new StreamHandler($path . $name .'.'. date('Y-m-d') . '.log', $level));
        $log->info($name, $data);
    }
}