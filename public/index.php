<?php
define('MPHP_START', microtime(true));
define('PROJ_ENV', 'live');  //部署环境

$app = require __DIR__.'/../bootstrap/app.php';

$app->run();