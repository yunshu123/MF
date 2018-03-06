<?php
use NoahBuscher\Macaw\Macaw as Route;

Route::get('fuck', function() {
    echo "成功！";
});

Route::get('index', 'app\controller\Home@index');