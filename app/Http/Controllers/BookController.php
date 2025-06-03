<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;
use App\Models\Author;

class BookController extends Controller
{
    public function book_find_author()
    {
        // $book = App\Models\Books::find(1);
        $book = Books::find(1);
        $authors = $book->author;
        return $authors;
    }

    public function author_find_book(){
        $author = Author::find(1);
        // $author = App\Models\Author::find(1);
        $books = $author->books;
        return $books;

    }
}
