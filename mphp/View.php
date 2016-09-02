<?php
namespace Mphp;

class View {

	public $view;
	public $data;

	public function __construct($view)
	{
		$this->view = $view;
	}

	public static function make($viewName = null)
	{
		$filePath = str_replace('.', '/', $viewName) . '.php';
		$viewFilePath = VIEW_PATH.$filePath;
		if ( is_file($viewFilePath) ) {
			return new View($filePath);
		} else {
			throw new \UnexpectedValueException("View file does not exist!");
		}
	}

	public static function process($view = null)
	{
		if ( is_string($view) ) {
			echo $view;
			return;
		}

		if ( $view instanceof View ) {
			\Twig_Autoloader::register();
			$loader = new \Twig_Loader_Filesystem(VIEW_PATH);
			$twig = new \Twig_Environment($loader, array(
				'cache' =>  DATA_PATH . 'Cache',
//				'debug' =>  DEBUG,
			));

			echo $twig->render($view->view, $view->data);
		}
	}

	public function with($key, $value = null)
	{
		$this->data[$key] = $value;
		return $this;
	}

	public function __call($method, $parameters)
	{
		if (starts_with($method, 'with')) {
			return $this->with(snake_case(substr($method, 4)), $parameters[0]);
		}

		throw new \BadMethodCallException("Function [$method] does not exist!");
	}
}