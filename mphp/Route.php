<?php
namespace Mphp;

use Mphp\View;

class Route
{
    public static $routes = [];

    public static $methods = [];

    public static $callbacks = [];

	public static $error_callback = [];

    public static $patterns = [
        ':any'  => '[^/]+',
        ':all'  =>  '.*',
        ':num' => '[0-9]+',
    ];

    public static function __callStatic($method, $arguments)
    {
        if ($method == 'any') {
			self::pushToArray('get', $arguments);
			self::pushToArray('post', $arguments);
        } else {
	        self::pushToArray($method, $arguments);
        }
    }

	public static function pushToArray($method, $arguments)
	{
		array_push(self::$routes, $arguments[0]);
		array_push(self::$callbacks, $arguments[1]);
		array_push(self::$methods, strtoupper($method));
	}

    public static function dispatch($after=null)
    {
        $uri = self::detect_uri();
        $method = $_SERVER['REQUEST_METHOD'];
        $found_route = false;
        $searches = array_keys(self::$patterns);
        $replaces = array_values(self::$patterns);

        if (in_array($uri, self::$routes)) {
            $route_pos = array_keys(self::$routes, $uri);

	        foreach ($route_pos as $route) {
                if (self::$methods[$route] == $method) {
                    $found_route = true;

                    if (!is_object(self::$callbacks[$route])) {
                        $parts = explode('/',self::$callbacks[$route]);    //  Sport/Article@abc
                        $last = end($parts);
                        $segments = explode('@',$last);

	                    $controller = new $segments[0]();
                        $methodName = $segments[1];

                        if (method_exists($controller, $methodName)) {
	                        $return = $controller->$methodName();

	                        if ($after) {
		                        $after_segments = explode('@', $after);
		                        $afterClassName = $after_segments[0];
		                        $afterFunctionName = $after_segments[1];
		                        View::$afterFunctionName($return);
	                        }
                        }
                    } else {
                        call_user_func(self::$callbacks[$route]);
                    }
                }

            }
        } else {
            $pos = 0;

            foreach (self::$routes as $route) {
                if (strpos($route, ':') !== false) {
                    $route = str_replace($searches, $replaces, $route);
                }

                if (preg_match('#^' . $route . '$#', $uri, $matched)) {
                    if (self::$methods[$pos] == $method || self::$methods[$pos] == 'ANY') {
                        $found_route = true;

                        if ( ! is_object(self::$callbacks[$pos])) {
                            $parts = explode('/',self::$callbacks[$pos]);
                            $last = end($parts);
                            $segments = explode('@',$last);
	                        $controller = new $segments[0]();

	                        if (method_exists($controller, $segments[1])) {
		                        $return = $controller->$segments[1]();
		                        if ($after) {
			                        $after_segments = explode('@', $after);
			                        $afterClassName = $after_segments[0];
			                        $afterFunctionName = $after_segments[1];
			                        $afterClassName::$afterFunctionName($return);
		                        }
	                        }
                        } else {
                            call_user_func_array(self::$callbacks[$pos], $matched);
                        }
                    }
                }
                $pos++;
            }
        }

        if ($found_route == false) {
            if (!self::$error_callback) {
                self::$error_callback = function() {
                    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
                    echo '404 Not Found';
                    exit();
                };
            }
            call_user_func(self::$error_callback);
        }
    }

    //仿照Codelgniter 2
    public static function detect_uri()
    {
        $uri = $_SERVER['REQUEST_URI'];
        if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0) {
            $uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
        }
        if ($uri == '/' || empty($uri)) {
            return '/';
        }

        $uri = parse_url($uri, PHP_URL_PATH);
        return str_replace(array('//', '../'), '/', rtrim($uri, '/'));
    }

}