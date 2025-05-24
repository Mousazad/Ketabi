<?php

namespace App\Models;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title','publication_year','add_by','cover_file'];
    public function authors():BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }  
    
    public function addBy():BelongsTo
    {
        return $this->belongsTo(User::class,'add_by','id','users');
    }
}
