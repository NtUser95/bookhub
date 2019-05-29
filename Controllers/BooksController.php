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
            $form->processFormData();
            if (!$form->hasErrors()) {
                $status = ['status' => 'success', 'warnings' => ''];
                $form->reset();
            } else {
                $status = ['status' => 'failed'];
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
            $form->processFormData();
            if (!$form->hasErrors()) {
                $status = ['status' => 'success', 'warnings' => ''];
                $form->reset();
            } else {
                $status = ['status' => 'failed', 'warnings' => $form->getErrors()];
            }
        }

        return $this->render('books_add', [
            'form' => $form,
        ]);
    }
}