<?php

namespace App\Services;

use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SalesService
{
    public function createSales(array $salesData): \Illuminate\Http\JsonResponse
    {
        $sales = Sales::create($salesData);
        return $sales ?
            response()->json(['success' => true, 'message' => 'Sales created successfully!',
                'sales' => $sales->id, 'project_id' => $sales->modelUnit->project->id], 201, []) :
            response()->json(['success' => false, 'message' => 'Something went wrong!'], 500);
    }

    public function updateSales($sales, array $salesData): \Illuminate\Http\JsonResponse
    {
        $sales = Sales::findOrFail($sales);

        $sales->fill($salesData);

        if ($sales->isDirty()) {
            $sales->save();

            return response()->json(['success' => true, 'message' => 'Sales updated successfully!', 'sales' => $sales->id], 200);
        }

        return response()->json(['success' => false, 'message' => 'No changes were made.']);
    }

    public function getQuery(array $request)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        | - Agents see only their own sales
        | - Manager / Super Admin see all
        |--------------------------------------------------------------------------
        */
        $query = Sales::query()
            ->with(['lead', 'project', 'agent'])
            ->when(
                ! $user->hasAnyRole(['manager', 'super admin']),
                fn ($q) => $q->where('user_id', $user->id)
            );

        /*
        |--------------------------------------------------------------------------
        | SEARCH (Lead Name, Phone, Sale ID)
        |--------------------------------------------------------------------------
        */
        $search = $request['search']['value']
            ?? $request['search']
            ?? null;

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {

                $q->whereHas('lead', function ($lead) use ($search) {
                    $lead->whereRaw(
                        "CONCAT(first_name,' ',last_name) LIKE ?",
                        ["%{$search}%"]
                    )
                        ->orWhere('phone', 'like', "%{$search}%");
                });

                // Search by numeric Sale ID
                if (preg_match('/\d+/', $search, $m)) {
                    $q->orWhere('id', (int) $m[0]);
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | PROJECT FILTER
        |--------------------------------------------------------------------------
        */
        if (! empty($request['project_id'])) {
            $query->where('project_id', $request['project_id']);
        }

        /*
        |--------------------------------------------------------------------------
        | AGENT FILTER
        |--------------------------------------------------------------------------
        */
        if (! empty($request['agent_id'])) {
            $query->where('user_id', $request['agent_id']);
        }

        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */
        if (! empty($request['status'])) {
            $query->where('status', $request['status']);
        }

        /*
        |--------------------------------------------------------------------------
        | DATE CREATED FILTER
        |--------------------------------------------------------------------------
        */
        if (! empty($request['date_created'])) {
            $query->whereDate(
                'created_at',
                Carbon::parse($request['date_created'])->toDateString()
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        */
        if (! empty($request['sort']) && $request['sort'] === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderByDesc('created_at');
        }

        return $query;
    }

    /**
     * DataTables response
     */
    public function getSales($request): \Illuminate\Http\JsonResponse
    {
        $query = $this->getQuery($request);

        return DataTables::of($query)

            /* -----------------------------------------
             | CLIENT (LEAD)
             ----------------------------------------- */
            ->addColumn('client', function ($sale) {
                return [
                    'name'  => trim($sale->lead->first_name.' '.$sale->lead->last_name),
                    'phone' => $sale->lead->phone,
                ];
            })

            /* -----------------------------------------
             | PROJECT
             ----------------------------------------- */
            ->addColumn('project', fn ($sale) =>
            $sale->project?->name
            )

            /* -----------------------------------------
             | AMOUNT
             ----------------------------------------- */
            ->addColumn('amount', fn ($sale) =>
            $sale->total_contract_price
            )

            /* -----------------------------------------
             | AGENT
             ----------------------------------------- */
            ->addColumn('agent', function ($sale) {
                return [
                    'name' => trim(
                        $sale->agent->first_name.' '.$sale->agent->last_name
                    ),
                    'initials' => strtoupper(
                        substr($sale->agent->first_name, 0, 1) .
                        substr($sale->agent->last_name, 0, 1)
                    ),
                    'role' => $sale->agent->getRoleNames()->first(),
                ];
            })

            /* -----------------------------------------
             | STATUS
             ----------------------------------------- */
            ->addColumn('status', fn ($sale) => $sale->status)

            /* -----------------------------------------
             | DATE
             ----------------------------------------- */
            ->addColumn('date', fn ($sale) =>
                $sale->reservation_date
            )

            /* -----------------------------------------
             | ACTIONS
             ----------------------------------------- */
            ->addColumn('action', function ($sale) {
                return [
                    'view'   => auth()->user()->can('view sale'),
                    'edit'   => auth()->user()->can('edit sale') && $sale->status !== 'completed',
                    'delete' => auth()->user()->can('delete sale') && $sale->status !== 'completed',
                    'id'     => $sale->id,
                    'client' => $sale->lead->full_name,
                    'project' => $sale->project->name,
                    'tcp' => $sale->total_contract_price,
                    'assigned_agent' => $sale->agent->full_name,
                ];
            })

            ->make(true);
    }

    public function getCurrentMonthSales()
    {
        $now = Carbon::now();
        $user = auth()->user();

        $query = Sales::whereMonth('reservation_date', $now->month)
            ->whereYear('reservation_date', $now->year)
            ->where('status', 'completed')
            ->orWhere('status', 'reserved');

        // 🔐 ROLE-BASED VISIBILITY
        if ($user->hasRole(['agent'])) {
            $query->where('user_id', $user->id);
        }

        return $query->sum('total_contract_price');
    }

    public function getAgentRanking(): \Illuminate\Database\Eloquent\Collection|array|\LaravelIdea\Helper\App\Models\_IH_Sales_C
    {
        $now = Carbon::now();
        return Sales::select(
                'user_id',
                DB::raw('COUNT(id) as units_sold'),
                DB::raw('SUM(total_contract_price) as total_amount')
            )
            ->whereMonth('reservation_date', $now->month)
                ->whereYear('reservation_date', $now->year)
            ->where('status', 'completed')
            ->orWhere('status', 'reserved')
                ->with([
                    'agent' => function ($q) {
                        $q->select('id', 'first_name', 'last_name', 'profile_photo')
                            ->with('roles:id,name');
                    }
                ])
                ->groupBy('user_id')
                ->orderByDesc('total_amount')
                ->get();
    }
}
