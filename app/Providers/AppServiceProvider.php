<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\Leads;
use App\Models\Task;
use App\Observers\AppointmentObserver;
use App\Observers\LeadObserver;
use App\Observers\TaskObserver;
use Illuminate\Pagination\Paginator;
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
        Leads::observe(LeadObserver::class);
        Appointment::observe(AppointmentObserver::class);
        Task::observe(TaskObserver::class);

        Paginator::useBootstrapFive();
        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super admin') ? true : null;
        });
    }
}
