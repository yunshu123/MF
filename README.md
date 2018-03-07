# MPHP - 使用Composer构建一个小巧的PHP MVC框架

---

## 简介

### 目录结构

<pre>

- app   应用目录
- ----  config     配置目录
- ----  controller 控制器目录
- ----  dao        数据访问层
- ----- repository 类库目录，辅助service
- ----- service    业务操作类
- ----- common.php 应用函数库

- bootstrap 启动文件
- -----     应用启动文件

- mphp   框架目录
- ----- Db        Db操作类
- ----- Logger  Logger封装类

- public 应用入口
- ----- index.php 入口文件
- ----- static 静态资源目录

- route 路由目录
- ----- api.php api路由文件

- storage  仓库目录，存放日志、session、cache等

- support 辅助函数目录
- ----- helper.php 辅助函数

- .env.example 示例配置

- composer.json composer配置

- mphp.sql 示例数据库

</pre>


### 框架特点

- 目录结构简单清晰

- 性能高效

- 使用composer构建，易于扩展维护

- 方便定义路由

- 可以方便地在控制器注入服务对象

- 分层清晰（分为controller/service/repository/dao几层）

- 为API设计，去掉影响性能的模块，不包含VIEW

- 方便地面向服务开发，可以在服务中方便配置要连接的数据库实例

### 依赖的包


| 包名 | 版本 | 描述| 
| ----| -----| ----|
| symfony/var-dumper | ^3.1 |一个打印变量的包（比print_r/var_dump更加友好）|
| catfan/Medoo | ^1.5 | 数据库框架（更加方便的操作数据库） |
| vlucas/phpdotenv| ^2.4 | 用于配置，方便操作.env | 
| monolog/monolog | ^1.23 | 日志库 |
| slim/slim | ^3.0| 一个微信框架 |
| php-di/slim-bridge | ^2.0 | 用于PHP DI |
| hassankhan/config | ^1.0 | 用于获取/设置配置 |
| predis/predis | ^1.1 | redis操作 |


## 安装

1. git clone https://github.com/yunshu2009/mphp.git

2. composer install

3. 设置虚拟主机，将web根目录指向public目录

### Nginx重写方法(将请求路由到index.php)
```
location / {
    if (!-e $request_filename) {
        rewrite ^/(.*)$ /index.php last;
        break;
    }
}
```


## 简单性能测试

直接在控制器下操作数据库，将debug模式关掉。


### mphp

控制器代码如下：

```
<?php
namespace app\controller;

use mphp\Db;

class TestController extends BaseController
{
    public function test()
    {
        $db = Db::instance('A');
        $ret = $db->get('post', '*', ['id'=>49]);
        print_r($ret['title']);
    }
}
    
 ```

测试结果如下：

```
☁  mphp [master] ⚡ ab -n 1000 -c 10 http://mphp.app/test
This is ApacheBench, Version 2.3 <$Revision: 1706008 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking mphp.app (be patient)
Completed 100 requests
Completed 200 requests
Completed 300 requests
Completed 400 requests
Completed 500 requests
Completed 600 requests
Completed 700 requests
Completed 800 requests
Completed 900 requests
Completed 1000 requests
Finished 1000 requests


Server Software:        nginx/1.12.2
Server Hostname:        mphp.app
Server Port:            80

Document Path:          /test
Document Length:        26 bytes

Concurrency Level:      10
Time taken for tests:   8.263 seconds
Complete requests:      1000
Failed requests:        0
Total transferred:      209000 bytes
HTML transferred:       26000 bytes
Requests per second:    121.03 [#/sec] (mean)
Time per request:       82.626 [ms] (mean)
Time per request:       8.263 [ms] (mean, across all concurrent requests)
Transfer rate:          24.70 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.3      0       6
Processing:    60   82   9.3     81     151
Waiting:       60   82   9.3     81     151
Total:         60   82   9.3     81     151

Percentage of the requests served within a certain time (ms)
  50%     81
  66%     84
  75%     86
  80%     88
  90%     94
  95%    101
  98%    107
  99%    113
 100%    151 (longest request)

```

lumen:

待添加..


## 其它

### 关于框架的优化

参考链接：[http://php-di.org/doc/performances.html](http://php-di.org/doc/performances.html)

欢迎朋友们star、fork，一起完善。