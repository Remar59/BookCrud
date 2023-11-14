<?php

namespace M2i\Mvc\Controller;

use M2i\Mvc\Model\Book;
use M2i\Mvc\View;

class BookController
{
    public function list()
    {
        $title = 'Livres';
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
}