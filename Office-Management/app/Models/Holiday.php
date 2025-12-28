<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $table = 'holidays';

    protected $fillable = [
        'date',
        'title',
        'description',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if ($model->date < Carbon::today()) {
                throw new Exception("Maximum 6 days weekly holiday allowed", 422);
            }
        });
    }
}
