<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\CheckDueDateAppointments;
use App\Console\Commands\CheckDueTasks;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('appointments:check-due')->everyMinute()
->withoutOverlapping(10)->runInBackground();

Schedule::command('tasks:check-due')->everyMinute()
    ->withoutOverlapping(10)->runInBackground();

