<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
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

    public function removeAuthor($book, $author)
    {  
        $book = Book::find($book);
        if (! $book) {
            return abort(404);
        }
        $book->authors()->detach($author);
        return redirect()->back();
    }
    public function addAuthor($book, $author)
    {  
        $book = Book::find($book);
        if (! $book) {
            return abort(404);
        }
        $book->authors()->attach($author);
        return redirect()->back();
    }
    public function destroy($book)
    {
        $book = Book::with('authors')->find($book);
        if (! $book) {
            return abort(404);
        }
        $book->delete();
        return redirect("/books");
    }

    public function edit($book)
    {
        $book = Book::with('authors')->find($book);
        if (! $book) {
            return abort(404);
        }
        $noAuthor= Author::whereNotIn('id', $book->authors->pluck('id'))->get();
        return view('books.edit', ['book' => $book, 'noAuthor'=> $noAuthor]);
    }

    
    public function update(Request $request, $book)
    {
        $book = Book::find($book);
        if (! $book) {
            return abort(404);
        }

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'publication_year' => 'required|int|min:0',
        ],
		[
            'title.required' => 'You have to have a title!',
            'publication_year.min' => 'سال انتشار حداقل 1 باشد.'
        ]);
      
        $book->title = $request->title;
        $book->publication_year = $request->publication_year;
        $book->update();
        
        return view('books.show', ['book' => $book]);
    }


}