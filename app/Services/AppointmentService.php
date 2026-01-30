<?php

namespace App\Services;

use App\Mail\SendAppointmentNotification;
use App\Models\Appointment;
use App\Models\Leads;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

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
        // Normalize and validate date
        $appointmentDate = Carbon::parse($appointmentData['appointment_date']);

        if ($appointmentDate->lt(Carbon::now()->startOfDay())) {
            return response()->json([
                'success' => false,
                'message' => 'Appointments cannot be set in the past.'
            ], 422);
        }

        if($appointment = Appointment::create($appointmentData))
        {
            return response()->json(['success' => true, 'message' => 'Appointment saved successfully.',
                'type' => $appointment->appointment_type, 'appointment_id' => $appointment->id]);
        }
        return response()->json(['success' => false, 'message' => 'An error occurred while saving your appointment.']);
    }

    public function updateAppointment(Appointment $appointment, array $appointmentData): \Illuminate\Http\JsonResponse
    {
        // Normalize and validate date
        $appointmentDate = Carbon::parse($appointmentData['appointment_date']);

        if ($appointmentDate->lt(Carbon::now()->startOfDay())) {
            return response()->json([
                'success' => false,
                'message' => 'Appointments cannot be set in the past.'
            ], 422);
        }

        if($appointment->fill($appointmentData)->isDirty())
        {
            if($appointment->save())
            {
                return response()->json(['success' => true, 'message' => 'Appointment updated successfully.', 'type' => $appointment->appointment_type]);
            }
             return response()->json(['success' => false, 'message' => 'An error occurred while updating your appointment.']);

        }
        return response()->json(['success' => false, 'message' => 'No changes were made.']);

    }

    public function appointments_in_calendar_format(bool|string $display_all_appointments_or_get_user_id): \Illuminate\Support\Collection
    {
        if($display_all_appointments_or_get_user_id === true)
        {
            $appointments = Appointment::all();
        }else{
            $appointments = Appointment::where('assigned_agent',auth()->id())->get();
//                ->orWhere('assigned_agent',auth()->id())->get();
        }

        return collect($appointments)->mapWithKeys(function ($item, $key){
            // 🎨 Background color logic
            $bgColor = '';

            if ($item->status === 'completed') {
                // Yellow-green for completed appointments
                $bgColor = '#b7e4c7';
            } elseif ($item->assigned_agent === auth()->id()) {
                // Yellow for appointments assigned to current user
                $bgColor = '#f6e388';
            }

            return [
                $key => [
                    'id' => $item->id,
                    'title' => ucwords($item->title),
                    'start' => $item->appointment_date,
                    'allDay' => false,
                    'color' => $this->findAppointmentType($item->appointment_type)['color'],
                    'appointment_type' => $item->appointment_type,
                    'assigned_agent' => $item->user_id ? User::find($item->assigned_agent)->full_name : 'Unassigned',
                    'agent_id' => $item->assigned_agent,
                    'client' => optional(Leads::find($item->lead_id))->full_name ?? 'No Client',
                    'location' => $item->location,
                    'notes' => $item->notes,
                    'lead_id' => $item->lead_id,
                    'bgColor' => $bgColor,
                    'showEditButton' => $item->user_id == auth()->id(),
                    'showCloseButton' => $item->user_id == auth()->id(),
                    'showViewButton' => true,
//                    'url' => route('leads.show', ['lead' => $item->lead_id]),
                ]
            ];
        });
    }
}
