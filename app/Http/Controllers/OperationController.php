<?php

namespace App\Http\Controllers;

use App\Components\CSVDataExporter\OperationExporter;
use App\Components\CSVDataExporter\SubOperationExporter;
use App\Components\Helper;
use App\Http\Filters\OperationFilter;
use App\Http\Requests\Operation\IndexOperationRequest;
use App\Models\Operation;
use App\Models\Organization;
use App\Models\TechnicalSystemOperation;
use App\Models\User;
use App\Http\Requests\Operation\StoreOperationRequest;
use App\Http\Requests\Operation\UpdateOperationRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
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
     * Export main operations to csv file.
     */
    public function exportRoot()
    {
        // Формирование вложенного массива (иерархии) технических систем доступных администратору
        $technical_systems = Helper::get_technical_system_hierarchy(auth()->user()->organization->id);
        // Получение всех идентификаторов технических систем для вложенного массива (иерархии) технических систем
        $tech_sys_ids = Helper::get_technical_system_ids($technical_systems, []);
        // Поиск работ
        $operations = [];
        if (auth()->user()->role === User::SUPER_ADMIN_ROLE)
            $operations = Operation::where('type', Operation::BASIC_OPERATION_TYPE)->get();
        if (auth()->user()->role === User::ADMIN_ROLE)
            // Получение списка работ (операций) для технических систем доступных администратору
            $operations = Operation::whereIn('id', TechnicalSystemOperation::select(['operation_id'])
                ->whereIn('technical_system_id', $tech_sys_ids))
                ->where('type', Operation::BASIC_OPERATION_TYPE)
                ->get();
        // Экспорт правил работ в форме CSV-файла
        $exporter = new OperationExporter();
        $data = $exporter->generate($operations);
        $exporter->export($exporter::FILE_NAME, $data);
    }

    /**
     * Export sub-operations to csv file.
     */
    public function exportSub()
    {
        // Формирование вложенного массива (иерархии) технических систем доступных администратору
        $technical_systems = Helper::get_technical_system_hierarchy(auth()->user()->organization->id);
        // Получение всех идентификаторов технических систем для вложенного массива (иерархии) технических систем
        $tech_sys_ids = Helper::get_technical_system_ids($technical_systems, []);
        // Поиск работ
        $operations = [];
        if (auth()->user()->role === User::SUPER_ADMIN_ROLE)
            $operations = Operation::where('type', Operation::NESTED_OPERATION_TYPE)->get();
        if (auth()->user()->role === User::ADMIN_ROLE)
            // Получение списка работ (операций) для технических систем доступных администратору
            $operations = Operation::whereIn('id', TechnicalSystemOperation::select(['operation_id'])
                ->whereIn('technical_system_id', $tech_sys_ids))
                ->where('type', Operation::NESTED_OPERATION_TYPE)
                ->get();
        // Экспорт правил работ в форме CSV-файла
        $exporter = new SubOperationExporter();
        $data = $exporter->generate($operations);
        $exporter->export($exporter::FILE_NAME, $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexOperationRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function index(IndexOperationRequest $request)
    {
        $validated = $request->validated();
        $filter = app()->make(OperationFilter::class, ['queryParams' => array_filter($validated, 'strlen')]);

        $pageSize = 10;
        if (isset($request['pageSize']))
            $pageSize = $request['pageSize'];

        $technical_system_id = null;
        if (isset($request['technical_system_id']))
            $technical_system_id = $request['technical_system_id'];

        $result = [];
        $operations = [];
        if (auth()->user()->role === User::SUPER_ADMIN_ROLE)
            if ($technical_system_id)
                $operations = Operation::filter($filter)
                    ->whereIn('id', TechnicalSystemOperation::select(['operation_id'])
                    ->where('technical_system_id', $technical_system_id))
                    ->paginate($pageSize);
            else
                $operations = Operation::filter($filter)->paginate($pageSize);
        if (auth()->user()->role === User::ADMIN_ROLE) {
            // Формирование вложенного массива (иерархии) технических систем доступных администратору
            $technical_systems = Helper::get_technical_system_hierarchy(auth()->user()->organization->id);
            // Получение всех идентификаторов технических систем для вложенного массива (иерархии) технических систем
            $tech_sys_ids = Helper::get_technical_system_ids($technical_systems, []);
            if (in_array($technical_system_id, $tech_sys_ids))
                $tech_sys_ids = [$technical_system_id];
            // Получение списка работ (операций) для технических систем доступных администратору
            $operations = Operation::filter($filter)->whereIn('id', TechnicalSystemOperation::select(['operation_id'])
                ->whereIn('technical_system_id', $tech_sys_ids))->paginate($pageSize);
        }
        $data = [];
        foreach ($operations as $operation)
            array_push($data, array_merge($operation->toArray(), [
                'technical_systems' => $operation->technical_systems,
                'operation_results' => $operation->operation_results,
                'operation_conditions' => $operation->operation_conditions,
                'malfunction_codes' => $operation->malfunction_codes,
                'malfunction_causes' => $operation->malfunction_causes,
                'sub_operations' => $operation->sub_operations
            ]));
        $result['data'] = $data;
        $result['page_current'] = !is_array($operations) ? $operations->currentPage() : null;
        $result['page_total'] = !is_array($operations) ? $operations->lastPage() : null;
        $result['page_size'] = !is_array($operations) ? $operations->perPage() : null;
        return response()->json($result);
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
            'operation_results' => $operation->operation_results,
            'operation_conditions' => $operation->operation_conditions,
            'malfunction_codes' => $operation->malfunction_codes,
            'malfunction_causes' => $operation->malfunction_causes,
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
