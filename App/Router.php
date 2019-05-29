<?php

namespace App;

class Router {

	public function resolve() {
		$temp = explode('?', urldecode($_SERVER['REQUEST_URI']));
		$urlData = $temp[0];
		$getData = $temp[1] ?? '';
		$reqGetData = explode('&', $getData);
		$reqUrlData = explode('/', $urlData);

		$rulesConfig = App::$config['route'];

		/*
		 * Debug!
		 $rulesConfig = [
			'rules' => [
				'users/index/id=\d+' => 'users/index',
				'users/add' => 'users/add',
			],
			'defaultRoute' => 'home/index',
		];
		$requestData = [
			'users',
			'index',
			'id=testid',
		];*/

		if(isset($reqUrlData[0]) && empty($reqUrlData[0])) array_shift($reqUrlData);
		$result = [];

		foreach($rulesConfig['rules'] as $rule => $controllerView) {
			$temp = explode("?", $rule);
			$contrRule = $temp[0];
			$getRule = $temp[1] ?? '';

			$exRule = explode("/", $contrRule);
			$exGetRule = explode("&", $getRule);

			$params = [];
			$hasValidController = ($exRule[0] ?? '') === ($reqUrlData[0] ?? '');
			$hasValidAction = ($exRule[1] ?? '') === ($reqUrlData[1] ?? '');
			if ($hasValidController && $hasValidAction) {
				// Сюда попадаем с условием, что размер правила равен размеру URL
				$params[] = $reqUrlData[0] ?? ''; // Controller
				$params[] = $reqUrlData[1] ?? ''; // Action

				$reqParams = $reqGetData;
				$rules = $exGetRule;
				$hasGetValidLength = count($exGetRule) === count($reqGetData);
				if ($hasGetValidLength) { // Если запрос содержит что-то ещё, кроме контроллера с экшном
					$reqFields = [];
					for ($i = 0; $i < count($reqParams); $i++) { // Пробежимся по полям запроса
						$ruleCond = explode("=", $rules[$i]);
						$reqCond = explode("=", $reqParams[$i]);
						if ($ruleCond[0] === $reqCond[0]) { // Если поле удовлетворяет правилу роутинга, запоминаем
							// С помощью регулярки фильтруем GET параметры
							$filteredValue = preg_replace('/[^' . $ruleCond[1] . ']/u', '', $reqCond[1]);
							$reqFields[$reqCond[0]] = $filteredValue;
						} else {// Одно из полей некорректное - переходим к следующему правилу
							break;
						}

						if (($i + 1) === count($reqParams)) { // Сюда попадём только на последней итерации
							$params['params'] = $reqFields;
							$result = $params;
							break 2; // done
						}
					}
				}

			}
		}

		if(!count($result)) { // На случай отсутствия правил, попытаемся извлечь хотя бы напрямую из URL
			for($i = 0; $i < 2; $i++) {
				if(isset($reqUrlData[$i]) && !empty($reqUrlData[$i])) {
					$result[] = $reqUrlData[$i];
				} else {
					break;
				}
			}
		}

		if(!count($result)) { // На случай отсутствия запроса контроллера вообще
			$result = explode("/", $rulesConfig['defaultRoute']);
		}

		return $result;
	}
}
