<?php

namespace App\Http\Controllers;

use App\Models\CompletedOperation;
use App\Http\Requests\CompletedOperation\StoreCompletedOperationRequest;
use App\Http\Requests\CompletedOperation\UpdateCompletedOperationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class CompletedOperationController extends Controller
{
    /**
     * Create a new CompletedOperationController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(CompletedOperation::class, 'completed_operation');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $completedOperations = [];
        if (auth()->user()->role === User::SUPER_ADMIN_ROLE or auth()->user()->role === User::ADMIN_ROLE)
            $completedOperations = CompletedOperation::with('operation')
                ->with('previous_operation')
                ->with('operation_result')
                ->with('work_session')
                ->get();
        return response()->json($completedOperations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompletedOperationRequest $request
     * @return JsonResponse
     */
    public function store(StoreCompletedOperationRequest $request)
    {
        $validated = $request->validated();
        $completedOperation = CompletedOperation::create($validated);
        return response()->json($completedOperation);
    }

    /**
     * Display the specified resource.
     *
     * @param CompletedOperation $completedOperation
     * @return JsonResponse
     */
    public function show(CompletedOperation $completedOperation)
    {
        return response()->json(array_merge($completedOperation->toArray(), [
            'operation' => $completedOperation->operation,
            'previous_operation' => $completedOperation->previous_operation,
            'operation_result' => $completedOperation->operation_result,
            'work_session' => $completedOperation->work_session
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCompletedOperationRequest $request
     * @param CompletedOperation $completedOperation
     * @return JsonResponse
     */
    public function update(UpdateCompletedOperationRequest $request, CompletedOperation $completedOperation)
    {
        $validated = $request->validated();
        $completedOperation->fill($validated);
        $completedOperation->save();
        return response()->json($completedOperation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CompletedOperation $completedOperation
     * @return JsonResponse
     */
    public function destroy(CompletedOperation $completedOperation)
    {
        $completedOperation->delete();
        return response()->json(['id' => $completedOperation->id], 200);
    }
}
