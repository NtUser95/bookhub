<?php

namespace Controllers;

use \App\Controller;
use Models\Book\BooksRepository;

class BooksController extends Controller
{
    public function index(): string
    {
        return $this->render('books_index', [
            'books' => BooksRepository::findBy($_GET),
        ]);
    }

    public function view($params = [])
    {

    }
}