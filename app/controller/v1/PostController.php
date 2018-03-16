<?php
namespace app\controller\v1;

use app\service\PostService;
use Interop\Container\ContainerInterface;
use Slim\Http\Request;

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
        $id = (int)$request->getAttribute('id');

        $ret = $this->postService->getOne($id);

        if (! $ret) {
            return $this->result('error', 1, [], 404);
        } else {
            return $this->result('OK', 0, $ret);
        }
    }
}