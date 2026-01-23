<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Notifications\AppointmentDueNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckDueDateAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:check-due';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify agents with appointments due today';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $oneDayFromNow = Carbon::today()->addDay();
        $threeDaysFromNow = Carbon::today()->addDays(3);


        $appointments = Appointment::where('status', 'pending')
            ->whereNotNull('assigned_agent')
            ->where(function ($query) use ($today, $oneDayFromNow, $threeDaysFromNow) {
                $query->whereDate('appointment_date', $today)
                    ->orWhereDate('appointment_date', $oneDayFromNow)
                    ->orWhereDate('appointment_date', $threeDaysFromNow);
            })
            ->with(['agent'])
            ->get();


        foreach ($appointments as $appointment)
        {

            // Identify notification type
            if ($appointment->appointment_date->isSameDay($today)) {
                $type = 'due_today';
            } elseif ($appointment->appointment_date->isSameDay($oneDayFromNow)) {
                $type = 'due_in_1_day';
            } else {
                $type = 'due_in_3_days';
            }

            // Prevent duplicate notifications (per appointment + per type + per day)
            $alreadyNotified = $appointment->agent->notifications()
                ->where('type', \App\Notifications\AppointmentDueNotification::class)
                ->whereJsonContains('data->appointment_id', $appointment->id)
                ->whereJsonContains('data->appointment_date', $appointment->appointment_date->format('F d, Y | h:i A'))
                ->whereJsonContains('data->type', $type)
                ->whereDate('created_at', $today)
                ->exists();

            if ($alreadyNotified) {
                continue;
            }


            $appointment->agent->notify(
                new AppointmentDueNotification($appointment, $type, $type)
            );

            $this->info(
                "Appointment {$type} notification sent to {$appointment->agent->full_name}"
            );
        }
    }
}
