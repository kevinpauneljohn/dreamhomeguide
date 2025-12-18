<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Leads;
use App\Models\User;

class AppointmentService
{
    public function appointmentTypes(): array
    {
        return [
            'tripping' => [
                'label' => 'Tripping',
                'color' => '#0d6efd',          // Blue
                'class' => 'bg-primary'
            ],
            'follow-up' => [
                'label' => 'Follow Up',
                'color' => '#ffc107',          // Yellow
                'class' => 'bg-warning'
            ],
            'assistance' => [
                'label' => 'Assistance',
                'color' => '#198754',          // Green
                'class' => 'bg-success'
            ],
            'reservations' => [
                'label' => 'Reservations',
                'color' => '#dc3545',          // Red
                'class' => 'bg-danger'
            ],
            'send-update' => [
                'label' => 'Send Update',
                'color' => '#6f42c1',          // Purple
                'class' => 'bg-purple'
            ],
        ];

    }

    public function findAppointmentType($type): array
    {
        foreach ($this->appointmentTypes() as $key => $item) {
            if (strcasecmp($key, $type) == 0) {
                return $item;
            }
        }
        return [];
    }

    public function saveAppointment(array $appointmentData): \Illuminate\Http\JsonResponse
    {
        return Appointment::create($appointmentData) ?
            response()->json(['success' => true, 'message' => 'Appointment saved successfully.']) :
            response()->json(['success' => false, 'message' => 'An error occurred while saving your appointment.']);
    }

    public function updateAppointment(Appointment $appointment, array $appointmentData): \Illuminate\Http\JsonResponse
    {
        if($appointment->fill($appointmentData)->isDirty())
        {
            return $appointment->save() ? response()->json(['success' => true, 'message' => 'Appointment updated successfully.']) :
                response()->json(['success' => false, 'message' => 'An error occurred while updating your appointment.']);
        }
        return response()->json(['success' => false, 'message' => 'No changes were made.']);

    }

    public function appointments_in_calendar_format(): \Illuminate\Support\Collection
    {
        return collect(Appointment::all())->mapWithKeys(function ($item, $key){
            return [
                $key => [
                    'id' => $item->id,
                    'title' => ucwords($item->title),
                    'start' => $item->appointment_date,
                    'allDay' => false,
                    'color' => $this->findAppointmentType($item->appointment_type)['color'],
                    'appointment_type' => $item->appointment_type,
                    'assigned_agent' => $item->user_id ? User::find($item->user_id)->full_name : 'Unassigned',
                    'agent_id' => $item->user_id,
                    'client' => Leads::find($item->lead_id)->full_name,
                    'location' => $item->location,
                    'notes' => $item->notes,
                    'lead_id' => $item->lead_id,
//                    'url' => route('leads.show', ['lead' => $item->lead_id]),
                ]
            ];
        });
    }
}
