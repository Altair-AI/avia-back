<?php

namespace App\Http\Controllers;

use App\Components\Helper;
use App\Http\Filters\TechnicalSystemFilter;
use App\Http\Requests\TechnicalSystem\IndexTechnicalSystemRequest;
use App\Models\TechnicalSystem;
use App\Http\Requests\TechnicalSystem\StoreTechnicalSystemRequest;
use App\Http\Requests\TechnicalSystem\UpdateTechnicalSystemRequest;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

class TechnicalSystemController extends Controller
{
    /**
     * Create a new TechnicalSystemController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(TechnicalSystem::class, 'technical_system');
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexTechnicalSystemRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function index(IndexTechnicalSystemRequest $request)
    {
        $validated = $request->validated();
        $filter = app()->make(TechnicalSystemFilter::class,
            ['queryParams' => array_filter($validated, 'strlen')]);

        $pageSize = 10;
        if (isset($request['pageSize']))
            $pageSize = $request['pageSize'];

        $result = [];
        $technical_systems = [];
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE)
            $technical_systems = TechnicalSystem::filter($filter)->paginate($pageSize);
        if (auth()->user()->role == User::ADMIN_ROLE) {
            // Формирование вложенного массива (иерархии) технических систем доступных администратору
            $items = Helper::get_technical_system_hierarchy(auth()->user()->organization->id);
            // Получение всех идентификаторов технических систем для вложенного массива (иерархии) технических систем
            $tech_sys_ids = Helper::get_technical_system_ids($items, []);
            // Поиск всех технических систем удовлетворяющих фильтру и совпадающих с массивом идентификаторов
            $technical_systems = TechnicalSystem::filter($filter)->whereIn('id', $tech_sys_ids)->paginate($pageSize);
        }
        $data = [];
        foreach ($technical_systems as $technical_system)
            array_push($data, array_merge($technical_system->toArray(), [
                'documents' => $technical_system->documents,
                'grandchildren_technical_systems' => $technical_system->grandchildren_technical_systems
            ]));
        $result['data'] = $data;
        $result['page_current'] = !is_array($technical_systems) ? $technical_systems->currentPage() : null;
        $result['page_total'] = !is_array($technical_systems) ? $technical_systems->lastPage() : null;
        $result['page_size'] = !is_array($technical_systems) ? $technical_systems->perPage() : null;
        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTechnicalSystemRequest $request
     * @return JsonResponse
     */
    public function store(StoreTechnicalSystemRequest $request)
    {
        $validated = $request->validated();
        $technical_system = TechnicalSystem::create($validated);
        return response()->json($technical_system);
    }

    /**
     * Display the specified resource.
     *
     * @param TechnicalSystem $technical_system
     * @return JsonResponse
     */
    public function show(TechnicalSystem $technical_system)
    {
        return response()->json(array_merge($technical_system->toArray(), [
            'documents' => $technical_system->documents,
            'grandchildren_technical_systems' => $technical_system->grandchildren_technical_systems
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTechnicalSystemRequest $request
     * @param TechnicalSystem $technical_system
     * @return JsonResponse|null
     */
    public function update(UpdateTechnicalSystemRequest $request, TechnicalSystem $technical_system)
    {
        $validated = $request->validated();
        $technical_system->fill($validated);
        $technical_system->save();
        return response()->json($technical_system);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TechnicalSystem $technical_system
     * @return JsonResponse|null
     */
    public function destroy(TechnicalSystem $technical_system)
    {
        $technical_system->delete();
        return response()->json(['id' => $technical_system->id], 200);
    }
}
