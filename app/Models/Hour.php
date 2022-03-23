<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function getDayOfWeekAttribute($value){
        switch ($value) {
            case 0:
                return 'Vasárnap';
                break;

            case 1:
                return 'Hétfő';
                break;

            case 2:
                return 'Kedd';
                break;

            case 3:
                return 'Szerda';
                break;

            case 4:
                return 'Csütörtök';
                break;

            case 5:
                return 'Péntek';
                break;

            case 6:
                return 'Szombat';
                break;
            
            default:
                return $value;
                break;
        }
    }
}
