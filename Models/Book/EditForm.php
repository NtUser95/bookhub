<?php

namespace Models\Book;

use App\BaseForm;
use Models\Book\Author\AuthorsRepository;
use Models\Book\Genre\GenreRepository;

class EditForm extends BaseForm
{
    public $id;
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
        } elseif (!$this->id) {
            $this->addError('Некорректный ID');
        }

        return !$this->getErrors();
    }

    public function handleUploadData()
    {
        $imageUrl = null;
        $authors = [];
        $genres = [];

        if ($this->authors) {
            $authors = AuthorsRepository::findBy(['name' => $this->authors]);
        }
        if ($this->genres) {
            $genres = GenreRepository::findBy(['name' => $this->genres]);
        }

        $book = Book::create([
            'name' => $this->name,
            'description' => $this->description,
            'published_date' => $this->published_date,
            'cover_image_url' => $imageUrl,
            'authors' => $authors,
            'genres' => $genres,
        ]);

        BooksRepository::save($book);
    }
}