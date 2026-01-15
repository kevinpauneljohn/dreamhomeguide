<?php

namespace App\Services;

use App\Models\Computation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ComputationService
{
    /**
     * Base query builder for Computations (filters + search)
     */
    protected function computationQuery(array $request): \Illuminate\Database\Eloquent\Builder
    {
        $query = Computation::query()
            ->with(['project', 'modelUnit', 'user'])
            ->whereNull('deleted_at');

        /**
         * 🔍 Global search
         */
        if (!empty($request['search'])) {
            $search = $request['search'];

            $query->where(function ($q) use ($search) {
                $q->where('computation', 'like', "%{$search}%")
                    ->orWhere('financing', 'like', "%{$search}%")
                    ->orWhereHas('project', function ($p) use ($search) {
                        $p->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('modelUnit', function ($m) use ($search) {
                        $m->where('name', 'like', "%{$search}%");
                    });
            });
        }

        /**
         * 🏗 Filter by Project
         */
        if (!empty($request['project_id'])) {
            $query->where('project_id', $request['project_id']);
        }

        /**
         * 🏠 Filter by Model Unit
         */
        if (!empty($request['model_unit_id'])) {
            $query->where('model_unit_id', $request['model_unit_id']);
        }

        /**
         * 💰 Filter by Financing
         */
        if (!empty($request['financing'])) {
            $query->where('financing', $request['financing']);
        }

        /**
         * ✅ Approved / Draft filter
         */
        if (isset($request['approved']) && $request['approved'] !== '') {
            $query->where('is_approved', (int) $request['approved']);
        }

        /**
         * 🗓 Date range filter
         */
        if (!empty($request['date_from'])) {
            $query->whereDate('created_at', '>=', $request['date_from']);
        }

        if (!empty($request['date_to'])) {
            $query->whereDate('created_at', '<=', $request['date_to']);
        }

        return $query->latest();
    }

    /**
     * DataTables response
     */
    public function getComputations($request): \Illuminate\Http\JsonResponse
    {
        $query = $this->computationQuery($request->all());

        return DataTables::of($query)

            ->addColumn('project', function (Computation $row) {
                return $row->project->name ?? '—';
            })

            ->addColumn('model_unit', function (Computation $row) {
                return $row->modelUnit->name ?? '—';
            })

            ->addColumn('updated_by', function (Computation $row) {
                return $row->user->full_name ?? '—';
            })

            ->addColumn('action', content: function ($computation) {
                return [
                    'view' => (bool)auth()->user()->can('view computation'),
                    'edit' => (bool)auth()->user()->can('edit computation'),
                    'delete' => (bool)auth()->user()->can('delete computation'),
                    'id' => $computation->id,
                    'name' => ucwords(strtolower($computation->name)),
                ];
            })

            ->make(true);
    }
}
