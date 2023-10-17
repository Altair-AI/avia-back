<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Http\Requests\Operation\StoreOperationRequest;
use App\Http\Requests\Operation\UpdateOperationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class OperationController extends Controller
{
    /**
     * Create a new OperationController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Operation::class, 'operation');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Operation::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOperationRequest $request
     * @return JsonResponse|null
     */
    public function store(StoreOperationRequest $request)
    {
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE) {
            $validated = $request->validated();
            $operation = Operation::create($validated);
            return response()->json($operation);
        }
        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param Operation $operation
     * @return JsonResponse
     */
    public function show(Operation $operation)
    {
        return response()->json($operation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOperationRequest $request
     * @param Operation $operation
     * @return JsonResponse|null
     */
    public function update(UpdateOperationRequest $request, Operation $operation)
    {
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE) {
            $validated = $request->validated();
            $operation->fill($validated);
            $operation->save();
            return response()->json($operation);
        }
        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Operation $operation
     * @return JsonResponse|null
     */
    public function destroy(Operation $operation)
    {
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE) {
            $operation->delete();
            return response()->json(['id' => $operation->id], 200);
        }
        return null;
    }
}
