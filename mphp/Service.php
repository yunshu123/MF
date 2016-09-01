<?php
namespace Mphp;

class Service
{
    private static $instance = [];

    private static $services = [];

    private $param;

    protected $model;

    protected $is_closed = false;

    public function __construct()
    {
    }

    protected static function getInstance($class = __CLASS__)
    {
        if (! isset(self::$instance[$class])) {
            self::$instance[$class] = new $class();
        }

        return self::$instance[$class];
    }

    public function send($param = null)
    {
        list($model, $action) = explode('.', $param);
        if ( ! $model or ! $action) {
            throw new \Exception('参数不正确!');
        }
        $service = $model . 'Service';
        if ( ! isset(self::$services[$model])) {
            self::$services[$model] = new $service;
        }
        $service_obj = self::$services[$model];
        if ($service_obj->is_closed) {
            throw new \Exception('该服务已经不能用');
        }
        if ( ! method_exists($service_obj, $action)) {
            throw new \Exception('该服务没有提供该方法');
        }
        // TODO: Log
        $arr_data = call_user_func_array([$service_obj, $action], $this->param ? $this->param : array());

        // TODO: Log
        return $arr_data;
    }

    public static function post()
    {
        return self::getInstance()->setParams(func_get_args());
    }

    public function setParams($param = array())
    {
        (is_array($param)) and $this->param = $param;

        return $this;
    }

    public function __destruct()
    {

    }
}
