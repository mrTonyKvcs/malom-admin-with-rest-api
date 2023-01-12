<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'store_id', 'title', 'slug', 'description', 'path', 'thumbnail', 'video_path', 'started_at', 'finished_at', 'published_at', 'featured_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'started_at', 'finished_at', 'featured_at', 'deleted_at', 'published_at',
    ];

    //protected $with = [ 'store' ];

    /**
     * Offer belongs to a store.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Offer belongs to a category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
