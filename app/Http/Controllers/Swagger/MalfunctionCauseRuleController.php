<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/v1/admin/malfunction-cause-rules",
 *     summary="Получить список правил определения причины неисправности",
 *     tags={"Правила определения причины неисправности"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает список правил определения причины неисправности. Для администратора возвращает список только тех правил определения причины неисправности, принадлежащих базе знаний правил, которая доступна в рамках проекта для той организации к которой принадлежит администратор. Список может быть отфильтрован по различным параметрам.",

 *     @OA\Parameter(
 *         description="id документа",
 *         in="query",
 *         name="document_id",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id базы знаний правил",
 *         in="query",
 *         name="rule_based_knowledge_base_id",
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
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="document_id", type="integer", example=1),
 *                 @OA\Property(property="rule_based_knowledge_base_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="document",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="type", type="integer", example=0),
 *                     @OA\Property(property="version", type="string", example="Some version"),
 *                     @OA\Property(property="file", type="string", example="Some path to file"),
 *                     @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                     @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *                 ),
 *                 @OA\Property(property="rule_based_knowledge_base",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="status", type="integer", example=0),
 *                     @OA\Property(property="correctness", type="integer", example=0),
 *                     @OA\Property(property="author", type="integer", example=1),
 *                     @OA\Property(property="technical_system_id", type="integer", example=1),
 *                     @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                     @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *                 ),
 *                 @OA\Property(property="malfunction_causes", type="array", @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                     @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *                 )),
 *                 @OA\Property(property="malfunction_codes", type="array", @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="type", type="integer", example=0),
 *                     @OA\Property(property="source", type="string", example="Some source"),
 *                     @OA\Property(property="alternative_name", type="string", example="Some alternative name"),
 *                     @OA\Property(property="technical_system_id", type="integer", example=2),
 *                     @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                     @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *                 )),
 *                 @OA\Property(property="actions", type="object",
 *                     @OA\Property(property="technical_systems", type="array", @OA\Items(
 *                         @OA\Property(property="id", type="integer", example=1),
 *                         @OA\Property(property="code", type="string", example="Some code"),
 *                         @OA\Property(property="name", type="string", example="Some name"),
 *                         @OA\Property(property="description", type="string", example="Some description"),
 *                         @OA\Property(property="parent_technical_system_id", type="integer", example=1),
 *                         @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                         @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *                     )),
 *                     @OA\Property(property="operations", type="array", @OA\Items(
 *                         @OA\Property(property="id", type="integer", example=1),
 *                         @OA\Property(property="code", type="string", example="Some code"),
 *                         @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                         @OA\Property(property="verbal_name", type="string", example="Some verbal name"),
 *                         @OA\Property(property="description", type="string", example="Some description"),
 *                         @OA\Property(property="document_section", type="string", example="Some document section"),
 *                         @OA\Property(property="document_subsection", type="string", example="Some document subsection"),
 *                         @OA\Property(property="start_document_page", type="integer", example=100),
 *                         @OA\Property(property="end_document_page", type="integer", example=101),
 *                         @OA\Property(property="actual_document_page", type="integer", example=123),
 *                         @OA\Property(property="document_id", type="integer", example=1),
 *                         @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                         @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *                     ))
 *                 )
 *             )),
 *             @OA\Property(property="page_current", type="integer", example=1),
 *             @OA\Property(property="page_total", type="integer", example=20),
 *             @OA\Property(property="page_size", type="integer", example=10)
 *         )
 *     )
 * ),
 *
 * @OA\Post(
 *     path="/api/v1/admin/malfunction-cause-rules",
 *     summary="Создание нового правила определения причины неисправности",
 *     tags={"Правила определения причины неисправности"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="document_id", type="integer", example=1),
 *                     @OA\Property(property="rule_based_knowledge_base_id", type="integer", example=1)
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
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="document_id", type="integer", example=1),
 *             @OA\Property(property="rule_based_knowledge_base_id", type="integer", example=1),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/malfunction-cause-rules/{malfunction-cause-rule}",
 *     summary="Получить единичное правило определения причины неисправности",
 *     tags={"Правила определения причины неисправности"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает любое правило определения причины неисправности. Для администратора возвращает правило определения причины неисправности, которое принадлежит определенной базе знаний правил, которая доступна в рамках проекта для той организации к которой принадлежит администратор.",
 *
 *     @OA\Parameter(
 *         description="id правила определения причины неисправности",
 *         in="path",
 *         name="malfunction-cause-rule",
 *         required=true,
 *         example=1
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="document_id", type="integer", example=1),
 *             @OA\Property(property="rule_based_knowledge_base_id", type="integer", example=1),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="document",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="version", type="string", example="Some version"),
 *                 @OA\Property(property="file", type="string", example="Some path to file"),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             ),
 *             @OA\Property(property="rule_based_knowledge_base",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="correctness", type="integer", example=0),
 *                 @OA\Property(property="author", type="integer", example=1),
 *                 @OA\Property(property="technical_system_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             ),
 *             @OA\Property(property="malfunction_causes", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             )),
 *             @OA\Property(property="malfunction_codes", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="source", type="string", example="Some source"),
 *                 @OA\Property(property="alternative_name", type="string", example="Some alternative name"),
 *                 @OA\Property(property="technical_system_id", type="integer", example=2),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             )),
 *             @OA\Property(property="actions", type="object",
 *                 @OA\Property(property="technical_systems", type="array", @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="parent_technical_system_id", type="integer", example=1),
 *                     @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                     @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *                 )),
 *                 @OA\Property(property="operations", type="array", @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                     @OA\Property(property="verbal_name", type="string", example="Some verbal name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="document_section", type="string", example="Some document section"),
 *                     @OA\Property(property="document_subsection", type="string", example="Some document subsection"),
 *                     @OA\Property(property="start_document_page", type="integer", example=100),
 *                     @OA\Property(property="end_document_page", type="integer", example=101),
 *                     @OA\Property(property="actual_document_page", type="integer", example=123),
 *                     @OA\Property(property="document_id", type="integer", example=1),
 *                     @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                     @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *                 ))
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/v1/admin/malfunction-cause-rules/{malfunction-cause-rule}",
 *     summary="Обновить правило определения причины неисправности",
 *     tags={"Правила определения причины неисправности"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id правила определения причины неисправности",
 *         in="path",
 *         name="malfunction-cause-rule",
 *         required=true,
 *         example=1
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="description", type="string", example="Some description for edit"),
 *                     @OA\Property(property="document_id", type="integer", example=2),
 *                     @OA\Property(property="rule_based_knowledge_base_id", type="integer", example=2)
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
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="document_id", type="integer", example=2),
 *             @OA\Property(property="rule_based_knowledge_base_id", type="integer", example=2),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="document",
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="version", type="string", example="Some version"),
 *                 @OA\Property(property="file", type="string", example="Some path to file"),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             ),
 *             @OA\Property(property="rule_based_knowledge_base",
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="correctness", type="integer", example=0),
 *                 @OA\Property(property="author", type="integer", example=1),
 *                 @OA\Property(property="technical_system_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/v1/admin/malfunction-cause-rules/{malfunction-cause-rule}",
 *     summary="Удалить правило определения причины неисправности",
 *     tags={"Правила определения причины неисправности"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id правила определения причины неисправности",
 *         in="path",
 *         name="malfunction-cause-rule",
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
class MalfunctionCauseRuleController extends Controller
{
    //
}
