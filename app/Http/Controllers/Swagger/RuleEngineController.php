<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Post(
 *     path="/api/v1/tech/define-malfunction-causes",
 *     summary="Определение причин неисправности",
 *     tags={"Машина вывода по правилам"},
 *     security={{ "bearerAuth": {} }},
 *     description="Инициализируется, когда пользователь (техник) на странице выбирает (или заполняет поля) коды неисправностей и нажимает на условную кнопку - Определить причины неисправности.",
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
 *             @OA\Property(property="data",
 *                 @OA\Property(property="failed_technical_system",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="parent_technical_system_id", type="integer", example=null)
 *                 ),
 *                 @OA\Property(property="malfunction_causes", type="array", @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="priority", type="integer", example=100)
 *                 )),
 *                 @OA\Property(property="work_session",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="status", type="integer", example=0),
 *                     @OA\Property(property="stop_time", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                     @OA\Property(property="malfunction_cause_rule_id", type="integer", example=1),
 *                     @OA\Property(property="user_id", type="integer", example=1)
 *                 )
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Post(
 *     path="/api/v1/tech/troubleshooting",
 *     summary="Устранение неисправности",
 *     tags={"Машина вывода по правилам"},
 *     security={{ "bearerAuth": {} }},
 *     description="Инициализируется, когда пользователь (техник) на странице нажимает условную кнопку - Начать устранять неисправность.",
 *
 *     @OA\Parameter(
 *         description="id рабочей сессии",
 *         in="query",
 *         name="work_session",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="статус работы",
 *         in="query",
 *         name="operation_status",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id результата работы",
 *         in="query",
 *         name="operation_result",
 *         required=false
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="code", type="integer", example=0),
 *             @OA\Property(property="message", type="string", example="Some message"),
 *             @OA\Property(property="data",
 *                 @OA\Property(property="chain_operations", type="array", @OA\Items(
 *                     @OA\Property(property="name", type="string", example="Some name")
 *                 )),
 *                 @OA\Property(property="current_operation",
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                 ),
 *                 @OA\Property(property="operation_results", type="array", @OA\Items(
 *                      @OA\Property(property="id", type="integer", example=1),
 *                      @OA\Property(property="name", type="string", example="Some name")
 *                 )),
 *                 @OA\Property(property="completed_operations", type="array", @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="status", type="integer", example=2),
 *                     @OA\Property(property="result",
 *                         @OA\Property(property="id", type="integer", example=1),
 *                         @OA\Property(property="name", type="string", example="Some name")
 *                     ),
 *                     @OA\Property(property="sub_operations", type="array", @OA\Items())
 *                 ))
 *             )
 *         )
 *     )
 * )
 */
class RuleEngineController extends Controller
{
    //
}
