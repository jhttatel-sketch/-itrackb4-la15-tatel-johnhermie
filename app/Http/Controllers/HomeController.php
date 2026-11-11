<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;

class HomeController extends Controller
{
    public function index()
    {
        $bookCount = Book::count();
        $genreCount = Genre::count();

        return view('home', compact('bookCount', 'genreCount'));
    }
}
