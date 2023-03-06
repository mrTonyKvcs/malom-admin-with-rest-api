<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class YouTubeVideo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'youtube_videos';
    protected $fillable = ['playlist_name', 'video_id', 'title', 'description', 'order', 'published_at'];
}
