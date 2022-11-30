<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wish extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'age', 'phone_number', 'content', 'is_validated' , 'accept_gdpr'];
}
