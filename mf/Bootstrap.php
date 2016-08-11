<?php
header('Content-type: text/html; charset=UTF-8');

if(version_compare(PHP_VERSION,'5.4.0','<'))  die('require PHP > 5.4.0 !');

defined('ROOT_PATH') or define('ROOT_PATH', dirname(__DIR__) . '/');
defined('MF_PATH') or define('MF_PATH', __DIR__ . '/');
defined('PUB_PATH') or define('PUB_PATH', ROOT_PATH . 'public/');
defined('APP_PATH') or define('APP_PATH', ROOT_PATH . 'app/');
define('CONF_PATH', APP_PATH . 'Configs/');
define('MF_CONF_PATH', MF_PATH . 'Configs/');
define('VIEW_PATH', APP_PATH . 'Views/');
define('LOG_PATH', ROOT_PATH . 'logs/');

defined('MF_ENV') or define('MF_ENV', 'live');
switch (MF_ENV) {
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

date_default_timezone_set('Asia/shanghai');

require MF_PATH . 'App.php';
MF\App::run();