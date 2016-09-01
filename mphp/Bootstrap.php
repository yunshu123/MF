<?php
header('Content-type: text/html; charset=UTF-8');

if(version_compare(PHP_VERSION,'5.4.0','<'))  die('require PHP > 5.4.0 !');

defined('PROJ_PATH') or define('PROJ_PATH', dirname(__DIR__) . '/');
defined('MPHP_PATH') or define('MPHP_PATH', __DIR__ . '/');
defined('PUB_PATH') or define('PUB_PATH', PROJ_PATH . 'public/');
defined('APP_PATH') or define('APP_PATH', PROJ_PATH . 'app/');
define('CONF_PATH', APP_PATH . 'Configs/');
define('MF_CONF_PATH', MPHP_PATH . 'Configs/');
define('VIEW_PATH', APP_PATH . 'Views/');
define('LOG_PATH', PROJ_PATH . 'logs/');
defined('PROJ_ENV') or define('PROJ_ENV', 'live');
define('VENDOR_PATH', PROJ_PATH . 'vendor/');

require VENDOR_PATH . 'autoload.php';

switch (PROJ_ENV) {
    case 'dev':
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        //注册错误处理
//        $whoops = new \Whoops\Run();
//        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
//        $whoops->register();
        break;
    case 'test':
    case 'live':
		ini_set('display_errors', 0);
        error_reporting(0);
        break;
    default:
        exit();
}

date_default_timezone_set('Asia/shanghai');

require MPHP_PATH . 'App.php';
return new \Mphp\App();