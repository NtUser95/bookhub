<?php

namespace Models\Book;

use App\App;
use Models\Book\Author\AuthorsRepository;
use Models\Book\Genre\GenreRepository;

class BooksRepository
{
    public static $DEFAULT_BOOK_PER_PAGE = 10;

    public static function findBy($params = []): array
    {
        $bookSearchQuery = new SearchQuery('books');

        if (isset($params['f_genre'])) {
            $bookSearchQuery->addFilter('genre', $params['f_genre']);
        }
        if (isset($params['f_year'])) {
            $bookSearchQuery->addFilter('published_date', $params['f_year']);
        }
        if (isset($params['f_author'])) {
            $bookSearchQuery->addFilter('author_id', $params['f_author']);
        }
        if (isset($params['s_year'])) {
            $sortType = $params['s_year'] === 'DESC' ? 'DESC' : 'ASC';
            $bookSearchQuery->addSort('published_date', $sortType);
        }
        if (isset($params['s_name'])) {
            $sortType = $params['s_year'] === 'DESC' ? 'DESC' : 'ASC';
            $bookSearchQuery->addSort('name', $sortType);
        }
        if (isset($params['from'])) {
            $bookSearchQuery->setOffset($params['from']);
            $bookSearchQuery->setLimit($params['limit'] ?? BooksRepository::$DEFAULT_BOOK_PER_PAGE);
        }
        if (isset($params['limit'])) {
            $bookSearchQuery->setLimit($params['limit']);
        }

        $dbData = $bookSearchQuery->execute();
        $books = [];
        if (is_array($dbData)) {
            foreach ($dbData as $value) {
                $data = [
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'description' => $value['description'],
                    'published_date' => $value['published_date'],
                    'authors' => AuthorsRepository::findBy(['book_id' => (int)$value['id']]),
                    'genres' => GenreRepository::findBy(['book_id' => (int)$value['id']]),
                ];
                try {
                    $books[] = Book::create($data);
                } catch (\Exception $e) {
                    trigger_error($e->getMessage());
                    return [];
                }
            }
        }

        return $books;
    }

    /**
     * @param int $id
     * @return Book|null
     */
    public static function get(int $id):? Book
    {
        if (!$id) {
            return null;
        }

        $book = null;
        $bookSearchQuery = new SearchQuery('books');
        $bookSearchQuery->addFilter('id', $id);

        $dbData = $bookSearchQuery->execute();
        if (is_array($dbData)) {
            $data = [
                'id' => $dbData[0]['id'],
                'name' => $dbData[0]['name'],
                'description' => $dbData[0]['description'],
                'published_date' => $dbData[0]['published_date'],
                'authors' => AuthorsRepository::findBy(['book_id' => (int) $dbData[0]['id']]),
                'genres' => GenreRepository::findBy(['book_id' => (int) $dbData[0]['id']]),
            ];
            try {
                $book = Book::create($data);
            } catch (\Exception $e) {
                trigger_error($e->getMessage());
            }
        }

        return $book;
    }

    public static function save(Book $book)
    {
        $sql = 'UPDATE `books` SET `name` = ?, `description` = ?, `published_date` = ? WHERE `id` = ?';
        App::$db->execute($sql, [
            $book->getName(),
            $book->getDescription(),
            $book->getPublishedDate(),
            $book->getId(),
        ]);
        foreach ($book->getGenre() as $genre) {
            if (GenreRepository::getRelated($book->getId(), $genre->getId()) !== null) {
                GenreRepository::setRelated($book->getId(), $genre->getId());
            } else {
                GenreRepository::addRelated($book->getId(), $genre->getId());
            }
        }
        foreach ($book->getAuthors() as $author) {
            if (AuthorsRepository::getRelated($book->getId(), $author->getId()) !== null) {
                AuthorsRepository::setRelated($book->getId(), $author->getId());
            } else {
                AuthorsRepository::addRelated($book->getId(), $author->getId());
            }
        }
    }

    public static function getAll()
    {
        return self::findBy([]);
    }
}