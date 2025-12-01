<?php

namespace App\Services;

use App\Models\Leads;
use Yajra\DataTables\Facades\DataTables;

class LeadService
{
    public function leadSources(): array
    {
        return [
            'Facebook Ads', 'Facebook Page', 'Facebook Messenger', 'Website',
            'Referral', 'Tiktok', 'Instagram', 'Google Forms', 'LinkedIn', 'Walk-in', 'Other'
        ];
    }
    public function leadStatus(): array
    {
        return [
            'new' => 'New',
            'hot' => 'Hot',
            'cold' => 'Cold',
            'warm' => 'Warm',
            're-engaging' => 'Re-Engaging',
            'contacted' => 'Contacted',
            'follow-up' => 'Follow Up',
            'qualified' => 'Qualified',
            'for-tripping' => 'Scheduled For Tripping / Viewing',
            'tripping-done' => 'Tripping Done',
            'reserved' => 'Reserved',
            'for-documentation' => 'For Documentation',
            'for-loan-processing' => 'For Loan Processing',
            'loan-approved' => 'Loan Approved',
            'not-qualified' => 'Not Qualified',
            'not-interested' => 'Not Interested',
            'closed' => 'Closed / Sold',
            'lost' => 'Lost',
        ];
    }

    public function incomeRange(): array
    {
        return [
            'below-10k','10k-20k','20k-30k',
            '30k-40k','40k-50k','50k-60k',
            '60k-70k','70k-80k','80k-90k',
            '90k-100k','100k-120k','120k-150k',
            '150k-200k','200k-250k','250k-300k',
            '300k-350k','350k-400k','400k-450k',
            '450k-500k','500k+',
        ];
    }

    public function genderPhoto($gender = null): string
    {
        return match ($gender) {
            'Male' => '/storage/profile_pictures/man.png',
            'Female' => '/storage/profile_pictures/woman.png',
            default => 'https://picsum.dev/300/200',
        };
    }

    public function saveLead(array $data): \Illuminate\Http\JsonResponse
    {
        $lead = Leads::create($data);
        return $lead ? response()->json(['success' => true, 'message' => 'Lead created successfully.', 'lead_id' => $lead->id]) :
            response()->json(['success' => false, 'message' => 'Error creating lead.']);
    }

    protected function leadQuery($request): \Illuminate\Database\Eloquent\Builder
    {
        $query = Leads::query();

        if (!empty($request['search'])) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', "%{$request['search']}%")
                    ->orWhere('last_name', 'like', "%{$request['search']}%")
                    ->orWhere('email', 'like', "%{$request['search']}%")
                    ->orWhere('phone', 'like', "%{$request['search']}%");
            });
        }

        //filter by status
        if (!empty($request['status'])) {
            $query->where('status', $request['status']);
        }

        //filter by source
        if (!empty($request['source'])) {
            $query->where('source', $request['source']);
        }

        if (!empty($request['date_range'])) {
            $query->where('created_at', '>=', $request['date_range']);
        }

        return $query;
    }
    public function getLeads($request): \Illuminate\Http\JsonResponse
    {
        $query = $this->leadQuery($request);
        return DataTables::of($query)
            ->addColumn('full_name', content: function ($lead) {
                return [
                    'name' => $lead->full_name,
                    'email' => $lead->email,
                    'id' => $lead->id,
                ];
            })
            ->editColumn('created_at', content: function ($lead) {
                return $lead->created_at->format('m-d-Y h:i a');
            })
            ->editColumn('user_id', content: function ($lead) {
                return $lead->user->full_name ?? 'N/A';
            })
            ->addColumn('action', content: function ($user) {
                return [
                    'view' => (bool)auth()->user()->can('view lead'),
                    'edit' => (bool)auth()->user()->can('edit lead'),
                    'delete' => (bool)auth()->user()->can('delete lead'),
                    'id' => $user->id
                ];
            })
            ->make(true);
    }
}
