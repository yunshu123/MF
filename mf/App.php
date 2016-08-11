<?php
namespace MF;

class App
{
    public static function run()
    {
        require_once MF_PATH . '/Loader.php';
        Loader::register();

        include CONF_PATH . 'routes.php';
        Route::dispatch('View@process');
    }
}