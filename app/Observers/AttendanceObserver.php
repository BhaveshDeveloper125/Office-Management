<?php

namespace App\Observers;

use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceObserver
{
    /**
     * Handle the Attendance "created" event.
     */
    public function created(Attendance $attendance): void
    {
        //
    }

    /**
     * Handle the Attendance "updated" event.
     */
    public function updated(Attendance $attendance): void
    {
        //
    }

    public function updating(Attendance $attendance): void
    {
        if ($attendance->isDirty('checkout') && $attendance->checkout) {
            $checkin = Carbon::parse($attendance->checkin);
            $checkout = Carbon::parse($attendance->checkout);

            if ($checkout->greaterThan($checkin)) {
                $diff = $checkout->diff($checkin);
                $attendance->hours = $diff->format('%H:%I:%S');
            } else {
                $attendance->hours = "00:00:00";
            }
        }
    }

    /**
     * Handle the Attendance "deleted" event.
     */
    public function deleted(Attendance $attendance): void
    {
        //
    }

    /**
     * Handle the Attendance "restored" event.
     */
    public function restored(Attendance $attendance): void
    {
        //
    }

    /**
     * Handle the Attendance "force deleted" event.
     */
    public function forceDeleted(Attendance $attendance): void
    {
        //
    }
}
