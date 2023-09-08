<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * Get all projects.
     *
     * @return JsonResponse
     */
    public function getAllProjects() {
        $projects = Project::all();
        if ($projects)
            return response()->json($projects->toArray());
        return response()->json('No projects found.', 400);
    }

    /**
     * Get all projects available to an authorized user.
     *
     * @return JsonResponse
     */
    public function getProjects() {
        $projects = [];
        foreach (Organization::find(auth()->user()->organization->id)->licenses as $license)
            array_push($projects, $license->project->toArray());
        if ($projects)
            return response()->json($projects);
        return response()->json('No projects found.', 400);
    }

    /**
     * Get project by id.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function getProject(int $id) {
        $project = Project::find($id);
        if ($project)
            return response()->json($project->toArray());
        return response()->json('Project with this id was not found.', 400);
    }
}
