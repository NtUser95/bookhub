<?php

namespace App;

class Kernel {

	public $defaultControllerName = 'Users';
	public $defaultActionName = 'index';

	/**
	 * @throws Exceptions\InvalidRouteException
	 */
	public function launch(): string {
		$routeResult = App::$router->resolve();

		$controllerName = $routeResult[0];
		$actionName = $routeResult[1] ?? '';
		$params = $routeResult['params'] ?? '';

		return $this->launchAction($controllerName, $actionName, $params);
	}

	/**
	 * @param $controllerName
	 * @param $actionName
	 * @param $params
	 * @return string
	 * @throws Exceptions\InvalidRouteException
	 */
	public function launchAction($controllerName, $actionName, $params) {
		$controllerName = empty($controllerName) ? $this->defaultControllerName : ucfirst($controllerName);
		$controllerName = $controllerName . 'Controller'; //UsersController

		$controllerDir = ROOT_PATH . '/Controllers/' . $controllerName . '.php';
		if (!file_exists($controllerDir)) {
			throw new \App\Exceptions\InvalidRouteException('Path not found:' . $controllerDir);
		}
		require_once $controllerDir;

		if (!class_exists("\\Controllers\\" . ucfirst($controllerName))) {
			throw new \App\Exceptions\InvalidRouteException('Class not found:' . $controllerName);
		}

		$controllerName = "\\Controllers\\" . ucfirst($controllerName);
		$controller = new $controllerName;
		$actionName = empty($actionName) ? $this->defaultActionName : $actionName;
		if (!method_exists($controller, $actionName)) {
			throw new \App\Exceptions\InvalidRouteException('Action not found: ' . $actionName);
		}

		return $controller->$actionName($params);
	}

}
