<?php

namespace App\Http\Controllers;

use App\Http\Filters\OperationRuleFilter;
use App\Http\Requests\OperationRule\IndexOperationRuleRequest;
use App\Http\Requests\OperationRule\StoreOperationRuleRequest;
use App\Http\Requests\OperationRule\UpdateOperationRuleRequest;
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
            $operation_rules = OperationRule::filter($filter)
                ->with('operation_if')
                ->with('operation_result')
                ->with('operation_then')
                ->with('rule_based_knowledge_base')
                ->with('malfunction_cause')
                ->with('malfunction_system')
                ->with('document')
                ->paginate($pageSize);
        if (auth()->user()->role === User::ADMIN_ROLE) {
            // Формирование списка идентификаторов баз знаний правил доступных администратору
            $kb_ids = [];
            foreach (Organization::find(auth()->user()->organization->id)->projects as $project)
                foreach ($project->rule_based_knowledge_bases as $knowledge_base)
                    array_push($kb_ids, $knowledge_base->id);
            // Получение списка правил доступных администратору
            $operation_rules = OperationRule::filter($filter)
                ->with('operation_if')
                ->with('operation_result')
                ->with('operation_then')
                ->with('rule_based_knowledge_base')
                ->with('malfunction_cause')
                ->with('malfunction_system')
                ->with('document')
                ->whereIn('rule_based_knowledge_base_id', $kb_ids)
                ->paginate($pageSize);
        }
        $data = [];
        foreach ($operation_rules as $malfunction_cause_rule)
            array_push($data, $malfunction_cause_rule->toArray());
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
        return response()->json($operationRule);
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
            'operation_if' => $operationRule->operation_then,
            'operation_result' => $operationRule->operation_then,
            'operation_then' => $operationRule->operation_then,
            'rule_based_knowledge_base' => $operationRule->rule_based_knowledge_base,
            'malfunction_cause' => $operationRule->malfunction_cause,
            'malfunction_system' => $operationRule->malfunction_system,
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
            'operation_if' => $operationRule->operation_then,
            'operation_result' => $operationRule->operation_then,
            'operation_then' => $operationRule->operation_then,
            'rule_based_knowledge_base' => $operationRule->rule_based_knowledge_base,
            'malfunction_cause' => $operationRule->malfunction_cause,
            'malfunction_system' => $operationRule->malfunction_system,
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
