<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/v1/admin/technical-systems",
 *     summary="Получить список технических систем",
 *     tags={"Технические системы"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает список иерархий всех технических систем, созданных в системе. Для администратора возвращает список иерархий только тех технических систем, которые доступны в рамках проекта для той организации к которой принадлежит администратор. Список может быть отфильтрован по различным параметрам.",
 *
 *     @OA\Parameter(
 *         description="Код технической системы или объекта",
 *         in="query",
 *         name="code",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Название или часть названия технической системы или объекта",
 *         in="query",
 *         name="name",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id родительской технической системы",
 *         in="query",
 *         name="parent_technical_system_id",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Размер страницы пагинации",
 *         in="query",
 *         name="pageSize",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Номер страницы пагинации",
 *         in="query",
 *         name="page",
 *         required=false
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="parent_technical_system_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="technical_subsystems", type="array", @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=2),
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="parent_technical_system_id", type="integer", example=1),
 *                     @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                     @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                     @OA\Property(property="technical_subsystems", type="array", @OA\Items())
 *                 )),
 *                 @OA\Property(property="documents", type="array", @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="type", type="integer", example=0),
 *                     @OA\Property(property="version", type="string", example="Some version"),
 *                     @OA\Property(property="file", type="string", example="Some path to file"),
 *                     @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                     @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *                 )),
 *                 @OA\Property(property="rule_based_knowledge_bases", type="array", @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="status", type="integer", example=0),
 *                     @OA\Property(property="correctness", type="integer", example=0),
 *                     @OA\Property(property="author", type="integer", example=1),
 *                     @OA\Property(property="technical_system_id", type="integer", example=1),
 *                     @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                     @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *                 ))
 *             )),
 *             @OA\Property(property="page_current", type="integer", example=1),
 *             @OA\Property(property="page_total", type="integer", example=20),
 *             @OA\Property(property="page_size", type="integer", example=10)
 *         )
 *     )
 * ),
 *
 * @OA\Post(
 *     path="/api/v1/admin/technical-systems",
 *     summary="Создание новой технической системы или объекта",
 *     tags={"Технические системы"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="parent_technical_system_id", type="integer", example=1)
 *                 )
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=2),
 *             @OA\Property(property="code", type="string", example="Some code"),
 *             @OA\Property(property="name", type="string", example="Some name"),
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="parent_technical_system_id", type="integer", example=1),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/technical-systems/{technical-system}",
 *     summary="Получить единичную техническую систему или объект",
 *     tags={"Технические системы"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает любую техническую систему и иерархию всех ее дочерних подсистем и элементов. Для администратора возвращает техническую систему, включая иерархию всех ее дочерних подсистем и элементов, которая доступна в рамках проекта для той организации к которой принадлежит администратор.",
 *
 *     @OA\Parameter(
 *         description="id технической системы или объекта",
 *         in="path",
 *         name="technical-system",
 *         required=true,
 *         example=1
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="code", type="string", example="Some code"),
 *             @OA\Property(property="name", type="string", example="Some name"),
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="parent_technical_system_id", type="integer", example=1),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="technical_subsystems", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="parent_technical_system_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="technical_subsystems", type="array", @OA\Items())
 *             )),
 *             @OA\Property(property="documents", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="version", type="string", example="Some version"),
 *                 @OA\Property(property="file", type="string", example="Some path to file"),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             )),
 *             @OA\Property(property="rule_based_knowledge_bases", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="correctness", type="integer", example=0),
 *                 @OA\Property(property="author", type="integer", example=1),
 *                 @OA\Property(property="technical_system_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             ))
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/v1/admin/technical-systems/{technical-system}",
 *     summary="Обновить техническую систему или объект",
 *     tags={"Технические системы"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id технической системы или объекта",
 *         in="path",
 *         name="technical-system",
 *         required=true,
 *         example=2
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="code", type="string", example="Some code for edit"),
 *                     @OA\Property(property="name", type="string", example="Some name for edit"),
 *                     @OA\Property(property="description", type="string", example="Some description for edit"),
 *                     @OA\Property(property="parent_technical_system_id", type="integer", example=1)
 *                 )
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=2),
 *             @OA\Property(property="code", type="string", example="Some code"),
 *             @OA\Property(property="name", type="string", example="Some name"),
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="parent_technical_system_id", type="integer", example=1),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/v1/admin/technical-systems/{technical-system}",
 *     summary="Удалить техническую систему или объект",
 *     tags={"Технические системы"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id технической системы или объекта",
 *         in="path",
 *         name="technical-system",
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
class TechnicalSystemController extends Controller
{
    //
}
