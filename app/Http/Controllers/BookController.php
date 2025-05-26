<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{

    public function factorial($N): int{
        $f = 1;
        for($i=2;$i<=$N;$i++){
            $f *= $i;
        }
        return $f;
    }
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
            'cover_file' => 'mimes:jpg,jpeg,gif,bmp,png|max:2048',            
        ],
		[
            'title.required' => 'You have to have a title!',
            'publication_year.min' => 'سال انتشار حداقل 1 باشد.',
            'cover_file.max' => 'حداکثر اندازه فایل 2048 بایت است.',
            'cover_file.mimes' => 'فقط فایل با پسوند jpg، jpeg، gif، bmp و png قابل قبول است.'
        ]);


        $coverfile = $request->file('cover_file');
		$filename = $coverfile->getClientOriginalName();
		$newfilename = sha1(time() . rand(1000000, 9999999) . $filename) . '.' . $coverfile->extension();
		Storage::putFileAs('/covers', $coverfile, $newfilename,  'public');

        $book = Book::create([  'title' => $request->title,
                                            'publication_year' => $request->publication_year,
                                            'add_by' => auth()->user()->id,
                                            'cover_file' => '/storage/covers/'.$newfilename
                                        ]);
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
            return "Failed";
        }
        $book->authors()->attach($author);
        return "OK";
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
        $book = Book::with('addBy')->find($book);
        if (! $book) {
            return abort(404);
        }

        //Direct Authorization
        //if( $book->addBy->id != auth()->user()->id )
        //    return abort(403);

        //Authorization by Gate
        //if (! Gate::allows('update-book', $book)) {
        //    abort(403);
        //}

        //Authorization by Policy
        if ($request->user()->cannot('update', $book)) {
            abort(403);
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