<?php

namespace App\Providers;

use App\Models\Attendance;
use App\Models\Leave;
use App\Models\User;
use App\Models\WeeklyHoliday;
use App\Observers\AttendanceObserver;
use App\Observers\LeaveObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Attendance::observe(AttendanceObserver::class);
        User::observe(UserObserver::class);
        Leave::observe(LeaveObserver::class);

        Gate::define('MaximumHolidaysRestriction', function (?User $user = null) {
            return WeeklyHoliday::count() < 7 ? Response::allow() : Response::deny('Maximum 6 days weekly holiday allowed', 422);
        });
    }
}
