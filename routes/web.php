<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsAnAdmin;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/book/{book}', [BookController::class, 'show'])->name('book.show');
Route::post('/books/create', [BookController::class, 'create'])->name('book.create')->middleware(['auth',EnsureUserIsAnAdmin::class]);
Route::get('/book/{book}/delete', [BookController::class, 'destroy'])->name('book.destroy')->middleware(['auth',EnsureUserIsAnAdmin::class]);

Route::get('/book/{book}/edit', [BookController::class, 'edit'])->name('book.edit')->middleware(['auth',EnsureUserIsAnAdmin::class]);
Route::post('/book/{book}/update', [BookController::class, 'update'])->name('book.update')->middleware(['auth',EnsureUserIsAnAdmin::class]);


Route::get('/book/{book}/remove_author/{author}', [BookController::class, 'removeAuthor'])->name('book.removeAuthor')->middleware(['auth',EnsureUserIsAnAdmin::class]);
Route::get('/book/{book}/add_author/{author}', [BookController::class, 'addAuthor'])->name('book.addAuthor')->middleware(['auth',EnsureUserIsAnAdmin::class]);

Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/author/{author}', [AuthorController::class, 'show'])->name('author.show');
Route::post('/authors/create', [AuthorController::class, 'create'])->name('author.create')->middleware(['auth',EnsureUserIsAnAdmin::class]);
Route::get('/authors/search', [AuthorController::class, 'search'])->name('authors.search');


require __DIR__ . '/auth.php';