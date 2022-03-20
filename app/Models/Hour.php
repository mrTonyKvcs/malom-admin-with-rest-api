<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hour extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id', 'day_of_week', 'open_time', 'close_time'
    ];

    /**
     * Hour belongs to store.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelngsTo
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

}
