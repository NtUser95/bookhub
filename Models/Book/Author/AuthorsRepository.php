<?php

namespace Models\Book\Author;

use App\App;
use Models\Book\SearchQuery;

class AuthorsRepository
{

    /**
     * 'book_id'
     */
    public static function findBy($params = []): array
    {
        $searchQuery = new SearchQuery('authors');
        if (isset($params['from'])) {
            $searchQuery->setOffset($params['from']);
            $searchQuery->setLimit($params['limit'] ?? 100);
        }
        if (isset($params['limit'])) {
            $searchQuery->setLimit($params['limit']);
        }
        if (isset($params['name'])) {
            $searchQuery->addFilter('name', $params['name']);
        }

        $dbData = $searchQuery->execute();
        $authors = [];
        if (is_array($dbData)) {
            foreach ($dbData as $value) {
                $data = [
                    'id' => $value['id'],
                    'name' => $value['name'],
                ];
                try {
                    $authors[] = Author::create($data);
                } catch (\Exception $e) {
                    trigger_error($e->getMessage());
                    return [];
                }
            }
        }

        return $authors;
    }

    public static function getRelated(int $bookId, int $authorId)
    {
        $sql = 'SELECT g.* FROM authors LEFT JOIN books_authors bg ON g.id = bg.author_id WHERE bg.book_id = ? AND bg.author_id = ?';
        $dbData = App::$db->execute($sql, [$bookId, $authorId]);
        if (is_array($dbData) && isset($dbData[0])) {
            return Author::create($dbData[0]);
        } else {
            return null;
        }
    }

    /**
     * Метод возвращает уникальные жанры связанные методом "многие ко многим" с сущностью.
     * Принимает массив значений
     * book_id
     */
    public static function findRelated(int $bookId)
    {
        $sql = 'SELECT g.* FROM authors LEFT JOIN books_authors bg ON g.id = bg.author_id WHERE bg.book_id = ?';
        $dbData = App::$db->execute($sql, [$bookId]);
        $authors = [];
        if (is_array($dbData)) {
            foreach ($dbData as $data) {
                $authors[] = Author::create($data);
            }
        }

        return $authors;
    }

    public static function setRelated(int $bookId, int $authorId)
    {
        return App::$db->execute('UPDATE `books_authors` SET `book_id` = ? WHERE `book_id` = ? AND `author_id` = ?', [
            $bookId,
            $bookId,
            $authorId,
        ]);
    }

    public static function addRelated(int $bookId, int $authorId)
    {
        return App::$db->execute('INSERT INTO `books_authors`(`book_id`, `author_id`) VALUES (?, ?);', [
            $bookId,
            $authorId,
        ]);
    }

    public static function save(Author $author)
    {
        $sql = 'UPDATE `authors` SET `name` = ? WHERE `id` = ?';
        App::$db->execute($sql, [
            $author->getName(),
            $author->getId(),
        ]);
    }

    public static function getAll()
    {
        return self::findBy([]);
    }
}