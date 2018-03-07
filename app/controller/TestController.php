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