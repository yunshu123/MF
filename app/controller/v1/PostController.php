<?php
namespace app\controller\v1;

use app\service\PostService;
use Interop\Container\ContainerInterface;
use Respect\Validation\Validator;
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
        //todo: 使用validator
//        $idValidator = Validator::numeric()->positive();
//        $validators = array(
//            'id' => $idValidator,
//        );
//
//        if($request->getAttribute('has_errors')){
//            $this->result($request->getAttribute('errors'), 0, [], 400);
//        }

        $id = $request->getAttribute('id');
        $ret = $this->postService->getOne($id);

        if (! $ret) {
            return $this->result('error', 1, [], 404);
        } else {
            return $this->result('OK', 0, $ret);
        }
    }
}