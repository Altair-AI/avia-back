<?php

namespace App\Http\Controllers;

use App\Components\Helper;
use App\Models\Operation;
use App\Models\User;
use App\Http\Requests\Operation\StoreOperationRequest;
use App\Http\Requests\Operation\UpdateOperationRequest;
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
        $operations = [];
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE)
            $operations = Operation::with('technical_systems')->with('sub_operations')->get();
        if (auth()->user()->role == User::ADMIN_ROLE) {
            // Формирование вложенного массива (иерархии) технических систем доступных администратору
            $technical_systems = Helper::get_technical_system_hierarchy(auth()->user()->organization->id);
            // Получение всех кодов технических систем или объектов для вложенного массива (иерархии) технических систем
            $technical_system_codes = Helper::get_technical_system_codes($technical_systems, []);
            // Получение списка иерархии работ (операций) для технических систем доступных администратору
            foreach (Operation::all() as $operation)
                foreach ($technical_system_codes as $technical_system_code)
                    foreach ($operation->technical_systems as $technical_system)
                        if ($technical_system->code == $technical_system_code)
                            array_push($operations, array_merge($operation->toArray(), [
                                'technical_systems' => $operation->technical_systems,
                                'sub_operations' => $operation->sub_operations
                            ]));
        }
        return response()->json($operations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOperationRequest $request
     * @return JsonResponse|null
     */
    public function store(StoreOperationRequest $request)
    {
        $validated = $request->validated();
        $operation = Operation::create($validated);
        return response()->json($operation);
    }

    /**
     * Display the specified resource.
     *
     * @param Operation $operation
     * @return JsonResponse
     */
    public function show(Operation $operation)
    {
        return response()->json(array_merge($operation->toArray(), [
            'technical_systems' => $operation->technical_systems,
            'sub_operations' => $operation->sub_operations
        ]));
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
        $validated = $request->validated();
        $operation->fill($validated);
        $operation->save();
        return response()->json($operation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Operation $operation
     * @return JsonResponse|null
     */
    public function destroy(Operation $operation)
    {
        $operation->delete();
        return response()->json(['id' => $operation->id], 200);
    }
}
