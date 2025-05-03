<?php
namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class BookController extends Controller
{

    public function getBook(Request $request){
        return Book::find($request->book);
    }
    public function getAllBook(Request $request){
        return Book::all();
    }

}