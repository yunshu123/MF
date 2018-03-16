<?php

define('BASE_PATH', dirname(__DIR__).'/');

require BASE_PATH.'vendor/autoload.php';

$env = new Dotenv\Dotenv(BASE_PATH);
$env->load();

$config = require BASE_PATH . 'config/config.php';

date_default_timezone_set('PRC');

$container = new \Slim\Container(['settings'=>$config['app']]);
$app = new \Slim\App($container);

return $app;