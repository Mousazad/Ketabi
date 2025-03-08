<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
	{
		$A = Book::all();
		return view('books.index', ['books'=>$A]);
	}
}
