<?php
namespace app\controller;

use mphp\Logger;
use mphp\Service;

class Home extends Base
{
    public function index()
    {
        $ret = Service::post(14)->send('app\service\post.getOne');
        dump($ret);

        test();

//        Logger::write('aaa', ['bb']);
    }
}