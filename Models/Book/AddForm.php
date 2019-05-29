<?php

namespace Models\Book;

use App\BaseForm;

class AddForm extends BaseForm {
	public $cover_image;
	public $name;
	public $description;
	public $authors;
	public $genres;

	public function processFormData() {
		$this->city_name = trim(preg_replace('![^0-9a-zA-Zа-яА-ЯёЁ\- ]+!u', '', $this->city_name));

		if (strlen($this->name) <= 0 || strlen($this->name) > 30) {
			$this->addError('Некорректная длина имени города:' . $this->name);
		} else if(strlen($this->description) <= 0 || strlen($this->description) > 30) {
			$this->addError('Некорректная длина описания:' . $this->name);
		}

		if(!count($this->getErrors())) {
			$this->saveTown();
		}
	}
}