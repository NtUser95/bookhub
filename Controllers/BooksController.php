<?php

namespace Controllers;

use \App\Controller;
use Models\Book\AddForm;
use Models\Book\EditForm;
use Models\Book\BooksRepository;

class BooksController extends Controller
{
    public function index(): string
    {
        return $this->render('books_index', [
            'books' => BooksRepository::findBy($_GET),
        ]);
    }

    public function edit(): string
    {
        $form = new EditForm();
        if ($form->load()) {
            if ($form->validateUploadData()) {
                $form->handleUploadData();
                $form->reset();
            } else { // show errors..

            }
        }

        return $this->render('books_edit', [
            'form' => $form,
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

        return $this->render('books_add', [
            'form' => $form,
        ]);
    }
}