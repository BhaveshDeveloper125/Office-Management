<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;

class AttendancePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function CheckIn(User $user)
    {

        if (Attendance::whereBetween('checkin', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->where('user_id', $user->id)->exists()) {
            return Response::deny('You have already checkin');
        } elseif (Attendance::where('user_id', $user->id)->whereNull('checkout')->exists()) {
            return Response::deny('Please Checkout for the previous Dates');
        }

        return Response::allow();
    }
}
