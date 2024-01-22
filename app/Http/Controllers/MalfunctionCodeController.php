<?php

namespace App\Http\Controllers;

use App\Components\Helper;
use App\Http\Filters\MalfunctionCodeFilter;
use App\Http\Requests\MalfunctionCode\IndexMalfunctionCodeRequest;
use App\Models\MalfunctionCode;
use App\Http\Requests\MalfunctionCode\StoreMalfunctionCodeRequest;
use App\Http\Requests\MalfunctionCode\UpdateMalfunctionCodeRequest;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

class MalfunctionCodeController extends Controller
{
    /**
     * Create a new MalfunctionCodeController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(MalfunctionCode::class, 'malfunction_code');
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexMalfunctionCodeRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function index(IndexMalfunctionCodeRequest $request)
    {
        $validated = $request->validated();
        $filter = app()->make(MalfunctionCodeFilter::class,
            ['queryParams' => array_filter($validated, 'strlen')]);

        $pageSize = 10;
        if (isset($request['pageSize']))
            $pageSize = $request['pageSize'];

        $result = [];
        $malfunction_codes = [];
        if (auth()->user()->role === User::SUPER_ADMIN_ROLE)
            $malfunction_codes = MalfunctionCode::filter($filter)->paginate($pageSize);
        if (auth()->user()->role === User::ADMIN_ROLE or auth()->user()->role === User::TECHNICIAN_ROLE) {
            // Формирование вложенного массива (иерархии) технических систем доступных администратору и технику
            $items = Helper::get_technical_system_hierarchy(auth()->user()->organization_id);
            // Получение всех идентификаторов технических систем для вложенного массива (иерархии) технических систем
            $tech_sys_ids = Helper::get_technical_system_ids($items, []);
            // Поиск всех технических систем удовлетворяющих фильтру и совпадающих с массивом идентификаторов
            $malfunction_codes = MalfunctionCode::filter($filter)->whereIn('technical_system_id', $tech_sys_ids)
                ->paginate($pageSize);
        }
        $data = [];
        foreach ($malfunction_codes as $malfunction_code)
            array_push($data, $malfunction_code->toArray());
        $result['data'] = $data;
        $result['page_current'] = !is_array($malfunction_codes) ? $malfunction_codes->currentPage() : null;
        $result['page_total'] = !is_array($malfunction_codes) ? $malfunction_codes->lastPage() : null;
        $result['page_size'] = !is_array($malfunction_codes) ? $malfunction_codes->perPage() : null;
        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMalfunctionCodeRequest $request
     * @return JsonResponse
     */
    public function store(StoreMalfunctionCodeRequest $request)
    {
        $validated = $request->validated();
        $malfunctionCode = MalfunctionCode::create($validated);
        return response()->json($malfunctionCode);
    }

    /**
     * Display the specified resource.
     *
     * @param MalfunctionCode $malfunctionCode
     * @return JsonResponse
     */
    public function show(MalfunctionCode $malfunctionCode)
    {
        return response()->json($malfunctionCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMalfunctionCodeRequest $request
     * @param MalfunctionCode $malfunctionCode
     * @return JsonResponse
     */
    public function update(UpdateMalfunctionCodeRequest $request, MalfunctionCode $malfunctionCode)
    {
        $validated = $request->validated();
        $malfunctionCode->fill($validated);
        $malfunctionCode->save();
        return response()->json($malfunctionCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MalfunctionCode $malfunctionCode
     * @return JsonResponse
     */
    public function destroy(MalfunctionCode $malfunctionCode)
    {
        $malfunctionCode->delete();
        return response()->json(['id' => $malfunctionCode->id], 200);
    }
}
