<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/v1/admin/malfunction-codes/list",
 *     summary="Получить полный список кодов (признаков) неисправности только с важными полями",
 *     tags={"Коды неисправности"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает полный список всех кодов (признаков) неисправности, созданных в системе. Для администратора возвращает полный список только тех кодов (признаков) неисправности, которые доступны в рамках проекта для той организации к которой принадлежит администратор.",
 *
 *     @OA\Parameter(
 *         description="Тип кода (признака) неисправности",
 *         in="query",
 *         name="type",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id технической системы или объекта",
 *         in="query",
 *         name="technical_system_id",
 *         required=false
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(type="array", @OA\Items(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Some name"),
 *             @OA\Property(property="type", type="integer", example=0)
 *         ))
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/malfunction-codes",
 *     summary="Получить список кодов (признаков) неисправности",
 *     tags={"Коды неисправности"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает список всех кодов (признаков) неисправности, созданных в системе. Для администратора возвращает список только тех кодов (признаков) неисправности, которые доступны в рамках проекта для той организации к которой принадлежит администратор.",
 *
 *     @OA\Parameter(
 *         description="Название кода (признака) неисправности",
 *         in="query",
 *         name="name",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Тип кода (признака) неисправности",
 *         in="query",
 *         name="type",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Источник кода (признака) неисправности",
 *         in="query",
 *         name="source",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Альтернативное название кода (признака) неисправности",
 *         in="query",
 *         name="alternative_name",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id технической системы или объекта",
 *         in="query",
 *         name="technical_system_id",
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
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="source", type="string", example="Some source"),
 *                 @OA\Property(property="alternative_name", type="string", example="Some alternative name"),
 *                 @OA\Property(property="technical_system_id", type="integer", example=1)
 *             )),
 *             @OA\Property(property="page_current", type="integer", example=1),
 *             @OA\Property(property="page_total", type="integer", example=20),
 *             @OA\Property(property="page_size", type="integer", example=10)
 *         )
 *     )
 * ),
 *
 * @OA\Post(
 *     path="/api/v1/admin/malfunction-codes",
 *     summary="Создание нового кода (признака) неисправности",
 *     tags={"Коды неисправности"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="type", type="integer", example=0),
 *                     @OA\Property(property="source", type="string", example="Some source"),
 *                     @OA\Property(property="alternative_name", type="string", example="Some alternative name"),
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
 *             @OA\Property(property="type", type="integer", example=0),
 *             @OA\Property(property="source", type="string", example="Some source"),
 *             @OA\Property(property="alternative_name", type="string", example="Some alternative name"),
 *             @OA\Property(property="technical_system_id", type="integer", example=1)
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/malfunction-codes/{malfunction-code}",
 *     summary="Получить единичный код (признак) неисправности",
 *     tags={"Коды неисправности"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает любой код (признак) неисправности. Для администратора возвращает код (признак) неисправности, который доступен в рамках проекта для той организации к которой принадлежит администратор.",
 *
 *     @OA\Parameter(
 *         description="id кода (признака) неисправности",
 *         in="path",
 *         name="malfunction-code",
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
 *             @OA\Property(property="type", type="integer", example=0),
 *             @OA\Property(property="source", type="string", example="Some source"),
 *             @OA\Property(property="alternative_name", type="string", example="Some alternative name"),
 *             @OA\Property(property="technical_system_id", type="integer", example=1)
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/v1/admin/malfunction-codes/{malfunction-code}",
 *     summary="Обновить код (признак) неисправности",
 *     tags={"Коды неисправности"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id кода (признака) неисправности",
 *         in="path",
 *         name="malfunction-code",
 *         required=true,
 *         example=2
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Some name for edit"),
 *                     @OA\Property(property="type", type="integer", example=1),
 *                     @OA\Property(property="source", type="string", example="Some source for edit"),
 *                     @OA\Property(property="alternative_name", type="string", example="Some alternative name for edit"),
 *                     @OA\Property(property="technical_system_id", type="integer", example=2)
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
 *             @OA\Property(property="type", type="integer", example=1),
 *             @OA\Property(property="source", type="string", example="Some source"),
 *             @OA\Property(property="alternative_name", type="string", example="Some alternative name"),
 *             @OA\Property(property="technical_system_id", type="integer", example=2)
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/v1/admin/malfunction-codes/{malfunction-code}",
 *     summary="Удалить код (признак) неисправности",
 *     tags={"Коды неисправности"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id кода (признака) неисправности",
 *         in="path",
 *         name="malfunction-code",
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
class MalfunctionCodeController extends Controller
{
    //
}
