<?php

namespace App\Models;
use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    protected $fillable = ['name','nationality'];
   
    public function books():BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}
