<?php

namespace App\Services;

use App\Models\Appointment;

class AppointmentService
{
    public function saveAppointment(array $appointmentData): \Illuminate\Http\JsonResponse
    {
        return Appointment::create($appointmentData) ?
            response()->json(['success' => true, 'message' => 'Appointment saved successfully.']) :
            response()->json(['success' => false, 'message' => 'An error occurred while saving your appointment.']);
    }
}
