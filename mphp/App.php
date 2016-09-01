<?php
namespace Mphp;

class App
{
    public static function run()
    {
        require_once MPHP_PATH . '/Loader.php';
        Loader::register();

        include CONF_PATH . 'routes.php';
        Route::dispatch('View@process');
    }
}