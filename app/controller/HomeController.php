<?php
namespace app\controller;

use app\service\PostService;
use mphp\Logger;
use mphp\Cache;
use mphp\Service;
use Slim\Http\Response;

class HomeController extends BaseController
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Response $response, $id)
    {
        $ret = $this->postService->getOne($id);

        if (! $ret) {
            return $response->withJson($this->result('error', 1, [], 404));
        } else {
            return $response->withJson($this->result('OK', 0, $ret));
        }

//        Logger::write('aaa', ['bb']);
    }
}