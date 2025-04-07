<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsAnAdmin;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/books', [BookController::class, 'index']);
Route::get('/book/{book}', [BookController::class, 'show'])->name('book.show');
Route::post('/books/create', [BookController::class, 'create'])->name('book.create')->middleware(['auth',EnsureUserIsAnAdmin::class]);

Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/author/{author}', [AuthorController::class, 'show'])->name('author.show');
Route::post('/authors/create', [AuthorController::class, 'create'])->name('author.create')->middleware(['auth',EnsureUserIsAnAdmin::class]);


require __DIR__ . '/auth.php';