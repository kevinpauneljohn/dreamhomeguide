<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeadsRequest;
use App\Models\Leads;
use App\Services\LeadService;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    public function __construct(
        protected LeadService $leadsService
    )
    {

    }

    public function index()
    {
        return Leads::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeadsRequest $request)
    {
        $lead = $this->leadsService->saveLead($request->only(
            'first_name', 'last_name', 'email', 'phone', 'address', 'source',
            'source_url', 'status', 'user_id', 'birthday', 'civil_status',
            'income_range', 'gender', 'lead_type'
        ));

        return response()->json([
            'success' => true,
            'message' => 'Lead created successfully.',
            'leads' => $lead
        ]);
    }
}
