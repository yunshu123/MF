# MPHP [![Travis](https://www.travis-ci.org/yunshu2009/MPHP.svg?branch=master)](https://www.travis-ci.org/yunshu2009/MPHP/)

MPHP is A Simple PHP Micro Service Framework based on Composer,it helps you quickly write simple yet powerful APIs. 




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

```
$app->get('/api/v1/article/{id}', '\app\controller\v1\PostController:getArticleById');
```

Configure controller: ```app/controller/TestController.php```

```
<?php
namespace app\controller\v1;

use app\service\PostService;
use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use think\Validate;

class PostController extends BaseController
{
    private $postService;

    public function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci);

        $this->postService = new PostService();
    }

    public function getArticleById(Request $request)
    {
        $validator = Validate::make([
            'id'    =>  'require|number'
        ]);

        $id = $request->getAttribute('id');

        if (! $validator->check(['id'=>$id])) {
            return $this->result($validator->getError(), 1, [], 400);
        }

        $ret = $this->postService->getOne($id);

        if (! $ret) {
            return $this->result('error', 1, [], 404);
        } else {
            return $this->result('OK', 0, $ret);
        }
    }
}
```

### Run

```
cd public && php -S localhost:8000
```

visit [http://localhost:8000](http://localhost:8000)


## Others

Welcome friends to star, fork.

