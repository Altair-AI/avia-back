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
     *
     * @OA\Get(
     *     path="/api/v1/admin/projects",
     *     summary="Получить список всех проектов",
     *     tags={"Проекты"},
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Some name"),
     *             @OA\Property(property="description", type="string", example="Some description"),
     *             @OA\Property(property="type", type="integer", example=0),
     *             @OA\Property(property="status", type="integer", example=0),
     *             @OA\Property(property="technical_system_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
     *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
     *         ))
     *     )
     * )
     */
    public function index()
    {
        $projects = [];
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE)
            $projects = Project::all();
        if (auth()->user()->role == User::ADMIN_ROLE)
            foreach (Organization::find(auth()->user()->organization->id)->licenses as $license)
                array_push($projects, $license->project->toArray());
        return response()->json($projects);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreProjectRequest $request
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/api/v1/admin/projects",
     *     summary="Создание нового проекта",
     *     tags={"Проекты"},
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="name", type="string", example="Some name"),
     *                     @OA\Property(property="description", type="string", example="Some description"),
     *                     @OA\Property(property="type", type="integer", example=0),
     *                     @OA\Property(property="status", type="integer", example=0),
     *                     @OA\Property(property="technical_system_id", type="integer", example=1)
     *                 )
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Some name"),
     *             @OA\Property(property="description", type="string", example="Some description"),
     *             @OA\Property(property="type", type="integer", example=0),
     *             @OA\Property(property="status", type="integer", example=0),
     *             @OA\Property(property="technical_system_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
     *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
     *         )
     *     )
     * )
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();
        $project = Project::create($validated);
        return response()->json($project);
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/api/v1/admin/projects/{project}",
     *     summary="Получить единичный проект",
     *     tags={"Проекты"},
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\Parameter(
     *         description="id проекта",
     *         in="path",
     *         name="project",
     *         required=true,
     *         example=1
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Some name"),
     *             @OA\Property(property="description", type="string", example="Some description"),
     *             @OA\Property(property="type", type="integer", example=0),
     *             @OA\Property(property="status", type="integer", example=0),
     *             @OA\Property(property="technical_system_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
     *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
     *         )
     *     )
     * )
     */
    public function show(Project $project)
    {
        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectRequest $request
     * @param Project $project
     * @return JsonResponse
     *
     * @OA\Put(
     *     path="/api/v1/admin/projects/{project}",
     *     summary="Обновить проект",
     *     tags={"Проекты"},
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\Parameter(
     *         description="id проекта",
     *         in="path",
     *         name="project",
     *         required=true,
     *         example=1
     *     ),
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="name", type="string", example="Some name for edit"),
     *                     @OA\Property(property="description", type="string", example="Some description for edit"),
     *                     @OA\Property(property="type", type="integer", example=0),
     *                     @OA\Property(property="status", type="integer", example=0),
     *                     @OA\Property(property="technical_system_id", type="integer", example=1)
     *                 )
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Some name"),
     *             @OA\Property(property="description", type="string", example="Some description"),
     *             @OA\Property(property="type", type="integer", example=0),
     *             @OA\Property(property="status", type="integer", example=0),
     *             @OA\Property(property="technical_system_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
     *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
     *         )
     *     )
     * )
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();
        $project->fill($validated);
        $project->save();
        return response()->json($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return JsonResponse|null
     *
     * @OA\Delete(
     *     path="/api/v1/admin/projects/{project}",
     *     summary="Удалить проект",
     *     tags={"Проекты"},
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\Parameter(
     *         description="id проекта",
     *         in="path",
     *         name="project",
     *         required=true,
     *         example=1
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Project was successfully deleted.")
     *         )
     *     )
     * )
     */
    public function destroy(Project $project)
    {
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE) {
            $project->delete();
            return response()->json(['message' => 'Project was successfully deleted.'], 200);
        }
        return null;
    }
}
