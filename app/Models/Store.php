<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory; use SoftDeletes;

    protected $fillable = [
        'name', 'type', 'slug', 'floor', 'email', 'mondays_text', 'description', 'short_description', 'path', 'thumbnail', 'phone', 'opened_at',
    ];

    protected $dates = [
        'opened_at',
    ];

    /**
     * Get the categories associated with the given store.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Store has many business open hours.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hours()
    {
        return $this->hasMany(Hour::class);
    }

    /**
     * Store may has exceptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exceptions()
    {
        return $this->hasMany(Exception::class);
    }


    /**
     * Social has many offers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socials()
    {
        return $this->hasMany(Social::class);
    }
}