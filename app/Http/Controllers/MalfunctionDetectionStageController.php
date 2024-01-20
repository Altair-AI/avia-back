<?php

namespace App\Http\Controllers;

use App\Models\MalfunctionDetectionStage;
use App\Http\Requests\MalfunctionDetectionStage\StoreMalfunctionDetectionStageRequest;
use App\Http\Requests\MalfunctionDetectionStage\UpdateMalfunctionDetectionStageRequest;
use Illuminate\Http\JsonResponse;

class MalfunctionDetectionStageController extends Controller
{
    /**
     * Create a new MalfunctionDetectionStageController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(MalfunctionDetectionStage::class, 'malfunction_detection_stage');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(MalfunctionDetectionStage::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMalfunctionDetectionStageRequest $request
     * @return JsonResponse
     */
    public function store(StoreMalfunctionDetectionStageRequest $request)
    {
        $validated = $request->validated();
        $malfunctionDetectionStage = MalfunctionDetectionStage::create($validated);
        return response()->json($malfunctionDetectionStage);
    }

    /**
     * Display the specified resource.
     *
     * @param MalfunctionDetectionStage $malfunctionDetectionStage
     * @return JsonResponse
     */
    public function show(MalfunctionDetectionStage $malfunctionDetectionStage)
    {
        return response()->json($malfunctionDetectionStage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMalfunctionDetectionStageRequest $request
     * @param MalfunctionDetectionStage $malfunctionDetectionStage
     * @return JsonResponse
     */
    public function update(UpdateMalfunctionDetectionStageRequest $request,
                           MalfunctionDetectionStage $malfunctionDetectionStage)
    {
        $validated = $request->validated();
        $malfunctionDetectionStage->fill($validated);
        $malfunctionDetectionStage->save();
        return response()->json($malfunctionDetectionStage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MalfunctionDetectionStage $malfunctionDetectionStage
     * @return JsonResponse
     */
    public function destroy(MalfunctionDetectionStage $malfunctionDetectionStage)
    {
        $malfunctionDetectionStage->delete();
        return response()->json(['id' => $malfunctionDetectionStage->id], 200);
    }
}
