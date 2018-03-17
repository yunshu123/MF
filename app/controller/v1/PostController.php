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