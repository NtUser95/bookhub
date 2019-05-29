<?php

namespace Controllers;

class ErrorController extends \App\Controller {

	public function error404($error = null) {
		return $this->render('error404', [
			'error' => json_encode($error),
		]);
	}

	public function error500($error = null) {
		return $this->render('error500', [
			'error' => json_encode($error),
		]);
	}
}
