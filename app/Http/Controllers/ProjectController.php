<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE) {
            $projects = Project::all();
            if ($projects)
                return response()->json($projects->toArray());
        }
        if (auth()->user()->role == User::ADMIN_ROLE) {
            $projects = [];
            foreach (Organization::find(auth()->user()->organization->id)->licenses as $license)
                array_push($projects, $license->project->toArray());
            if ($projects)
                return response()->json($projects);
        }
        return response()->json('No projects found.', 400);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectRequest $request
     * @return JsonResponse
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();
        $project = Project::create($validated);
        return response()->json($project->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function show(Project $project)
    {
        return response()->json($project->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectRequest $request
     * @param Project $project
     * @return JsonResponse
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();
        $project->fill($validated);
        $project->save();
        return response()->json($project->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return JsonResponse|null
     */
    public function destroy(Project $project)
    {
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE) {
            $project->delete();
            return response()->json('Project was successfully deleted.', 200);
        }
        return null;
    }
}
