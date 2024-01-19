<?php

namespace App\Http\Controllers;

use App\Components\Helper;
use App\Models\MalfunctionCode;
use App\Http\Requests\MalfunctionCode\StoreMalfunctionCodeRequest;
use App\Http\Requests\MalfunctionCode\UpdateMalfunctionCodeRequest;
use App\Models\User;
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
     * @return JsonResponse
     */
    public function index()
    {
        $malfunction_codes = [];
        if (auth()->user()->role === User::SUPER_ADMIN_ROLE)
            $malfunction_codes = MalfunctionCode::with('technical_system')->get();
        if (auth()->user()->role === User::ADMIN_ROLE) {
            // Формирование вложенного массива (иерархии) технических систем доступных администратору
            $items = Helper::get_technical_system_hierarchy(auth()->user()->organization->id);
            // Получение всех идентификаторов технических систем для вложенного массива (иерархии) технических систем
            $tech_sys_ids = Helper::get_technical_system_ids($items, []);
            // Поиск всех технических систем удовлетворяющих фильтру и совпадающих с массивом идентификаторов
            $malfunction_codes = MalfunctionCode::with('technical_system')
                ->whereIn('technical_system_id', $tech_sys_ids)->get();
        }
        return response()->json($malfunction_codes);
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
        return response()->json(array_merge($malfunctionCode->toArray(), [
            'technical_system' => $malfunctionCode->technical_system
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param MalfunctionCode $malfunctionCode
     * @return JsonResponse
     */
    public function show(MalfunctionCode $malfunctionCode)
    {
        return response()->json(array_merge($malfunctionCode->toArray(), [
            'technical_system' => $malfunctionCode->technical_system
        ]));
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
        return response()->json(array_merge($malfunctionCode->toArray(), [
            'technical_system' => $malfunctionCode->technical_system
        ]));
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
