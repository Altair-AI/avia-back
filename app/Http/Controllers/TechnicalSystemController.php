<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\TechnicalSystem;
use App\Http\Requests\TechnicalSystem\StoreTechnicalSystemRequest;
use App\Http\Requests\TechnicalSystem\UpdateTechnicalSystemRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class TechnicalSystemController extends Controller
{
    /**
     * Create a new TechnicalSystemController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(TechnicalSystem::class, 'technical_system');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $technical_systems = [];
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE)
            foreach (TechnicalSystem::where('parent_technical_system_id', null)->get() as $tech_sys)
                array_push($technical_systems, array_merge($tech_sys->toArray(), [
                    'documents' => $tech_sys->documents,
                    'grandchildren_technical_systems' => $tech_sys->grandchildren_technical_systems
                ]));
        if (auth()->user()->role == User::ADMIN_ROLE)
            foreach (Organization::find(auth()->user()->organization->id)->projects as $project)
                array_push($technical_systems, array_merge($project->technical_system->toArray(), [
                    'documents' => $project->technical_system->documents,
                    'grandchildren_technical_systems' => $project->technical_system->grandchildren_technical_systems
                ]));
        return response()->json($technical_systems);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTechnicalSystemRequest $request
     * @return JsonResponse
     */
    public function store(StoreTechnicalSystemRequest $request)
    {
        $validated = $request->validated();
        $technical_system = TechnicalSystem::create($validated);
        return response()->json($technical_system);
    }

    /**
     * Display the specified resource.
     *
     * @param TechnicalSystem $technical_system
     * @return JsonResponse
     */
    public function show(TechnicalSystem $technical_system)
    {
        return response()->json(array_merge($technical_system->toArray(), [
            'documents' => $technical_system->documents,
            'grandchildren_technical_systems' => $technical_system->grandchildren_technical_systems
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTechnicalSystemRequest $request
     * @param TechnicalSystem $technical_system
     * @return JsonResponse|null
     */
    public function update(UpdateTechnicalSystemRequest $request, TechnicalSystem $technical_system)
    {
        $validated = $request->validated();
        $technical_system->fill($validated);
        $technical_system->save();
        return response()->json($technical_system);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TechnicalSystem $technical_system
     * @return JsonResponse|null
     */
    public function destroy(TechnicalSystem $technical_system)
    {
        $technical_system->delete();
        return response()->json(['id' => $technical_system->id], 200);
    }
}
