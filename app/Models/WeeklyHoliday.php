<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WeeklyHoliday extends Model
{
    protected $table = 'weekly_holidays';
    protected $fillable = ['day' , 'created_by'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            $model->created_by = Auth::id();

            if (static::count() >= 6) {
                throw new Exception("Maximum 6 days weekly holiday allowed", 422);
            }
        });
    }
}
