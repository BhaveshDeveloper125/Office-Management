<?php

namespace App\Providers;

use App\Models\Attendance;
use App\Models\User;
use App\Models\WeeklyHoliday;
use App\Observers\AttendanceObserver;
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

        Gate::define('MaximumHolidaysRestriction', function (?User $user = null) {
            return WeeklyHoliday::count() < 7 ? Response::allow() : Response::deny('Maximum 6 days weekly holiday allowed', 422);
        });
    }
}
