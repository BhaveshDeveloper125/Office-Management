<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class WeeklyHoliday extends Model
{
    protected $table = 'weekly_holidays';
    protected $fillable = ['day'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (static::count() >= 6) {
                throw new Exception("Maximum 6 days weekly holiday allowed", 422);
            }
        });
    }
}
