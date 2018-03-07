<?php
namespace app\controller;

use app\service\PostService;
use mphp\Logger;
use mphp\Service;
use Slim\Http\Request;
use Slim\Http\Response;

class Home extends Base
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $ret = $this->postService->getOne($id);
        dump($ret);

//        Logger::write('aaa', ['bb']);
    }
}