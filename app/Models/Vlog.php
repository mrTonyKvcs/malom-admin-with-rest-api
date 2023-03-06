<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vlog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'video_id', 'title', 'description', 'embed_code', 'published_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
