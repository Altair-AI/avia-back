<?php

namespace App\Http\Controllers;

use App\Http\Filters\RealTimeTechnicalSystemFilter;
use App\Models\RealTimeTechnicalSystem;
use App\Http\Requests\RealTimeTechnicalSystem\IndexRealTimeTechnicalSystemRequest;
use App\Http\Requests\RealTimeTechnicalSystem\StoreRealTimeTechnicalSystemRequest;
use App\Http\Requests\RealTimeTechnicalSystem\UpdateRealTimeTechnicalSystemRequest;
use App\Models\RealTimeTechnicalSystemUser;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

class RealTimeTechnicalSystemController extends Controller
{
    /**
     * Create a new RealTimeTechnicalSystemController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(RealTimeTechnicalSystem::class, 'real_time_technical_system');
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexRealTimeTechnicalSystemRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function index(IndexRealTimeTechnicalSystemRequest $request)
    {
        $validated = $request->validated();
        $filter = app()->make(RealTimeTechnicalSystemFilter::class,
            ['queryParams' => array_filter($validated, 'strlen')]);

        $pageSize = 10;
        if (isset($request['pageSize']))
            $pageSize = $request['pageSize'];

        $result = [];
        $real_time_ts = [];
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE)
            $real_time_ts = RealTimeTechnicalSystem::with('technical_system')->with('project')
                ->filter($filter)->paginate($pageSize);
        if (auth()->user()->role == User::ADMIN_ROLE) {
            // Формирование массива идентификаторов проектов в которых состоит администратор
            $project_ids = [];
            foreach (auth()->user()->organization->projects as $project)
                array_push($project_ids, $project->id);
            // Поиск всех технических систем реального удовлетворяющих фильтру и совпадающих с массивом идентификаторов
            $real_time_ts = RealTimeTechnicalSystem::with('technical_system')->with('project')
                ->filter($filter)->whereIn('project_id', $project_ids) ->paginate($pageSize);
        }
        if (auth()->user()->role == User::TECHNICIAN_ROLE) {
            $real_time_technical_system_ids = [];
            $user_tech_sys = RealTimeTechnicalSystemUser::where('user_id', auth()->user()->id)->get();
            foreach ($user_tech_sys as $uts)
                array_push($real_time_technical_system_ids, $uts->real_time_technical_system_id);
            // Поиск всех технических систем реального удовлетворяющих фильтру и совпадающих с массивом идентификаторов
            $real_time_ts = RealTimeTechnicalSystem::with('technical_system')->with('project')
                ->filter($filter)->whereIn('id', $real_time_technical_system_ids)->paginate($pageSize);
        }
        $data = [];
        foreach ($real_time_ts as $system)
            array_push($data, $system->toArray());
        $result['data'] = $data;
        $result['page_current'] = !is_array($real_time_ts) ? $real_time_ts->currentPage() : null;
        $result['page_total'] = !is_array($real_time_ts) ? $real_time_ts->lastPage() : null;
        $result['page_size'] = !is_array($real_time_ts) ? $real_time_ts->perPage() : null;
        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRealTimeTechnicalSystemRequest $request
     * @return JsonResponse
     */
    public function store(StoreRealTimeTechnicalSystemRequest $request)
    {
        $validated = $request->validated();
        $realTimeTechnicalSystem = RealTimeTechnicalSystem::create($validated);
        return response()->json($realTimeTechnicalSystem);
    }

    /**
     * Display the specified resource.
     *
     * @param RealTimeTechnicalSystem $realTimeTechnicalSystem
     * @return JsonResponse
     */
    public function show(RealTimeTechnicalSystem $realTimeTechnicalSystem)
    {
        return response()->json(array_merge($realTimeTechnicalSystem->toArray(), [
            'technical_system' => $realTimeTechnicalSystem->technical_system,
            'project' => $realTimeTechnicalSystem->project
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRealTimeTechnicalSystemRequest $request
     * @param RealTimeTechnicalSystem $realTimeTechnicalSystem
     * @return JsonResponse
     */
    public function update(UpdateRealTimeTechnicalSystemRequest $request,
                           RealTimeTechnicalSystem $realTimeTechnicalSystem)
    {
        $validated = $request->validated();
        $realTimeTechnicalSystem->fill($validated);
        $realTimeTechnicalSystem->save();
        return response()->json($realTimeTechnicalSystem);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RealTimeTechnicalSystem $realTimeTechnicalSystem
     * @return JsonResponse
     */
    public function destroy(RealTimeTechnicalSystem $realTimeTechnicalSystem)
    {
        $realTimeTechnicalSystem->delete();
        return response()->json(['id' => $realTimeTechnicalSystem->id], 200);
    }
}
