<?php
namespace MF;

class Loader
{
	public static function register()
	{
		$load_files =  [
			MF_PATH . 'Helpers/functions.php',
			APP_PATH . 'Helpers/functions.php',
		];
		foreach ($load_files as $file){
			if(is_file($file)) {
				include $file;
			}
		}

		spl_autoload_register(array('MF\Loader', 'autoload'));
	}

	public static function autoload($class)
	{
		$map = [
			'MF'                =>  MF_PATH,
		];
		$config = get_config('app');
		$map = ($config && $config['autoload_namespace']) ? array_merge($map, $config['autoload_namespace']) : $map;
		$namespace = array_keys($map);
		$path = array_values($map);

		 if (false !== strpos($class, '\\')) {
			$name = strstr($class, '\\', true);
			 $filename = str_replace('\\', '/', str_replace($namespace, $path, $class)) . '.php';

			if (is_file($filename)) {
				include $filename;
			}
		} else {
			$layer = [
				'Controller' => APP_PATH . 'Controllers/',
				'Model'      => APP_PATH . 'Models/',
				'Service'    => APP_PATH . 'Services/',
			    'Dao'        => APP_PATH . 'Dao/',
			];
			foreach ($layer as $layer => $path) {
				if (substr($class, -strlen($layer)) == $layer) {
					include $path . $class . '.php';
				}
			}
		}
	}
}