<?php

namespace App\Models;

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

    protected static function booted()
    {
        static::creating(function($modelInstance){
            $modelInstance->user_id = Auth::id();
        });
    }

}
