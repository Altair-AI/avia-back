<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/v1/admin/malfunction-detection-stages",
 *     summary="Получить список всех этапов обнаружения неисправности",
 *     tags={"Этапы обнаружения неисправности"},
 *     security={{ "bearerAuth": {} }},
 *     description="Возвращает список всех этапов обнаружения неисправности, созданных в системе (доступно всем зарегистрированным пользователям).",
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(type="array", @OA\Items(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Some name"),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *         ))
 *     )
 * ),
 *
 * @OA\Post(
 *     path="/api/v1/admin/malfunction-detection-stages",
 *     summary="Создание нового этапа обнаружения неисправности",
 *     tags={"Этапы обнаружения неисправности"},
 *     security={{ "bearerAuth": {} }},
 *     description="Создание нового этапа обнаружения неисправности доступно только супер-администратору.",
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Some name")
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
 *             @OA\Property(property="name", type="string", example="Some name"),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/malfunction-detection-stages/{malfunction-detection-stage}",
 *     summary="Получить единичный этап обнаружения неисправности",
 *     tags={"Этапы обнаружения неисправности"},
 *     security={{ "bearerAuth": {} }},
 *     description="Возвращает этап обнаружения неисправности (доступно всем зарегистрированным пользователям).",
 *
 *     @OA\Parameter(
 *         description="id этапа обнаружения неисправности",
 *         in="path",
 *         name="malfunction-detection-stage",
 *         required=true,
 *         example=1
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Some name"),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/v1/admin/malfunction-detection-stages/{malfunction-detection-stage}",
 *     summary="Обновить этап обнаружения неисправности",
 *     tags={"Этапы обнаружения неисправности"},
 *     security={{ "bearerAuth": {} }},
 *     description="Обновление данных этапа обнаружения неисправности доступно только супер-администратору.",
 *
 *     @OA\Parameter(
 *         description="id этапа обнаружения неисправности",
 *         in="path",
 *         name="malfunction-detection-stage",
 *         required=true,
 *         example=1
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Some name for edit")
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
 *             @OA\Property(property="name", type="string", example="Some name"),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/v1/admin/malfunction-detection-stages/{malfunction-detection-stage}",
 *     summary="Удалить этап обнаружения неисправности",
 *     tags={"Этапы обнаружения неисправности"},
 *     security={{ "bearerAuth": {} }},
 *     description="Удаление этапа обнаружения неисправности доступно только супер-администратору.",
 *
 *     @OA\Parameter(
 *         description="id этапа обнаружения неисправности",
 *         in="path",
 *         name="malfunction-detection-stage",
 *         required=true,
 *         example=1
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1)
 *         )
 *     )
 * )
 */
class MalfunctionDetectionStageController extends Controller
{
    //
}
