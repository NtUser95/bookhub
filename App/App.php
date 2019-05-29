<?php

namespace App;

use App\Exceptions\UnknownClassException;
use Throwable;

class App {

	public static $router;
	public static $db;
	public static $kernel;
	public static $user;
	public static $config;

	public static function init() {
		spl_autoload_register(['static', 'loadClass']);
		static::bootstrap();
		set_exception_handler(['App\App', 'handleException']);
	}

	public static function bootstrap() {
		static::$router = new Router();
		static::$kernel = new Kernel();
		static::$db = new Db();
		static::$user = new User();

		self::$config = include __DIR__ . '/../Config/main.php';
	}

	/**
	 * @param $className
	 * @throws UnknownClassException
	 */
	public static function loadClass($className) {
		$className = str_replace('\\', '/', $className);

		$classPath = ROOT_PATH . '/' . $className . '.php';
		if (file_exists($classPath)) {
			require_once $classPath;
		} else {
			throw new UnknownClassException('Cant load class: ' . $classPath);
		}
	}

	public static function handleException(Throwable $e) {
		if ($e instanceof \App\Exceptions\InvalidRouteException) {
			echo static::$kernel->launchAction('Error', 'error404', [$e]);
		} else {
			echo static::$kernel->launchAction('Error', 'error500', [$e]);
		}
	}

}
