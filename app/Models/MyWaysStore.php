<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyWaysStore extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'myway_store_id', 'store_id'];
}
