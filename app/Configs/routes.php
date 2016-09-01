<?php
use Mphp\Route;

//匹配首页
Route::get('/', 'App\Controllers\IndexController@index');

Route::get('/index', 'App\Controllers\IndexController@index');

// /user?name=ys&age=24
Route::get('/user', function() {
	dump($_GET);
});

Route::get('/http', 'App\ControllersIndexController@http');

Route::get('/hello', 'App\Controllers\IndexController@sayHello');