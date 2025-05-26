<?php

namespace App\Http\Controllers;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class AuthorController extends Controller
{
    public function index()
    {
        $A = Author::all();
        return view('authors.index', ['authors' => $A]);
    }

    public function search(Request $request){
        $book = Book::find($request->book_id);
        $key = $request->key;

        $result = Author::whereNotIn('id', $book->authors->pluck('id'))
                            ->where('name','like','%'.$key.'%')
                            ->get();

        return $result;
    }

    public function show(Author $author)
    {
        if (! $author) {
            return abort(404);
        }
        $author->created_at = Jalalian::fromDateTime($author->created_at)->format('Y/m/d H:m:s');
        $author->updated_at = Jalalian::fromDateTime($author->updated_at)->format('Y/m/d H:m:s');
        return view('authors.show', ['author' => $author]);
    }
    public function create(Request $request)
    {
        $request->validate([
                'name'            => 'required|string|max:255',
                'nationality' => 'string|max:30',
            ],
            [
            'name.required' => 'نام نویسنده الزامی است',
            'nationality.max' => 'ملیت حداکثر 30 حرف است.'
        ]);

        Author::create(['name' => $request->name, 'nationality' => $request->nationality]);
        return redirect()->back();
    }
}
