<?php

namespace App\Services;

use App\Models\Commission;
use Yajra\DataTables\Facades\DataTables;

class CommissionService
{
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
