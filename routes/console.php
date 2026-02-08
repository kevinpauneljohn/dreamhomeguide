<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('appointments:check-due')->hourly()
->withoutOverlapping(10)->runInBackground();

Schedule::command('tasks:check-due')->hourly()
    ->withoutOverlapping(10)->runInBackground();

Schedule::command('leads:update-statuses')->dailyAt('06:00')
    ->withoutOverlapping(10)->runInBackground();

