<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Services\AppointmentService;
use Illuminate\Routing\Controllers\Middleware;

class AppointmentController extends Controller
{
    public function __construct(
        protected AppointmentService $appointmentService
    )
    {

    }
    public static function middleware(): array
    {
        return [
            new Middleware('can:view appointment', only: ['index', 'show']),
            new Middleware('can:add appointment', only: ['create', 'store']),
            new Middleware('can:edit appointment', only: ['edit', 'update']),
            new Middleware('can:delete appointment', only: ['destroy'])
        ];
    }
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
    public function store(StoreAppointmentRequest $request)
    {
        $request->merge(['user_id' => auth()->user()->id]);
        return $this->appointmentService->saveAppointment($request->only('title','appointment_date','location','notes','lead_id','user_id'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
