<?php
define('MPHP_START', microtime(true));

$app = require __DIR__.'/../bootstrap/app.php';

require BASE_PATH . 'route/api.php';

$app->run();