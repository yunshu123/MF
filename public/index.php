<?php

define('PUB_PATH', __DIR__ . '/');
define('MF_PATH', PUB_PATH . '../mf/');
define('APP_PATH', PUB_PATH . '../app/');
define('I18N', APP_PATH . 'I18N/');

define("DEBUG", "DEBUG");
define("INFO", "INFO");
define("ERROR", "ERROR");
define("STAT", "STAT");

$hostname = php_uname('n');
if (false !== strpos($hostname, 'online')) {
	define('MF_ENV', 'live');
} else if (false !== strpos($hostname, 'test')) {
	define('MF_ENV', 'test');
} else {
	define('MF_ENV', 'dev');
}

require MF_PATH . 'Bootstrap.php';