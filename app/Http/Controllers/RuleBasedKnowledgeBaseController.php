<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\RuleBasedKnowledgeBase;
use App\Http\Requests\RuleBasedKnowledgeBase\StoreRuleBasedKnowledgeBaseRequest;
use App\Http\Requests\RuleBasedKnowledgeBase\UpdateRuleBasedKnowledgeBaseRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RuleBasedKnowledgeBaseController extends Controller
{
    /**
     * Create a new RuleBasedKnowledgeBaseController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(RuleBasedKnowledgeBase::class, 'rule_based_knowledge_base');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $rule_based_kb = [];
        if (auth()->user()->role === User::SUPER_ADMIN_ROLE)
            $rule_based_kb = RuleBasedKnowledgeBase::with('user')->with('technical_system')->get();
        if (auth()->user()->role === User::ADMIN_ROLE)
            foreach (Organization::find(auth()->user()->organization_id)->projects as $project)
                array_push($rule_based_kb, RuleBasedKnowledgeBase::with('user')
                    ->with('technical_system')->find($project->technical_system_id)->toArray());
        return response()->json($rule_based_kb);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRuleBasedKnowledgeBaseRequest $request
     * @return JsonResponse
     */
    public function store(StoreRuleBasedKnowledgeBaseRequest $request)
    {
        $validated = $request->validated();
        $ruleBasedKnowledgeBase = RuleBasedKnowledgeBase::create($validated);
        return response()->json(array_merge($ruleBasedKnowledgeBase->toArray(), [
            'user' => $ruleBasedKnowledgeBase->user,
            'technical_system' => $ruleBasedKnowledgeBase->technical_system
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param RuleBasedKnowledgeBase $ruleBasedKnowledgeBase
     * @return JsonResponse
     */
    public function show(RuleBasedKnowledgeBase $ruleBasedKnowledgeBase)
    {
        return response()->json(array_merge($ruleBasedKnowledgeBase->toArray(), [
            'user' => $ruleBasedKnowledgeBase->user,
            'technical_system' => $ruleBasedKnowledgeBase->technical_system
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRuleBasedKnowledgeBaseRequest $request
     * @param RuleBasedKnowledgeBase $ruleBasedKnowledgeBase
     * @return JsonResponse
     */
    public function update(UpdateRuleBasedKnowledgeBaseRequest $request, RuleBasedKnowledgeBase $ruleBasedKnowledgeBase)
    {
        $validated = $request->validated();
        $ruleBasedKnowledgeBase->fill($validated);
        $ruleBasedKnowledgeBase->save();
        return response()->json(array_merge($ruleBasedKnowledgeBase->toArray(), [
            'user' => $ruleBasedKnowledgeBase->user,
            'technical_system' => $ruleBasedKnowledgeBase->technical_system
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RuleBasedKnowledgeBase $ruleBasedKnowledgeBase
     * @return JsonResponse
     */
    public function destroy(RuleBasedKnowledgeBase $ruleBasedKnowledgeBase)
    {
        $ruleBasedKnowledgeBase->delete();
        return response()->json(['id' => $ruleBasedKnowledgeBase->id], 200);
    }
}
