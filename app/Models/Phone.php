<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Phone extends Model
{
    protected $fillable = ['number','user_id','operator','active'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
