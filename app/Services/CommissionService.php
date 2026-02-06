<?php

namespace App\Services;

use App\Models\Commission;
use Yajra\DataTables\Facades\DataTables;

class CommissionService
{

    public function getCommissionRate($project_id, $user_id): ?float
    {
        $commission = Commission::where('project_id', $project_id)
            ->where('user_id', $user_id)
            ->value('rate');

        if(is_null($commission))
        {
            return Commission::where('project_id', null)
                ->where('user_id', $user_id)
                ->value('rate');
        }else{
            return $commission;
        }
    }


    public function commissionTable(string $userId)
    {
        $query = Commission::query()
            ->with('project')
            ->where('user_id', $userId)
            ->latest();

        return DataTables::of($query)
            ->addColumn('date_assigned', function ($commission) {
                return [
                    'date' => $commission->created_at->format('M d, Y'),
                    'time' => $commission->created_at->format('h:i A'),
                ];
            })
            ->addColumn('rate', function ($commission) {
                return $commission->rate;
            })
            ->addColumn('project', function ($commission) {
                return $commission->project?->name ?? 'All Projects';
            })
            ->addColumn('action', function ($commission) {
                return [
                    'id' => $commission->id,
                    'edit' => true,
                    'delete' => true,
                ];
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
