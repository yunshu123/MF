<?php
namespace app\controller;

class BaseController
{
    public function __construct()
    {
    }

    public function result($message, $code=0, $data=[], $httpCode=200)
    {
        return [
            'code'      =>  $code,
            'message'   =>  $message,
            'data'      =>  $data,
            'time'      =>  microtime(true) - MPHP_START,
        ];
    }
}