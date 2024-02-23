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
 *                 @OA\Property(property="score", type="integer", example=0)
 *             ))
 *         )
 *     )
 * )
 */
class CaseEngineController extends Controller
{
    //
}
