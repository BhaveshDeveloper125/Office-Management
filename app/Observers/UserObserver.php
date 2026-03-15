<?php

namespace App\Observers;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    /**
     * Handle the Users "created" event.
     */
    public function created(User $user): void
    {
        $to=$user->email;
        $subject="Welcome to Employee Attendance System";
        $msg="Dear $user->name, Welcome to Employee Attendance System";
        Mail::to($to)->send(new WelcomeMail($subject, $msg));
    }

    /**
     * Handle the Users "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the Users "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the Users "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the Users "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
