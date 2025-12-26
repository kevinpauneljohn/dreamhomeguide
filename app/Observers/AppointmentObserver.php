<?php

namespace App\Observers;

use App\Models\Appointment;
use App\Notifications\AppointmentAssignedNotification;
use App\Services\LeadService;

class AppointmentObserver
{
    public function __construct(private LeadService $leadService)
    {

    }
    /**
     * Handle the Appointment "created" event.
     */
    public function created(Appointment $appointment): void
    {
        if($appointment->agent)
        {
            $appointment->agent->notify(
                new AppointmentAssignedNotification($appointment, 'created')
            );
        }


        $this->leadService->updateLeadStatus(
            $appointment->lead,
            match ($appointment->appointment_type) {
                'follow-up' => 'follow-up',
                'tripping'  => 'for-tripping',
                'reservations'  => 'for-reservation',
                default     => null,
            }
        );
    }

    /**
     * Handle the Appointment "updated" event.
     */
    public function updated(Appointment $appointment): void
    {
        if($appointment->wasChanged('assigned_agent'))
        {
            $newAgent = $appointment->agent;

            if($newAgent)
            {
                $newAgent->notify(
                    new AppointmentAssignedNotification($appointment, 'assigned')
                );
            }
        }

        if($appointment->wasChanged('appointment_type'))
        {
            $this->leadService->updateLeadStatus(
                $appointment->lead,
                match ($appointment->appointment_type) {
                    'follow-up' => 'follow-up',
                    'tripping'  => 'for-tripping',
                    'reservations'  => 'for-reservation',
                    default     => null,
                }
            );
        }
    }

    /**
     * Handle the Appointment "deleted" event.
     */
    public function deleted(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "restored" event.
     */
    public function restored(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "force deleted" event.
     */
    public function forceDeleted(Appointment $appointment): void
    {
        //
    }
}
