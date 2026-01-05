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
            $from = Carbon::parse($model->from);
            $to = Carbon::parse($model->to);

            $workingDays = 0;
            $weekends = WeeklyHoliday::pluck('day')->toArray();

            while ($from->lte($to)) {
                if (!in_array($from->isoWeekday(), $weekends)) {
                    $workingDays++;
                }
                $from->addDay();
            }

            $model->days = $workingDays;
        });

        static::creating(function ($model) {
            if (Carbon::parse($model->from) < Carbon::today() || $model->to < $model->from) {
                throw new Exception("Can not set the past date for the Holiday", 422);
            }
        });
    }
}
