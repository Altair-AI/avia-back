<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Post(
 *     path="/api/v1/tech/get-cases",
 *     summary="Получение прецедентов с оценкой",
 *     tags={"Машина вывода по прецедентам"},
 *     security={{ "bearerAuth": {} }},
 *     description="Инициализируется, когда пользователь (техник) на странице выбирает (или заполняет поля) коды неисправностей и нажимает на условную кнопку - Прецеденты.",
 *
 *     @OA\Parameter(
 *         description="id кода aвариийно‐сигнального сообщения",
 *         in="query",
 *         name="emrg_code",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id кода БСТО",
 *         in="query",
 *         name="bsto_code",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id кода сигнализации СЭИ",
 *         in="query",
 *         name="sei_code",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id кода локальной сигнализации",
 *         in="query",
 *         name="local_code",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id наблюдаемой неисправности",
 *         in="query",
 *         name="obs",
 *         required=false
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="code", type="integer", example=0),
 *             @OA\Property(property="message", type="string", example="Some message"),
 *             @OA\Property(property="data", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="malfunction_cause_name", type="string", example="Some name"),
 *                 @OA\Property(property="score", type="integer", example=1)
 *             ))
 *         )
 *     )
 * ),
 *
 * @OA\Post(
 *     path="/api/v1/tech/create-case",
 *     summary="Создание нового прецедента",
 *     tags={"Машина вывода по прецедентам"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="date", type="date", example="2024-02-02"),
 *                     @OA\Property(property="card_number", type="string", example="Some card number"),
 *                     @OA\Property(property="operation_time_from_start", type="integer", example=1000),
 *                     @OA\Property(property="operation_time_from_last_repair", type="integer", example=100),
 *                     @OA\Property(property="malfunction_detection_stage_id", type="integer", example=1),
 *                     @OA\Property(property="real_time_technical_system_id", type="integer", example=1),
 *                     @OA\Property(property="work_session_id", type="integer", example=1)
 *                 )
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="date", type="datetime", example="2024-02-02 01:10:48"),
 *             @OA\Property(property="card_number", type="string", example="Some card number"),
 *             @OA\Property(property="operation_time_from_start", type="integer", example=1000),
 *             @OA\Property(property="operation_time_from_last_repair", type="integer", example=100),
 *             @OA\Property(property="malfunction_detection_stage_id", type="integer", example=1),
 *             @OA\Property(property="malfunction_cause_id", type="integer", example=1),
 *             @OA\Property(property="system_id_for_repair", type="integer", example=1),
 *             @OA\Property(property="initial_completed_operation_id", type="integer", example=1),
 *             @OA\Property(property="case_based_knowledge_base_id", type="integer", example=1),
 *             @OA\Property(property="malfunction_code_cases", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="source", type="string", example="Some source"),
 *                 @OA\Property(property="alternative_name", type="string", example="Some alternative name"),
 *                 @OA\Property(property="technical_system_id", type="integer", example=1)
 *             )),
 *             @OA\Property(property="external_malfunction_signs", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name")
 *             )),
 *             @OA\Property(property="malfunction_consequences", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name")
 *             ))
 *         )
 *     )
 * )
 */
class CaseEngineController extends Controller
{
    //
}
