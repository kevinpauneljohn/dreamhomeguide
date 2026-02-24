<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Leads;
use App\Models\User;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            new Middleware('can:view appointment', only: ['index', 'show','getAppointments','getUserAppointments']),
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
        return view('dashboard.pages.appointments.index')->with([
            'title' => 'My Appointments',
            'appointmentTypes' => $this->appointmentService->appointmentTypes(),
            'agents'           => User::all(),
            'leads'            => auth()->user()->hasRole(['super admin','manager']) ? Leads::all() : Leads::where('user_id',auth()->id())->get(),
        ]);
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
        $request->merge(['user_id' => auth()->id()]);
        return $this->appointmentService->saveAppointment($request->only('title','appointment_date','location','notes','lead_id','user_id','appointment_type_id','status','appointment_type','assigned_agent'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        if($appointment->user_id == auth()->id() || $appointment->assigned_agent == auth()->id() || auth()->user()->hasRole(['super admin','manager']))
        {
            return view('dashboard.pages.appointments.show')->with([
                'appointment' => $appointment,
            ]);
        }
        abort(403);
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
    public function update(UpdateAppointmentRequest $request, Appointment $appointment): \Illuminate\Http\JsonResponse
    {
        if($appointment->user_id != auth()->id() || !auth()->user()->hasRole(['super admin','manager']))
        {
            return response()->json(['success' => false, 'message' => 'You are not authorized to update this appointment.'],401);
        }
        return $this->appointmentService->updateAppointment($appointment,
            $request->only('title','appointment_date','location','notes','lead_id','user_id','appointment_type_id','status','appointment_type','assigned_agent'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment): \Illuminate\Http\JsonResponse
    {
        return $appointment->delete() ?
            response()->json(['success' => true, 'message' => 'Appointment deleted successfully.']) :
            response()->json(['success' => false, 'message' => 'An error occurred while deleting the appointment.']);
    }

    public function getAppointments(): \Illuminate\Support\Collection
    {
        return $this->appointmentService->appointments_in_calendar_format(true);
    }

    public function getUserAppointments(string $userId): \Illuminate\Support\Collection
    {
        return $this->appointmentService->appointments_in_calendar_format($userId);
    }

    public function getAppointmentStatus(Appointment $appointment)
    {
        return [
            'status' => $appointment->status,
            'appointment_date' => $appointment->appointment_date
        ];
    }

    public function reScheduleAppointment(Appointment $appointment, Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'appointment_date' => ['required', 'date','after_or_equal:today'],
        ]);
        $appointment->update(['appointment_date' => $request->appointment_date]);
        if($appointment->wasChanged('appointment_date'))
        {
            return response()->json(['success' => true, 'message' => 'Appointment rescheduled successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'No changes were made.']);
    }

    public function stats()
    {
        $userId = auth()->id();
        $now = Carbon::now();

        return response()->json([
            'today' => Appointment::whereDate('appointment_date', Carbon::today())
                ->where('assigned_agent', $userId)
                ->where('status', '!=', 'completed')
                ->count(),

            'upcoming' => Appointment::whereBetween('appointment_date', [
                Carbon::tomorrow(),
                Carbon::today()->addDays(7)->endOfDay()
            ])
                ->where('assigned_agent', $userId)
                ->where('status', '!=', 'completed')
                ->count(),

            'pending' => Appointment::where('status', 'pending')
                ->where('assigned_agent', $userId)
                ->where('status', '!=', 'completed')
                ->count(),

            'overdue' => Appointment::where('status', 'pending')
                ->where('appointment_date', '<', $now)
                ->where('assigned_agent', $userId)
                ->where('status', '!=', 'completed')
                ->count(),
        ]);
    }
}
