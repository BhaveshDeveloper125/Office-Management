<?php

namespace App\Observers;

use App\Mail\LeaveApprove;
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
        if ($leave->approve == config('LeavesVars.leave_approval.Approved')) {
            $subject = "Leave Approved";
            $msg = "Your leave request has been approved";
            Mail::to($leave->user->email)->send(new LeaveApprove($subject, $msg));
        }

        // if ($leave->status == false) {
        //     $subject = "Leave Rejected";
        //     $msg = "Your leave request has been rejected";
        //     Mail::to($leave->user->email)->send(new LeaveApprove($subject, $msg));
        // }
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
