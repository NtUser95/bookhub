<?php

namespace Models\Book\Genre;

use App\App;
use Models\Book\Book;
use Models\Book\SearchQuery;

class GenreRepository {
	/**
	 * 'book_id'
	 */
	public static function findBy($params = []): array {
		$searchQuery = new SearchQuery('genres');
		if (isset($params['from'])) {
			$searchQuery->setOffset($params['from']);
			$searchQuery->setLimit($params['limit'] ?? 100);
		}
		if (isset($params['limit'])) {
			$searchQuery->setLimit($params['limit']);
		}

		$dbData = $searchQuery->execute();
		$genres = [];
		if (is_array($dbData)) {
			foreach ($dbData as $value) {
				$data = [
					'id' => $value['id'],
					'name' => $value['name'],
				];
				try {
					$genres[] = Genre::create($data);
				} catch (\Exception $e) {
					trigger_error($e->getMessage());
					return [];
				}
			}
		}

		return $genres;
	}

	public static function getRelated(int $bookId, int $genreId) {
		$sql = 'SELECT g.* FROM genres LEFT JOIN books_genres bg ON g.id = bg.genre_id WHERE bg.book_id = :book_id AND bg.genre_id = :genre_id';
		$dbData = App::$db->execute($sql, [':book_id' => $bookId, ':genre_id' => $genreId]);
		if (is_array($dbData) && isset($dbData[0])) {
			return Genre::create($dbData[0]);
		} else {
			return null;
		}
	}

	/**
	 * Метод возвращает уникальные жанры связанные методом "многие ко многим" с сущностью.
	 * Принимает массив значений
	 * book_id
	 */
	public static function findRelated(int $bookId) {
		$sql = 'SELECT g.* FROM genres LEFT JOIN books_genres bg ON g.id = bg.genre_id WHERE bg.book_id = :book_id';
		$dbData = App::$db->execute($sql, [':book_id' => $bookId]);
		$genres = [];
		if (is_array($dbData)) {
			foreach ($dbData as $data) {
				$genres[] = Genre::create($data);
			}
		}

		return $genres;
	}

	public static function setRelated(int $bookId, int $genreId) {
		return App::$db->execute('UPDATE `books_genres` SET `book_id` = :book_id WHERE `book_id` = :fbook_id AND `genre_id` = :genre_id', [
			':book_id' => $bookId,
			':f_book_id' => $bookId,
			':genre_id' => $genreId,
		]);
	}

	public static function addRelated(int $bookId, int $genreId) {
		return App::$db->execute('INSERT INTO `books_genres`(`book_id`, `genre_id`) VALUES (:book_id, :genre_id);', [
			':book_id' => $bookId,
			':genre_id' => $genreId,
		]);
	}

	public static function save(Genre $genre) {
		$sql = 'UPDATE `genres` SET `name` = :name WHERE `id` = :genre_id';
		App::$db->execute($sql, [
			':name' => $genre->getName(),
			':genre_id' => $genre->getId(),
		]);
	}

	public static function getAll() {
		return self::findBy([]);
	}
}