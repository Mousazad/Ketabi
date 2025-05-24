<?php

namespace Database\Factories;
use App\Models\Book;

use Illuminate\Database\Eloquent\Factories\Factory;
class BookFactory extends Factory
{
    protected $model = Book::class;
    public function definition()
    {
        return [
            'title'            => $this->faker->sentence(),
            'publication_year' => $this->faker->year(),
            'add_by'           => 1,
            'cover_file'       => 'covers/' . $this->faker->uuid() . '.jpg', // Generates a unique filename
        ];
    }
}
