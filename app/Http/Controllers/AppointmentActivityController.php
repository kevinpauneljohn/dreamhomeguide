<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentActivity;
use Illuminate\Http\Request;

class AppointmentActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'accomplishment' => ['required', 'string', 'max:3000'],
        ]);

        $request->merge(['user_id' => auth()->id(), 'status' => 'completed']);

        $appointment = Appointment::findOrFail($request->appointment_id);

        if($appointment->status === 'completed')
        {
            return response()->json(['success' => false, 'message' => 'Appointment was already completed'], 400);
        }

        $appointmentActivity = AppointmentActivity::create($request->only('accomplishment','appointment_id','user_id','status'));
        if($appointmentActivity->exists())
        {

            $appointment->status = 'completed';
            $appointment->save();
            return response()->json(['success' => true, 'message' => 'Appointment Completed'], 201);
        }
        return response()->json(['success' => false, 'message' => 'An error occurred'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(AppointmentActivity $appointmentActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppointmentActivity $appointmentActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AppointmentActivity $appointmentActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppointmentActivity $appointmentActivity)
    {
        //
    }

    public function getAppointmentActivities(Appointment $appointment)
    {
        return view('dashboard.pages.appointmentActivities.activity')->with([
            'appointment' => $appointment,
        ]);
    }
}
