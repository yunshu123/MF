<?php
define('ROOT_PATH', dirname(__DIR__) . '/');
define('APP_PATH', ROOT_PATH . '/app/');
define('CONFIG_PATH', APP_PATH . 'config/');
defined('PROJ_ENV') or define('PROJ_ENV', 'dev');

require __DIR__.'/../vendor/autoload.php';

$env = new Dotenv\Dotenv(ROOT_PATH);
$env->load();

//错误处理
switch (PROJ_ENV) {
    case 'dev':
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        break;
    case 'test':
    case 'live':
        ini_set('display_errors', 0);
        error_reporting(0);
        break;
    default:
        exit();
}

$app = new \DI\Bridge\Slim\App([
    'settings' => [
        'displayErrorDetails' => (PROJ_ENV=='dev' ? true : false),
    ]
]);

require __DIR__.'/../route/api.php';

return $app;