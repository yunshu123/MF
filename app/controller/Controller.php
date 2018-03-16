<?php
namespace app\controller;

use Interop\Container\ContainerInterface;

abstract class Controller
{
    protected $ci;
    protected $request;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
        $this->request = $ci->get('request');
        $this->response = $ci->get('response');
    }

    public function result($message, $code = 0, $data = [], $httpCode = 200)
    {
        return $this->response->withJson([
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
            'runtime' => microtime(true) - MPHP_START,
        ], $httpCode);
    }
}