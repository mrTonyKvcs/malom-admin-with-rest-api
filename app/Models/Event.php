<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'store_id', 'title', 'slug', 'description', 'path', 'thumbnail', 'started_at', 'finished_at', 'published_at', 'featured_at', 'galleried_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'started_at', 'finished_at', 'published_at', 'deleted_at', 'featured_at'
    ];

    /**
     * Event belongs to a store.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
