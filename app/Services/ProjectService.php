<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ProjectService
{

    public function getQuery(array $request): \Illuminate\Database\Eloquent\Builder
    {

        $query = Project::query();

        /* -----------------------------------------
         | SEARCH (Task #, Title, Description)
         ----------------------------------------- */
        $search = $request['search']['value']
            ?? $request['search']
            ?? null;

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        return $query;
    }
    public function getProjects($request): \Illuminate\Http\JsonResponse
    {
        $query = $this->getQuery($request);
        return DataTables::of($query)
            ->addColumn('action', content: function ($project) {
                return [
                    'view' => (bool)auth()->user()->can('view project'),
                    'edit' => (bool)auth()->user()->can('edit project'),
                    'delete' => (bool)auth()->user()->can('delete project'),
                    'id' => $project->id,
                    'name' => ucwords(strtolower($project->name)),
                    'address' => ucwords(strtolower($project->address)),
                ];
            })
            ->make(true);
    }
}
