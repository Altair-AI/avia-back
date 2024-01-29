<?php

namespace App\Http\Controllers;

use App\Http\Filters\AdditionalOperationRuleFilter;
use App\Http\Filters\OperationRuleFilter;
use App\Http\Requests\OperationRule\HierarchyOperationRuleRequest;
use App\Http\Requests\OperationRule\IndexOperationRuleRequest;
use App\Http\Requests\OperationRule\StoreOperationRuleRequest;
use App\Http\Requests\OperationRule\UpdateOperationRuleRequest;
use App\Models\Operation;
use App\Models\OperationRule;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

class OperationRuleController extends Controller
{
    /**
     * Create a new OperationRuleController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(OperationRule::class, 'operation_rule');
    }

    /**
     * Display a hierarchy listing of the resource.
     *
     * @param HierarchyOperationRuleRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function hierarchy(HierarchyOperationRuleRequest $request)
    {
        $validated = $request->validated();
        $filter = app()->make(AdditionalOperationRuleFilter::class, [
            'queryParams' => array_filter($validated, 'strlen')
        ]);

        // Получение списка работ (операций) верхнего уровния (РУН)
        $operations = [];
        if (auth()->user()->role === User::SUPER_ADMIN_ROLE or auth()->user()->role === User::ADMIN_ROLE)
            $operations = Operation::select('id')
                ->where('type', Operation::BASIC_OPERATION_TYPE)
                ->get();

        $result = [];
        $operation_rules = [];
        if (auth()->user()->role === User::SUPER_ADMIN_ROLE) {
            // Поиск правила определения работ и добавление его в общий список
            foreach ($operations as $operation) {
                $operation_rule = OperationRule::filter($filter)->where('operation_id_if', $operation->id)->first();
                if ($operation_rule)
                    array_push($operation_rules, $operation_rule);
            }
        }
        if (auth()->user()->role === User::ADMIN_ROLE) {
            // Формирование списка идентификаторов баз знаний правил доступных администратору
            $kb_ids = [];
            foreach (Organization::find(auth()->user()->organization->id)->projects as $project)
                foreach ($project->rule_based_knowledge_bases as $knowledge_base)
                    array_push($kb_ids, $knowledge_base->id);
            // Поиск правила определения работ и добавление его в общий список
            foreach ($operations as $operation) {
                // Получение списка правил доступных администратору
                $operation_rule = OperationRule::filter($filter)->whereIn('rule_based_knowledge_base_id', $kb_ids)
                    ->where('operation_id_if', $operation->id)->first();
                if ($operation_rule)
                    array_push($operation_rules, $operation_rule);
            }
        }

        // Формирование выходных данных
        $data = [];
        foreach ($operation_rules as $operation_rule) {
            $operation = Operation::where('id', $operation_rule->operation_id_if)->first();
            array_push($data, array_merge($operation->toArray(), [
                'operation_rules' => $operation->operation_rules,
                'hierarchy_operations' => $operation->hierarchy_operations,
            ]));
        }
        $result['operations'] = $data;
        return response()->json($result);
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexOperationRuleRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function index(IndexOperationRuleRequest $request)
    {
        $validated = $request->validated();
        $filter = app()->make(OperationRuleFilter::class, ['queryParams' => array_filter($validated, 'strlen')]);

        $pageSize = 10;
        if (isset($request['pageSize']))
            $pageSize = $request['pageSize'];

        $result = [];
        $operation_rules = [];
        if (auth()->user()->role === User::SUPER_ADMIN_ROLE)
            $operation_rules = OperationRule::filter($filter)->paginate($pageSize);
        if (auth()->user()->role === User::ADMIN_ROLE) {
            // Формирование списка идентификаторов баз знаний правил доступных администратору
            $kb_ids = [];
            foreach (Organization::find(auth()->user()->organization->id)->projects as $project)
                foreach ($project->rule_based_knowledge_bases as $knowledge_base)
                    array_push($kb_ids, $knowledge_base->id);
            // Получение списка правил доступных администратору
            $operation_rules = OperationRule::filter($filter)->whereIn('rule_based_knowledge_base_id', $kb_ids)
                ->paginate($pageSize);
        }
        $data = [];
        foreach ($operation_rules as $operation_rule)
            array_push($data, array_merge($operation_rule->toArray(), [
                'operation_if' => $operation_rule->operation_if,
                'operation_result_if' => $operation_rule->operation_result_if,
                'operation_then' => $operation_rule->operation_then,
                'rule_based_knowledge_base' => $operation_rule->rule_based_knowledge_base,
                'malfunction_cause' => $operation_rule->malfunction_cause,
                'document' => $operation_rule->document
            ]));
        $result['data'] = $data;
        $result['page_current'] = !is_array($operation_rules) ? $operation_rules->currentPage() : null;
        $result['page_total'] = !is_array($operation_rules) ? $operation_rules->lastPage() : null;
        $result['page_size'] = !is_array($operation_rules) ? $operation_rules->perPage() : null;
        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOperationRuleRequest $request
     * @return JsonResponse
     */
    public function store(StoreOperationRuleRequest $request)
    {
        $validated = $request->validated();
        $operationRule = OperationRule::create($validated);
        return response()->json(array_merge($operationRule->toArray(), [
            'operation_if' => $operationRule->operation_if,
            'operation_result_if' => $operationRule->operation_result_if,
            'operation_then' => $operationRule->operation_then,
            'rule_based_knowledge_base' => $operationRule->rule_based_knowledge_base,
            'malfunction_cause' => $operationRule->malfunction_cause,
            'document' => $operationRule->document
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param OperationRule $operationRule
     * @return JsonResponse
     */
    public function show(OperationRule $operationRule)
    {
        return response()->json(array_merge($operationRule->toArray(), [
            'operation_if' => $operationRule->operation_if,
            'operation_result_if' => $operationRule->operation_result_if,
            'operation_then' => $operationRule->operation_then,
            'rule_based_knowledge_base' => $operationRule->rule_based_knowledge_base,
            'malfunction_cause' => $operationRule->malfunction_cause,
            'document' => $operationRule->document
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOperationRuleRequest $request
     * @param OperationRule $operationRule
     * @return JsonResponse
     */
    public function update(UpdateOperationRuleRequest $request, OperationRule $operationRule)
    {
        $validated = $request->validated();
        $operationRule->fill($validated);
        $operationRule->save();
        return response()->json(array_merge($operationRule->toArray(), [
            'operation_if' => $operationRule->operation_if,
            'operation_result_if' => $operationRule->operation_result_if,
            'operation_then' => $operationRule->operation_then,
            'rule_based_knowledge_base' => $operationRule->rule_based_knowledge_base,
            'malfunction_cause' => $operationRule->malfunction_cause,
            'document' => $operationRule->document
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param OperationRule $operationRule
     * @return JsonResponse
     */
    public function destroy(OperationRule $operationRule)
    {
        $operationRule->delete();
        return response()->json(['id' => $operationRule->id], 200);
    }
}
