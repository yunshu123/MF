# MPHP 

MPHP is A Simple PHP MVC Framework based on Composer.

This framework is a helps you quickly write simple yet powerful APIs.

---


## Installtion

### Download

```
git clone https://github.com/yunshu2009/mphp.git

```

### Install dependencies:


```
composer install

```

modify  ```config/database.php```  configure database and import ```demo.sql```


### Route & Controller

Configure router: ```config/routes.php```


<<<<<<< 98da94812ca3d17f7058b33529f964e4e9a5cf9a
4. 导入mphp.sql到数据库，看测试例子效果

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
=======
```
$app->get('/test', ['\app\controller\TestController', 'test']);
>>>>>>> # 更新

```

Configure controller: ```app/controller/TestController.php```

```
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

### Run

```
cd public && php -S localhost:8000
```

visit [http://localhost:8000](http://localhost:8000)


## Others

<<<<<<< 98da94812ca3d17f7058b33529f964e4e9a5cf9a
欢迎朋友们star、fork，一起完善。
=======
Welcome friends to star, fork.
>>>>>>> # 更新
