<?php

namespace Models\Book;

use Models\Book\Author\AuthorsRepository;
use Models\Book\Genre\GenreRepository;
use Models\Form\EditableForm;

class EditForm extends EditableForm
{
    public $id;
    public $cover_image_url;
    public $name;
    public $description;
    public $published_date;
    public $authors;
    public $genres;

    public function validateUploadData(): bool
    {
        if (!$this->id) {
            $this->addError('Некорректный ID книги.');
        } elseif ($this->name && strlen($this->name) > 255) {
            $this->addError('Название книги не должо превышать 255 символов.');
        } elseif ($this->name && strlen($this->description) > 255) {
            $this->addError('Описание книги не должо превышать 255 символов.');
        } elseif ($this->published_date && ((int) $this->published_date > 214999999999999 || (int) $this->published_date <= 0)) {
            $this->addError('Некорректная дата.');
        }

        return !$this->getErrors();
    }

    public function handleUploadData()
    {
        $book = BooksRepository::get((int) $this->id);

        if ($this->authors) {
            $this->authors = trim(str_replace(', ', ',', $this->authors));
            $rawAuthors = explode(',', $this->authors);
            $authors = [];
            foreach ($rawAuthors as $author) {
                $authors = array_merge(AuthorsRepository::findBy(['name' => $author]), $authors);
            }
            $book->setAuthors($authors);
        }
        if ($this->genres) {
            $this->genres = str_replace(', ', ',', $this->genres);
            $rawGenres = explode(',', $this->genres);
            $genres = [];
            foreach ($rawGenres as $genre) {
                $genres = array_merge(GenreRepository::findBy(['name' => $genre]), $genres);
            }
            $book->setGenre($genres);
        }
        if ($this->published_date && $fTime = strtotime($this->published_date)) {
            $book->setPublishedDate($fTime);
        }
        if ($this->name) {
            $book->setName($this->name);
        }
        if ($this->description) {
            $book->setDescription($this->description);
        }
        if ($this->cover_image_url) {
            $book->setImageUrl($this->cover_image_url);
        }

        BooksRepository::save($book);
    }
}