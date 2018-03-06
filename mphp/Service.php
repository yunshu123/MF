<?php
namespace mphp;

class Service
{
    private static $instance = [];
    private static $services = [];
    private $param;

    private function __construct()
    {
    }

    protected static function getInstance($class = __CLASS__)
    {
        if ( ! isset(self::$instance[$class])) {
            static::$instance[$class] = new $class();
        }

        return static::$instance[$class];
    }

    public function send($param = null)
    {
        $paramArr = explode('.', $param);
        if (count($paramArr) != 2) {
            throw new \Exception('参数不正确!');
        }
        list($model, $action) = $paramArr;
        $service = $model;
        if ( ! isset(self::$services[$model])) {
            self::$services[$model] = new $service;
        }
        $serviceObj = self::$services[$model];
        if ($serviceObj->isClosed) {
            throw new \Exception('该服务已经不能用');
        }
        if ( ! method_exists($serviceObj, $action)) {
            throw new \Exception('该服务没有提供该方法');
        }

        return call_user_func_array([$serviceObj, $action], $this->param ? $this->param : []);
    }

    public static function post()
    {
        return self::getInstance()->setParams(func_get_args());
    }

    public function setParams($param = [])
    {
        if (is_array($param)) {
            $this->param = $param;
        }

        return $this;
    }
}