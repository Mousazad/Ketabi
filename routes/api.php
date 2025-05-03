<?php

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/user/login', [UserController::class, 'login']);

Route::post('/book/get', [BookController::class, 'getBook'])->middleware('auth:sanctum');
Route::post('/books', [BookController::class,'getAllBook'])->middleware('auth:sanctum');