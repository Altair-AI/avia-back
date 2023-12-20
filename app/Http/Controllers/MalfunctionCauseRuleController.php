<?php

namespace App\Http\Controllers;

use App\Http\Filters\MalfunctionCauseRuleFilter;
use App\Models\MalfunctionCauseRule;
use App\Http\Requests\MalfunctionCauseRule\IndexMalfunctionCauseRuleRequest;
use App\Http\Requests\MalfunctionCauseRule\StoreMalfunctionCauseRuleRequest;
use App\Http\Requests\MalfunctionCauseRule\UpdateMalfunctionCauseRuleRequest;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

class MalfunctionCauseRuleController extends Controller
{
    /**
     * Create a new MalfunctionCauseRuleController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(MalfunctionCauseRule::class, 'malfunction_cause_rule');
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexMalfunctionCauseRuleRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function index(IndexMalfunctionCauseRuleRequest $request)
    {
        $validated = $request->validated();
        $filter = app()->make(MalfunctionCauseRuleFilter::class,
            ['queryParams' => array_filter($validated, 'strlen')]);

        $pageSize = 10;
        if (isset($request['pageSize']))
            $pageSize = $request['pageSize'];

        $result = [];
        $malfunction_cause_rules = [];
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE)
            $malfunction_cause_rules = MalfunctionCauseRule::filter($filter)
                ->with('document')
                ->with('rule_based_knowledge_base')
                ->with('malfunction_causes')
                ->paginate($pageSize);
        if (auth()->user()->role == User::ADMIN_ROLE) {
            // Формирование списка идентификаторов баз знаний правил доступных администратору
            $kb_ids = [];
            foreach (Organization::find(auth()->user()->organization->id)->projects as $project)
                foreach ($project->rule_based_knowledge_bases as $knowledge_base)
                    array_push($kb_ids, $knowledge_base->id);
            // Получение списка правил доступных администратору
            $malfunction_cause_rules = MalfunctionCauseRule::filter($filter)
                ->with('document')
                ->with('rule_based_knowledge_base')
                ->with('malfunction_causes')
                ->whereIn('rule_based_knowledge_base_id', $kb_ids)
                ->paginate($pageSize);
        }
        $data = [];
        foreach ($malfunction_cause_rules as $malfunction_cause_rule)
            array_push($data, array_merge($malfunction_cause_rule->toArray(), [
                'malfunction_codes' => $malfunction_cause_rule->malfunction_codes,
                'actions' => [
                    'technical_systems' => $malfunction_cause_rule->technical_systems,
                    'operations' => $malfunction_cause_rule->operations,
                ]
            ]));
        $result['data'] = $data;
        $result['page_current'] = !is_array($malfunction_cause_rules) ? $malfunction_cause_rules->currentPage() : null;
        $result['page_total'] = !is_array($malfunction_cause_rules) ? $malfunction_cause_rules->lastPage() : null;
        $result['page_size'] = !is_array($malfunction_cause_rules) ? $malfunction_cause_rules->perPage() : null;
        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMalfunctionCauseRuleRequest $request
     * @return JsonResponse
     */
    public function store(StoreMalfunctionCauseRuleRequest $request)
    {
        $validated = $request->validated();
        $malfunctionCauseRule = MalfunctionCauseRule::create($validated);
        return response()->json($malfunctionCauseRule);
    }

    /**
     * Display the specified resource.
     *
     * @param MalfunctionCauseRule $malfunctionCauseRule
     * @return JsonResponse
     */
    public function show(MalfunctionCauseRule $malfunctionCauseRule)
    {
        return response()->json(array_merge($malfunctionCauseRule->toArray(), [
            'document' => $malfunctionCauseRule->document,
            'rule_based_knowledge_base' => $malfunctionCauseRule->rule_based_knowledge_base,
            'malfunction_causes' => $malfunctionCauseRule->malfunction_causes,
            'malfunction_codes' => $malfunctionCauseRule->malfunction_codes,
            'actions' => [
                'technical_systems' => $malfunctionCauseRule->technical_systems,
                'operations' => $malfunctionCauseRule->operations,
            ]
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMalfunctionCauseRuleRequest $request
     * @param MalfunctionCauseRule $malfunctionCauseRule
     * @return JsonResponse
     */
    public function update(UpdateMalfunctionCauseRuleRequest $request, MalfunctionCauseRule $malfunctionCauseRule)
    {
        $validated = $request->validated();
        $malfunctionCauseRule->fill($validated);
        $malfunctionCauseRule->save();
        return response()->json(array_merge($malfunctionCauseRule->toArray(), [
            'document' => $malfunctionCauseRule->document,
            'rule_based_knowledge_base' => $malfunctionCauseRule->rule_based_knowledge_base
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MalfunctionCauseRule $malfunctionCauseRule
     * @return JsonResponse
     */
    public function destroy(MalfunctionCauseRule $malfunctionCauseRule)
    {
        $malfunctionCauseRule->delete();
        return response()->json(['id' => $malfunctionCauseRule->id], 200);
    }
}
