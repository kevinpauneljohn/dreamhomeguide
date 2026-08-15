<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\Leads;
use App\Models\Task;
use App\Observers\AppointmentObserver;
use App\Observers\LeadObserver;
use App\Observers\TaskObserver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
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

        RateLimiter::for('submit-inquiry', function (Request $request) {
            return Limit::perMinutes(20, 1)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Too many inquiry submissions.',
                        'notice' => 'Please wait 20 minutes before submitting another inquiry.',
                    ], 429, $headers);
                });
        });
    }
}
