<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/v1/admin/projects",
 *     summary="Получить список всех проектов",
 *     tags={"Проекты"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает список всех проектов, созданных в системе. Для администратора возвращает все проекты, которые доступны по лицензии для организации к которой принадлежит администратор.",
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(type="array", @OA\Items(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Some name"),
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="type", type="integer", example=0),
 *             @OA\Property(property="status", type="integer", example=0),
 *             @OA\Property(property="technical_system_id", type="integer", example=1),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *         ))
 *     )
 * ),
 *
 * @OA\Post(
 *     path="/api/v1/admin/projects",
 *     summary="Создание нового проекта",
 *     tags={"Проекты"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="type", type="integer", example=0),
 *                     @OA\Property(property="status", type="integer", example=0),
 *                     @OA\Property(property="technical_system_id", type="integer", example=1)
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
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="type", type="integer", example=0),
 *             @OA\Property(property="status", type="integer", example=0),
 *             @OA\Property(property="technical_system_id", type="integer", example=1),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/projects/{project}",
 *     summary="Получить единичный проект",
 *     tags={"Проекты"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает любой проект, созданный в системе. Для администратора возвращает только тот проект, который доступен по лицензии для организации к которой принадлежит администратор.",
 *
 *     @OA\Parameter(
 *         description="id проекта",
 *         in="path",
 *         name="project",
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
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="type", type="integer", example=0),
 *             @OA\Property(property="status", type="integer", example=0),
 *             @OA\Property(property="technical_system_id", type="integer", example=1),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/v1/admin/projects/{project}",
 *     summary="Обновить проект",
 *     tags={"Проекты"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id проекта",
 *         in="path",
 *         name="project",
 *         required=true,
 *         example=1
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Some name for edit"),
 *                     @OA\Property(property="description", type="string", example="Some description for edit"),
 *                     @OA\Property(property="type", type="integer", example=0),
 *                     @OA\Property(property="status", type="integer", example=0),
 *                     @OA\Property(property="technical_system_id", type="integer", example=1)
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
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="type", type="integer", example=0),
 *             @OA\Property(property="status", type="integer", example=0),
 *             @OA\Property(property="technical_system_id", type="integer", example=1),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/v1/admin/projects/{project}",
 *     summary="Удалить проект",
 *     tags={"Проекты"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id проекта",
 *         in="path",
 *         name="project",
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
class ProjectController extends Controller
{
    //
}
