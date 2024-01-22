<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/v1/admin/documents",
 *     summary="Получить список всех документов",
 *     tags={"Документы"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает список всех документов вместе со списком соответствующих технических систем, содержащихся в системе. Для администратора возвращает список только тех документов (включая список соответствующих технических систем) на технические системы, которые доступны в рамках проекта для той организации к которой принадлежит администратор.",
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(type="array", @OA\Items(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="code", type="string", example="Some code"),
 *             @OA\Property(property="name", type="string", example="Some name"),
 *             @OA\Property(property="type", type="integer", example=0),
 *             @OA\Property(property="version", type="string", example="Some version"),
 *             @OA\Property(property="file", type="string", example="Some path to file"),
 *             @OA\Property(property="technical_systems", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="parent_technical_system_id", type="integer", example=null)
 *             ))
 *         ))
 *     )
 * ),
 *
 * @OA\Post(
 *     path="/api/v1/admin/documents",
 *     summary="Создание нового документа",
 *     tags={"Документы"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="type", type="integer", example=0),
 *                     @OA\Property(property="version", type="string", example="Some version"),
 *                     @OA\Property(property="file", type="string", example="Some path to file")
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
 *             @OA\Property(property="code", type="string", example="Some code"),
 *             @OA\Property(property="name", type="string", example="Some name"),
 *             @OA\Property(property="type", type="integer", example=0),
 *             @OA\Property(property="version", type="string", example="Some version"),
 *             @OA\Property(property="file", type="string", example="Some path to file")
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/documents/{document}",
 *     summary="Получить единичный документ",
 *     tags={"Документы"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает любой документ вместе со списком соответствующих технических систем. Для администратора возвращает документ (включая список соответствующих технических систем) на технические системы, которые доступны в рамках проекта для той организации к которой принадлежит администратор.",
 *
 *     @OA\Parameter(
 *         description="id документа",
 *         in="path",
 *         name="document",
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
 *             @OA\Property(property="type", type="integer", example=0),
 *             @OA\Property(property="version", type="string", example="Some version"),
 *             @OA\Property(property="file", type="string", example="Some path to file"),
 *             @OA\Property(property="technical_systems", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="parent_technical_system_id", type="integer", example=null)
 *             ))
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/v1/admin/documents/{document}",
 *     summary="Обновить документ",
 *     tags={"Документы"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id документа",
 *         in="path",
 *         name="document",
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
 *                     @OA\Property(property="type", type="integer", example=1),
 *                     @OA\Property(property="version", type="string", example="Some version for edit"),
 *                     @OA\Property(property="file", type="string", example="Some filepath for edit")
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
 *             @OA\Property(property="code", type="string", example="Some code"),
 *             @OA\Property(property="name", type="string", example="Some name"),
 *             @OA\Property(property="type", type="integer", example=1),
 *             @OA\Property(property="version", type="string", example="Some version"),
 *             @OA\Property(property="file", type="string", example="Some path to file")
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/v1/admin/documents/{document}",
 *     summary="Удалить документ",
 *     tags={"Документы"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id документа",
 *         in="path",
 *         name="document",
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
class DocumentController extends Controller
{
    //
}
