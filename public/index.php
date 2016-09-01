<?php

define('PROJ_PATH', dirname(__DIR__) . '/');
define('MPHP_PATH', PROJ_PATH . 'mphp/');
define('APP_PATH', PROJ_PATH . 'app/');
define('I18N', APP_PATH . 'I18N/');

define("DEBUG", "DEBUG");
define("INFO", "INFO");
define("ERROR", "ERROR");
define("STAT", "STAT");

$hostname = php_uname('n');
if (false !== strpos($hostname, 'online')) {
	define('PROJ_ENV', 'live');
} else if (false !== strpos($hostname, 'test')) {
	define('PROJ_ENV', 'test');
} else {
	define('PROJ_ENV', 'dev');
}

$app = require MPHP_PATH . 'Bootstrap.php';
$app::run();