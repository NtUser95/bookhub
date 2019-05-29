<?php

namespace Models\Book;

use App\App;

class Book {
	/** @var integer */
	private $_id;
	/** @var array */
	private $_genre = [];
	/** @var integer */
	private $_publishedDate = 0;
	/** @var array[] */
	private $_authors = [];
	/** @var string */
	private $_name;
	/** @var string */
	private $_description;

	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->_id;
	}

	/**
	 * @return array
	 */
	public function getAuthors(): array {
		return $this->_authors;
	}

	/**
	 * @param array $authors
	 */
	public function setAuthors(array $authors) {
		$this->_authors = $authors;
	}

	public function addAuthor(Author $author) {
		$this->_authors[] = $author;
	}

	/**
	 * @return string
	 */
	public function getDescription(): string {
		return $this->_description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription(string $description) {
		$this->_description = $description;
	}

	/**
	 * @return array
	 */
	public function getGenre(): array {
		return $this->_genre;
	}

	/**
	 * @param array $genre
	 */
	public function setGenre(array $genre) {
		$this->_genre = $genre;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->_name;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name) {
		$this->_name = $name;
	}

	/**
	 * @return int
	 */
	public function getPublishedDate(): int {
		return $this->_publishedDate;
	}

	/**
	 * @param int $publishedDate
	 */
	public function setPublishedDate(int $publishedDate) {
		$this->_publishedDate = $publishedDate;
	}

	public function toAssocArray() {
		return [
			'description' => $this->_description,
			'name' => $this->_name,
			'published_date' => $this->_publishedDate,
			''
		];
	}

	/**
	 * Создаёт экземпляр книги, принимает массив со следующими параметрами:
	 * 1) string name
	 * 2) string description
	 * 3) int published_date
	 * 4) array authors
	 * 5) genre
	 *
	 * @param array $params
	 * @throws \Exception
	 * @return Book
	 */
	public static function create($params = []): Book {
		if (!isset($params['name']) || !isset($params['description']) || !isset($params['published_date'])) {
			throw new \Exception('Invalid object data:' . json_encode($params));
		} else if (!is_array($params['authors']) || !is_array($params['genres'])) {
			throw new \Exception('Invalid object data:' . json_encode($params));
		}

		$book = new Book();
		$book->setName($params['name']);
		$book->setDescription($params['description']);
		$book->setPublishedDate($params['published_date']);
		$book->setAuthors($params['authors']);
		$book->setGenre($params['genres']);

		if (isset($params['id']) && $params['id']) {
			$book->_id = (int) $params['id'];
		} else {
			$sql = 'INSERT INTO book (`name`, `description`, `published_date`) VALUES ( :name , :description , :published_date );';
			App::$db->execute($sql, [
				':name' => $params['name'],
				':description' => $params['description'],
				':published_date' => $params['published_date'],
			]);
			$book->_id = (int) App::$db->getLastInsertId();
		}

		return $book;
	}
}