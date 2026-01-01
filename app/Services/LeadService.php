<?php

namespace App\Services;

use App\Models\Leads;
use App\Models\ListPropertyInformation;
use App\Models\User;
use App\Notifications\OrganicLeadCreated;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

            'new' => [
                'label' => 'New',
                'color' => '#6c757d',
                'class' => 'bg-primary'
            ],

            'hot' => [
                'label' => 'Hot',
                'color' => '#dc3545',
                'class' => 'bg-danger'
            ],

            'cold' => [
                'label' => 'Cold',
                'color' => '#0d6efd',
                'class' => 'bg-info'
            ],

            'warm' => [
                'label' => 'Warm',
                'color' => '#fd7e14',
                'class' => 'bg-warning'
            ],

            're-engaging' => [
                'label' => 'Re-Engaging',
                'color' => '#20c997',
                'class' => 'bg-teal'
            ],

            'contacted' => [
                'label' => 'Contacted',
                'color' => '#0dcaf0',
                'class' => 'bg-info'
            ],

            'follow-up' => [
                'label' => 'Follow-Up',
                'color' => '#ffc107',
                'class' => 'bg-warning'
            ],

            'qualified' => [
                'label' => 'Qualified',
                'color' => '#198754',
                'class' => 'bg-success'
            ],

            'for-tripping' => [
                'label' => 'Scheduled For Tripping / Viewing',
                'color' => '#6610f2',
                'class' => 'bg-purple'
            ],

            'tripping-done' => [
                'label' => 'Tripping Done',
                'color' => '#6f42c1',
                'class' => 'bg-purple'
            ],
            'for-reservation' => [
                'label' => 'For Reservation',
                'color' => '#0d6efd',
                'class' => 'bg-primary'
            ],
            'reserved' => [
                'label' => 'Reserved',
                'color' => '#0d6efd',
                'class' => 'bg-primary'
            ],

            'for-documentation' => [
                'label' => 'For Documentation',
                'color' => '#0dcaf0',
                'class' => 'bg-info'
            ],

            'for-loan-processing' => [
                'label' => 'For Loan Processing',
                'color' => '#ffc107',
                'class' => 'bg-warning'
            ],

            'loan-approved' => [
                'label' => 'Loan Approved',
                'color' => '#198754',
                'class' => 'bg-success'
            ],

            'not-qualified' => [
                'label' => 'Not Qualified',
                'color' => '#6c757d',
                'class' => 'bg-secondary'
            ],

            'not-interested' => [
                'label' => 'Not Interested',
                'color' => '#adb5bd',
                'class' => 'bg-light text-dark'
            ],

            'closed' => [
                'label' => 'Closed / Sold',
                'color' => '#198754',
                'class' => 'bg-success'
            ],

            'lost' => [
                'label' => 'Lost',
                'color' => '#343a40',
                'class' => 'bg-dark'
            ],
        ];
    }

    public function findStatus(?string $status): ?array
    {
        return $status && isset($this->leadStatus()[$status])
            ? $this->leadStatus()[$status]
            : null;
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

    public function leadTypes(): array
    {
        return [
            'buyer' => 'Buyer',
            'seller' => 'Seller',
            'buyer-and-seller' => 'Buyer & Seller'
        ];
    }

    public function saveLead(array $data)
    {
        return Leads::create($data);
    }

    public function sellerLeadPropertyInformation($lead_type, array $propertyInformation): void
    {
        if($lead_type == 'seller')
        {
           ListPropertyInformation::create($propertyInformation);
        }
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
                    'email' => $this->allowed_to_view_lead_details($lead) ? $lead->email : $this->maskDetails($lead->email, 5),
                    'id' => $lead->id,
                ];
            })
            ->editColumn('status', content: function ($lead) {
                return $this->findStatus($lead->status);
            })
            ->editColumn('created_at', content: function ($lead) {
                return $lead->created_at->format('m-d-Y h:i a');
            })
            ->editColumn('user_id', content: function ($lead) {
                return $lead->user->full_name ?? 'N/A';
            })
            ->editColumn('phone', content: function ($lead) {
                return $this->allowed_to_view_lead_details($lead) ? $lead->phone : $this->maskDetails($lead->phone);
            })
            ->addColumn('action', content: function ($lead) {
                return [
                    'view' => (bool)auth()->user()->can('view lead'),
                    'edit' => (bool)auth()->user()->can('edit lead'),
                    'delete' => auth()->user()->can('delete lead') && $lead->user_id == auth()->id()
                        || auth()->user()->hasRole(['super admin','manager']),
                    'id' => $lead->id
                ];
            })
            ->make(true);
    }

    public function validationRules(string $lead_id): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('leads', 'email')->ignore($lead_id)],
            'phone' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'gender' => ['nullable', 'string'],
            'income_range' => ['nullable', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'birthday' => [
                'nullable',
                'date',
                'after_or_equal:1900-01-01',
                'before_or_equal:2100-12-31'
            ],
            'civil_status' => ['nullable', 'string'],
            'source' => ['required', 'string'],
            'lead_type' => ['required', 'string'],
        ];
    }

    public function notify_users_when_lead_created(array $roles, Leads $lead): void
    {
        User::role($roles)
            ->each(function ($user) use ($lead) {
                $user->notify(new OrganicLeadCreated($lead));
            });
    }

    public function updateLeadStatus(Leads $lead, string|null $status): void
    {
        if(!is_null($status))
        $lead->update(['status' => $status]);
    }

    private function allowed_to_view_lead_details(Leads $lead): bool
    {
        return !is_null($lead->user_id) && $lead->user_id == auth()->id()
            || auth()->user()->hasRole(['super admin','manager']);
    }

    private function maskDetails($phone, $visible = 4): string
    {
        return substr($phone, 0, $visible) . str_repeat('*', max(0, strlen($phone) - $visible));
    }

}
