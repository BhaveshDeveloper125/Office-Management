<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLeave extends Model
{
    protected $table = 'user_leaves';
    protected $fillable = [
        'user_id',
        'leaves',
        'year'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
