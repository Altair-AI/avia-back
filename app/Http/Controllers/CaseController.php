<?php

namespace App\Http\Controllers;

use App\Http\Filters\CaseFilter;
use App\Http\Requests\ECase\IndexCaseRequest;
use App\Http\Resources\Cases\CaseResource;
use App\Models\CaseBasedKnowledgeBase;
use App\Models\ECase;
use App\Http\Requests\ECase\StoreCaseRequest;
use App\Http\Requests\ECase\UpdateCaseRequest;
use App\Models\RealTimeTechnicalSystemUser;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

class CaseController extends Controller
{
    /**
     * Create a new ECaseController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(ECase::class, 'case');
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexCaseRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function index(IndexCaseRequest $request)
    {
        $validated = $request->validated();
        $filter = app()->make(CaseFilter::class, ['queryParams' => array_filter($validated, 'strlen')]);

        $pageSize = 10;
        if (isset($request['pageSize']))
            $pageSize = $request['pageSize'];

        $result = [];
        $cases = [];
        if (auth()->user()->role === User::SUPER_ADMIN_ROLE)
            $cases = ECase::filter($filter)->paginate($pageSize);
        if (auth()->user()->role === User::ADMIN_ROLE) {
            // Формирование массива идентификаторов проектов в которых состоит администратор
            $project_ids = [];
            foreach (auth()->user()->organization->projects as $project)
                array_push($project_ids, $project->id);
            // Формирование id баз знаний прецедентов совпадающих с массивом идентификаторов проектов
            $case_based_kb_ids = CaseBasedKnowledgeBase::select('id')
                ->whereIn('project_id', $project_ids)->get();
            // Выбираем только те прецеденты, которые доступны в рамках определенной базы знаний прецедентов
            $cases = ECase::filter($filter)->whereIn('case_based_knowledge_base_id', $case_based_kb_ids)
                ->paginate($pageSize);
        }
        if (auth()->user()->role === User::TECHNICIAN_ROLE) {
            // Формирование массива идентификаторов технических систем реального времени, доступных технику
            $real_time_tech_system_ids = RealTimeTechnicalSystemUser::select('real_time_technical_system_id')
                ->where('user_id', auth()->user()->id)
                ->get();
            // Формирование id баз знаний прецедентов совпадающих с массивом идентификаторов технических систем реального времени
            $case_based_kb_ids = CaseBasedKnowledgeBase::select('id')
                ->whereIn('real_time_technical_system_id', $real_time_tech_system_ids)->get();
            // Выбираем только те прецеденты, которые доступны в рамках определенной базы знаний прецедентов
            $cases = ECase::filter($filter)->whereIn('case_based_knowledge_base_id', $case_based_kb_ids)
                ->paginate($pageSize);
        }
        $result['data'] = CaseResource::collection($cases);
        $result['page_current'] = !is_array($cases) ? $cases->currentPage() : null;
        $result['page_total'] = !is_array($cases) ? $cases->lastPage() : null;
        $result['page_size'] = !is_array($cases) ? $cases->perPage() : null;
        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCaseRequest $request
     * @return JsonResponse
     */
    public function store(StoreCaseRequest $request)
    {
        $validated = $request->validated();
        $case = ECase::create($validated);
        return response()->json($case);
    }

    /**
     * Display the specified resource.
     *
     * @param ECase $case
     * @return JsonResponse
     */
    public function show(ECase $case)
    {
        return response()->json(array_merge($case->toArray(), [
            'malfunction_detection_stage' => $case->malfunction_detection_stage,
            'malfunction_cause' => $case->malfunction_cause,
            'system_for_repair' => $case->system_for_repair,
            'initial_completed_operation' => $case->initial_completed_operation,
            'case_based_knowledge_base' => $case->case_based_knowledge_base
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCaseRequest $request
     * @param ECase $case
     * @return JsonResponse
     */
    public function update(UpdateCaseRequest $request, ECase $case)
    {
        $validated = $request->validated();
        $case->fill($validated);
        $case->save();
        return response()->json($case);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ECase $case
     * @return JsonResponse
     */
    public function destroy(ECase $case)
    {
        $case->delete();
        return response()->json(['id' => $case->id], 200);
    }
}
