<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $A = Book::all();
        return view('books.index', ['books' => $A]);
    }

    public function show($book)
    {
        $book = Book::with('authors')->find($book);
        if (! $book) {
            return abort(404);
        }
        return view('books.show', ['book' => $book]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'publication_year' => 'required|int|min:0',
        ],
		[
        'title.required' => 'You have to have a title!',
        'publication_year.min' => 'سال انتشار حداقل 1 باشد.'
    ]);

        $book = Book::create(['title' => $request->title, 'publication_year' => $request->publication_year]);
        return redirect()->back();
    }

}