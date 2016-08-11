<?php
namespace MF;

class View {

	public $view;
	public $data;

	public function __construct($view)
	{
		$this->view = $view;
	}

	public static function make($viewName = null)
	{
		$viewFilePath = self::getFilePath($viewName);
		if ( is_file($viewFilePath) ) {
			return new View($viewFilePath);
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
			if ($view->data) {
				extract($view->data);
			}
			require $view->view;
		}
	}

	public function with($key, $value = null)
	{
		$this->data[$key] = $value;
		return $this;
	}

	private static function getFilePath($viewName)
	{
		$filePath = str_replace('.', '/', $viewName);
		return VIEW_PATH.$filePath.'.php';
	}

	public function __call($method, $parameters)
	{
		if (starts_with($method, 'with'))
		{
			return $this->with(snake_case(substr($method, 4)), $parameters[0]);
		}

		throw new \BadMethodCallException("Function [$method] does not exist!");
	}
}