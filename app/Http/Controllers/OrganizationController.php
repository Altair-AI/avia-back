<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Http\Requests\Organization\StoreOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use Illuminate\Http\JsonResponse;

class OrganizationController extends Controller
{
    /**
     * Create a new OrganizationController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Organization::class, 'organization');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Organization::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOrganizationRequest $request
     * @return JsonResponse
     */
    public function store(StoreOrganizationRequest $request)
    {
        $validated = $request->validated();
        $technical_system = Organization::create($validated);
        return response()->json($technical_system);
    }

    /**
     * Display the specified resource.
     *
     * @param Organization $organization
     * @return JsonResponse
     */
    public function show(Organization $organization)
    {
        return response()->json($organization);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOrganizationRequest $request
     * @param Organization $organization
     * @return JsonResponse
     */
    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        $validated = $request->validated();
        $organization->fill($validated);
        $organization->save();
        return response()->json($organization);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Organization $organization
     * @return JsonResponse
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();
        return response()->json(['id' => $organization->id], 200);
    }
}
