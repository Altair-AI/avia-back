<?php

namespace App\Http\Controllers;

use App\Models\CaseBasedKnowledgeBase;
use App\Http\Requests\CaseBasedKnowledgeBase\StoreCaseBasedKnowledgeBaseRequest;
use App\Http\Requests\CaseBasedKnowledgeBase\UpdateCaseBasedKnowledgeBaseRequest;
use App\Models\RealTimeTechnicalSystemUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class CaseBasedKnowledgeBaseController extends Controller
{
    /**
     * Create a new CaseBasedKnowledgeBaseController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(CaseBasedKnowledgeBase::class, 'case_based_knowledge_base');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $case_based_kb = [];
        if (auth()->user()->role === User::SUPER_ADMIN_ROLE)
            $case_based_kb = CaseBasedKnowledgeBase::with('user')->with('real_time_technical_system')
                ->with('project')->get();
        if (auth()->user()->role === User::ADMIN_ROLE) {
            // Формирование массива идентификаторов проектов в которых состоит администратор
            $project_ids = [];
            foreach (auth()->user()->organization->projects as $project)
                array_push($project_ids, $project->id);
            // Поиск всех баз знаний прецедентов совпадающих с массивом идентификаторов проектов
            $case_based_kb = CaseBasedKnowledgeBase::with('user')->with('real_time_technical_system')
                ->with('project')->whereIn('project_id', $project_ids)->get();
        }
        if (auth()->user()->role === User::TECHNICIAN_ROLE) {
            // Формирование массива идентификаторов технических систем реального времени, доступных технику
            $real_time_technical_system_ids = [];
            $user_tech_sys = RealTimeTechnicalSystemUser::where('user_id', auth()->user()->id)->get();
            foreach ($user_tech_sys as $uts)
                array_push($real_time_technical_system_ids, $uts->real_time_technical_system_id);
            // Поиск всех баз знаний прецедентов совпадающих с массивом идентификаторов технических систем реального времени
            $case_based_kb = CaseBasedKnowledgeBase::with('user')->with('real_time_technical_system')
                ->with('project')
                ->whereIn('real_time_technical_system_id', $real_time_technical_system_ids)
                ->get();
        }
        return response()->json($case_based_kb);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCaseBasedKnowledgeBaseRequest $request
     * @return JsonResponse
     */
    public function store(StoreCaseBasedKnowledgeBaseRequest $request)
    {
        $validated = $request->validated();
        $validated['author'] = auth()->user()->id;
        $caseBasedKnowledgeBase = CaseBasedKnowledgeBase::create($validated);
        return response()->json(array_merge($caseBasedKnowledgeBase->toArray(), [
            'user' => $caseBasedKnowledgeBase->user,
            'real_time_technical_system' => $caseBasedKnowledgeBase->real_time_technical_system,
            'project' => $caseBasedKnowledgeBase->project
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param CaseBasedKnowledgeBase $caseBasedKnowledgeBase
     * @return JsonResponse
     */
    public function show(CaseBasedKnowledgeBase $caseBasedKnowledgeBase)
    {
        return response()->json(array_merge($caseBasedKnowledgeBase->toArray(), [
            'user' => $caseBasedKnowledgeBase->user,
            'real_time_technical_system' => $caseBasedKnowledgeBase->real_time_technical_system,
            'project' => $caseBasedKnowledgeBase->project
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCaseBasedKnowledgeBaseRequest $request
     * @param CaseBasedKnowledgeBase $caseBasedKnowledgeBase
     * @return JsonResponse
     */
    public function update(UpdateCaseBasedKnowledgeBaseRequest $request, CaseBasedKnowledgeBase $caseBasedKnowledgeBase)
    {
        $validated = $request->validated();
        $caseBasedKnowledgeBase->fill($validated);
        $caseBasedKnowledgeBase->save();
        return response()->json(array_merge($caseBasedKnowledgeBase->toArray(), [
            'user' => $caseBasedKnowledgeBase->user,
            'real_time_technical_system' => $caseBasedKnowledgeBase->real_time_technical_system,
            'project' => $caseBasedKnowledgeBase->project
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CaseBasedKnowledgeBase $caseBasedKnowledgeBase
     * @return JsonResponse
     */
    public function destroy(CaseBasedKnowledgeBase $caseBasedKnowledgeBase)
    {
        $caseBasedKnowledgeBase->delete();
        return response()->json(['id' => $caseBasedKnowledgeBase->id], 200);
    }
}
