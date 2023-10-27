<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Project;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    /**
     * Create a new ProjectController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $projects = [];
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE)
            $projects = Project::with('technical_system')->with('rule_based_knowledge_bases')->get();
        if (auth()->user()->role == User::ADMIN_ROLE)
            foreach (Organization::find(auth()->user()->organization->id)->projects as $project)
                array_push($projects, array_merge($project->toArray(), [
                    'technical_system' => $project->technical_system,
                    'rule_based_knowledge_bases' => $project->rule_based_knowledge_bases
                ]));
        return response()->json($projects);
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
        return response()->json(array_merge($project->toArray(), ['technical_system' => $project->technical_system]));
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function show(Project $project)
    {
        return response()->json(array_merge($project->toArray(), [
            'technical_system' => $project->technical_system,
            'rule_based_knowledge_bases' => $project->rule_based_knowledge_bases
        ]));
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
        return response()->json(array_merge($project->toArray(), ['technical_system' => $project->technical_system]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return JsonResponse|null
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(['id' => $project->id], 200);
    }
}
