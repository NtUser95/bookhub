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
        $sql = 'SELECT g.* FROM authors LEFT JOIN books_authors bg ON g.id = bg.author_id WHERE bg.book_id = :book_id AND bg.author_id = :author_id';
        $dbData = App::$db->execute($sql, [':book_id' => $bookId, ':author_id' => $authorId]);
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
        $sql = 'SELECT g.* FROM authors LEFT JOIN books_authors bg ON g.id = bg.author_id WHERE bg.book_id = :book_id';
        $dbData = App::$db->execute($sql, [':book_id' => $bookId]);
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
        return App::$db->execute('UPDATE `books_authors` SET `book_id` = :book_id WHERE `book_id` = :fbook_id AND `author_id` = :author_id', [
            ':book_id' => $bookId,
            ':f_book_id' => $bookId,
            ':author_id' => $authorId,
        ]);
    }

    public static function addRelated(int $bookId, int $authorId)
    {
        return App::$db->execute('INSERT INTO `books_authors`(`book_id`, `author_id`) VALUES (:book_id, :author_id);', [
            ':book_id' => $bookId,
            ':author_id' => $authorId,
        ]);
    }

    public static function save(Author $author)
    {
        $sql = 'UPDATE `authors` SET `name` = :name WHERE `id` = :author_id';
        App::$db->execute($sql, [
            ':name' => $author->getName(),
            ':author_id' => $author->getId(),
        ]);
    }

    public static function getAll()
    {
        return self::findBy([]);
    }
}