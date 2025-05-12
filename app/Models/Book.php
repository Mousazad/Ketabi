<?php

namespace App\Models;

use App\Models\Author;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    protected $fillable = ['title','publication_year','cover_file'];
    public function authors():BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }   
}
