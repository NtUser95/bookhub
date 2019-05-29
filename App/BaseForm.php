<?php

namespace App;

class BaseForm {

	private $errors = [];

	public function load() {
		$changed = false;
		foreach ($_POST as $key => $value) {
			if (property_exists($this, $key)) {
				$this->$key = $value;
				$changed = true;
			}
		}

		return $changed;
	}

	public function hasErrors() {
		return count($this->errors);
	}

	public function getErrors() {
		return $this->errors;
	}

	public function addError(String $errMessage) {
		$this->errors[] = $errMessage;
	}

	public function reset() {
		foreach (get_class_vars(get_class($this)) as $propName => $value) {
			if ($propName === 'error') {
				$this->$propName = [];
			} else {
				$this->$propName = null;
			}
		}
	}

}
