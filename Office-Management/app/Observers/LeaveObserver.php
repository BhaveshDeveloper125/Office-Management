<?php

namespace App\Observers;

use App\Mail\LeaveRequest;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class LeaveObserver
{
    /**
     * Handle the Leave "created" event.
     */
    public function created(Leave $leave): void
    {
        $superAdmins = User::role('Super Admin')->get();

        $subject = "Leave Request";
        $link = url('/emp_leave_management');
        $msg = "{$leave->user->name} applied for leave from {$leave->from} to {$leave->to} approve it <a href='{$link}'>Click Here</a>";

        foreach ($superAdmins as $admin) {
            Mail::to($admin->email)->send(new LeaveRequest($subject, $msg));
        }
    }

    /**
     * Handle the Leave "updated" event.
     */
    public function updated(Leave $leave): void
    {
        //
    }

    /**
     * Handle the Leave "deleted" event.
     */
    public function deleted(Leave $leave): void
    {
        //
    }

    /**
     * Handle the Leave "restored" event.
     */
    public function restored(Leave $leave): void
    {
        //
    }

    /**
     * Handle the Leave "force deleted" event.
     */
    public function forceDeleted(Leave $leave): void
    {
        //
    }
}
