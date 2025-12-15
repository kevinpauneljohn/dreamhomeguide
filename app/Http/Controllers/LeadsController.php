<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Http\Requests\StoreLeadsRequest;
use App\Http\Requests\UpdateLeadsRequest;
use App\Models\User;
use App\Services\LeadService;
use App\Services\NoteService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;

class LeadsController extends Controller
{
    public function __construct(
        protected LeadService $leadsService
    )
    {

    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:view lead', only: ['index', 'show','getLeads']),
            new Middleware('can:add lead', only: ['create', 'store']),
            new Middleware('can:edit lead', only: ['edit', 'update']),
            new Middleware('can:delete lead', only: ['destroy'])
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
        return view('dashboard.pages.leads.create')->with([
            'title' => 'Add new lead',
            'agents' => User::all(),
            'leadStatus' => $this->leadsService->leadStatus(),
            'incomeRange' => $this->leadsService->incomeRange(),
            'sources' => $this->leadsService->leadSources(),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeadsRequest $request)
    {
        $lead = $this->leadsService->saveLead($request->only('first_name', 'last_name', 'email', 'phone','address','source',
            'source_url','status','user_id','birthday','civil_status','income_range','gender','lead_type'));

        return response()->json(['success' => true, 'message' => 'Lead created successfully.', 'lead_id' => $lead->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, NoteService $noteService)
    {
        $lead = Leads::findOrFail($id);
        return view('dashboard.pages.leads.show')->with([
            'title' => 'View Lead',
            'lead' => $lead,
            'genderPhoto' => $this->leadsService->genderPhoto($lead->gender),
            'noteTypes' => $noteService->noteTypes(),
            'agents' => User::all(),
            'leadStatus' => $this->leadsService->leadStatus(),
            'incomeRange' => $this->leadsService->incomeRange(),
            'sources' => $this->leadsService->leadSources(),
            'leadTypes' => $this->leadsService->leadTypes(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leads $leads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeadsRequest $request, Leads $leads)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leads $leads)
    {
        //
    }

    public function getLeads(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->leadsService->getLeads($request->all());
    }

    public function updateField(Request $request, Leads $lead): \Illuminate\Http\JsonResponse
    {
        $field = array_key_first($request->all());

        $validated = $request->validate([
            $field => $this->leadsService->validationRules($lead->id)[$field]
        ],['user_id.required' => 'Please select an agent.']);
        $lead->fill($validated);

        if ($lead->isDirty()) {
            $lead->save();
            return response()->json(['success' => true, 'message' => ucfirst($field == 'user_id' ? 'Agent' : $field) . ' updated successfully.',
                'field' => $field,'agent' => $lead->user->full_name]);
        }

        return response()->json(['success' => false, 'message' => 'No changes were made.']);
    }
}
