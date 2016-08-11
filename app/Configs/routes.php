<?php
use MF\Route;

//匹配首页
Route::get('/', 'IndexController@index');

Route::get('/index', 'IndexController@index');

// /user?name=ys&age=24
Route::get('/user', function() {
	dump($_GET);
});

Route::get('/http', 'IndexController@http');

Route::get('/hello', 'IndexController@sayHello');