<?php

namespace M2i\Mvc\Controller;

use M2i\Mvc\Model\Book;
use M2i\Mvc\View;

class BookController
{
    public function list()
    {
        $title = 'livres';
        $books = Book::all();

        return View::render('books/list', [
            'title' => $title,
            'books' => $books,
        ]);
    }

    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            http_response_code(404);
            return View::render('404');
        }

        return View::render('show', [
            'book' => $book,
        ]);
    }
    

    public function add()
    {
        return View::render('ajout');
    }


    public function create()
    {
        $book = new Book();
        $book->title = $_POST['title'] ?? null;
        $errors = [];

        if (!empty($_POST)) {
            if (empty($book->title)) {
                $errors['name'] = 'Le nom est invalide.';
            }

            if (empty($errors)) {
// dans le save on met le nom des colonnes de la table
// peut être réutiliser en ajoutant des champs sur une autre variable (book, car...)

                $book->save(['title','price','discount','isbn','author','published_at','image']);
                //view redirect vers utilisateurs

            }
        }

        return View::render('ajout', [
            'errors' => $errors,
            'user' => $book,
        ]);
    }
}