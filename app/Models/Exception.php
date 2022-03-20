<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exception extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id', 'date', 'open_time', 'close_time'
    ];

    protected $dates = ['date'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
