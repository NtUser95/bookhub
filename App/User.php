<?php

namespace App;

class User {

	private $flashes = [];

	/**
	 * @var string
	 */
	private $cityName;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var integer
	 */
	private $age;

	/**
	 * @var integer
	 */
	private $id;

	private $city_id;

	/**
	 * @return mixed
	 */
	public function getCityId()
	{
		return $this->city_id;
	}

	/**
	 * @param mixed $city_id
	 */
	public function setCityId($city_id)
	{
		$this->city_id = $city_id;
	}

	public function __construct() {
		
	}

	public function setFlash(String $type, String $msg) {
		$this->flashes[] = ['type' => $type, 'message' => $msg];
	}

	/**
	 * @return array
	 */
	public function getFlashes() {
		return $this->flashes;
	}

	/**
	 * @return string
	 */
	public function getCityName() {
		return $this->cityName;
	}

	/**
	 * @return integer
	 */
	public function getAge() {
		return $this->age;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param int $age
	 */
	public function setAge(int $age) {
		$this->age = $age;
	}

	/**
	 * @param string $cityName
	 */
	public function setCityName(string $cityName) {
		$this->cityName = $cityName;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name) {
		$this->name = $name;
	}

	/**
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param integer
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	function toArray(): array
	{
		return [
			'id' => $this->getId(),
			'city_id' => $this->getCityId(),
			'city_name' => $this->getCityName(),
			'name' => $this->getName(),
			'age' => $this->getAge()
		];
	}
}
