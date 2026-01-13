<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class ProjectController extends Controller
{
    public function __construct(
        public ProjectService $projectService
    )
    {

    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:view task', only: ['index', 'show','getProjects']),
            new Middleware('can:add task', only: ['create', 'store']),
            new Middleware('can:edit task', only: ['edit', 'update']),
            new Middleware('can:delete task', only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pages.projects.index')->with([
            'title' => 'Projects',
            'projects' => Project::all(),
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
    public function store(StoreProjectRequest $request): \Illuminate\Http\JsonResponse
    {
        return Project::create($request->only('name','slug','description','address','status')) ?
            response()->json(['success' => true, 'message' => 'Project created successfully.'], 201) :
            response()->json(['success' => false, 'message' => 'An error occurred while creating the project.'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('dashboard.pages.projects.show')->with([
            'title' => $project->name,
            'project' => $project,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return $project;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->fill($request->only('name','slug','description','address','status'));
        if($project->isDirty())
        {
            $project->save();
            return response()->json(['success' => true, 'message' => 'Project updated successfully.', 'data' => $project->fresh()], 200);
        }
        return response()->json(['success' => false, 'message' => 'No changes were made.']);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        return $project->delete() ?
            response()->json(['success' => true, 'message' => 'Project deleted successfully.'], 200) :
            response()->json(['success' => false, 'message' => 'An error occurred while deleting the project.'], 500);
    }

    public function getProjects(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->projectService->getProjects($request->all());
    }
}
