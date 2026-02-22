<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Leave extends Model
{
    protected $table='leaves';
    protected $fillable = [
        'user_id',
        'title',
        'duration_type',
        'from',
        'to',
        'leave_type',
        'description',
        'approve'
    ];

    protected $appends = ['total_days'];

    public function totalDays(): Attribute
    {
        return Attribute::make(
            get: function () {
                $from = \Carbon\Carbon::parse($this->from);
                $to = \Carbon\Carbon::parse($this->to);
                return $from->diffInDays($to) + 1;
                // +1 to include both start and end date
            }
        );
    }

    protected static function booted()
    {
        static::creating(function($modelInstance){
            $modelInstance->user_id = Auth::id();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
