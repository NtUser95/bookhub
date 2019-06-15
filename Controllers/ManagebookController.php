<?php

namespace Controllers;

use App\App;
use App\Controller;
use Models\Book\AddForm;
use Models\Book\BooksRepository;
use Models\Book\EditForm;

class ManagebookController extends Controller
{
    public function index()
    {
        return $this->render('managebook_index', [
            'books' => BooksRepository::findBy($_GET),
        ]);
    }

    public function edit($params = []): string
    {
        if (!isset($params['id']) || !$params['id']) {
            App::$user->setFlash('warning', 'Не передан ID книги');
            return $this->index();
        }
        $form = new EditForm();
        $book = BooksRepository::get((int) $params['id']);
        $form->initializeFrom($book->toAssocArray());
        if ($form->load()) {
            if ($form->validateUploadData()) {
                $form->handleUploadData();
            } else { // show errors..

            }
        }

        return $this->render('managebook_edit', [
            'form' => $form,
            'genres' => $book->getGenre(),
            'authors' => $book->getAuthors(),
        ]);
    }

    public function add(): string
    {
        $form = new AddForm();
        if ($form->load()) {
            if ($form->validateUploadData()) {
                $form->handleUploadData();
                $form->reset();
            } else { // show errors..

            }
        }

        return $this->render('managebook_add', [
            'form' => $form,
        ]);
    }
}