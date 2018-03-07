<?php

return [
    //A数据库实例
    'A' => [
        'database_type' => 'mysql',
        'database_name' => env('A.dbname', 'mphp'),
        'server'        => env('A.server', '127.0.0.1'),
        'username'      => env('A.username', 'root'),
        'password'      => env('A.password', '123456'),
        'charset'       => env('A.charset', 'utf8'),
        'port'          => env('A.port', '3306'),
        'prefix'        => env('A.prefix', 'mf_'),
    ],
];