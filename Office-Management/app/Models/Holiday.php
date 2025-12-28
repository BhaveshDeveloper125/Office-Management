<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $table = 'holidays';

    protected $fillable = [
        'from',
        'to',
        'title',
        'description',
        'days',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            $model->days = Carbon::parse($model->from)->diffInDays(Carbon::parse($model->to)) + 1;
        });

        static::creating(function ($model) {
            if (Carbon::parse($model->from) < Carbon::today() || $model->to < $model->from) {
                throw new Exception("Can not set the past date for the Holiday", 422);
            }
        });
    }
}
