<?php

use App\Models\Book;
use App\Models\User;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows a book with authors', function () {
    // Create a user & authenticate
    $user = User::factory()->create();
    $this->actingAs($user);

    // Create a book with authors
    $book = Book::factory()->create();
    $authors = Author::factory()->count(2)->create();
    $book->authors()->attach($authors);

    // Send GET request to show the book
    $response = $this->get(route('book.show', $book->id));

    // Assertions
    $response->assertStatus(200);
    $response->assertViewIs('book.show');
    $response->assertViewHas('book', fn($b) => $b->id === $book->id);
    $this->assertEquals(2, $book->authors->count()); // Ensure authors are loaded
});

it('returns 404 when book is not found', function () {
    $response = $this->get(route('book.show', 9999)); // Non-existent book ID

    $response->assertStatus(404);
});
