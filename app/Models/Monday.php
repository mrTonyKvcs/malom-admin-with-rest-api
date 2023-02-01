<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monday extends Model
{
    protected $fillable = [
        'title', 'published_at', 'path', 'slug'
    ];

    protected $dates = [
        'published_at'
    ];
}
