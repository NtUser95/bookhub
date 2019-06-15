<?php

namespace Models\Book;

use App\BaseForm;
use Models\Book\Author\AuthorsRepository;
use Models\Book\Genre\GenreRepository;

class AddForm extends BaseForm
{
    public $cover_image;
    public $name;
    public $description;
    public $published_date;
    public $authors;
    public $genres;

    public function validateUploadData(): bool
    {
        if (!$this->name || strlen($this->name) > 255) {
            $this->addError('Некорректная длина названия.');
        } elseif (strlen($this->description) > 255) {
            $this->addError('Некорректная длина описания.');
        } elseif (!$this->published_date && $this->published_date > 2149999999) {
            $this->addError('Некорректная дата.');
        }

        return !$this->getErrors();
    }

    public function handleUploadData()
    {
        $imageUrl = 'zhopa';
        $authors = [];
        $genres = [];

        if ($this->authors) {
            $authors = AuthorsRepository::findBy(['name' => $this->authors]);
        }
        if ($this->genres) {
            $genres = GenreRepository::findBy(['name' => $this->genres]);
        }

        $params = [
            'name' => $this->name,
            'description' => $this->description,
            'published_date' => strtotime($this->published_date),
            'cover_image_url' => $imageUrl,
            'authors' => $authors,
            'genres' => $genres,
        ];
        $book = Book::create($params);

        BooksRepository::save($book);
    }
}