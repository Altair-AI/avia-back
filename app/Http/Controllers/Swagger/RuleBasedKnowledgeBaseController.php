<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/v1/admin/rule-based-knowledge-bases",
 *     summary="Получить список всех баз знаний правил",
 *     tags={"Базы знаний правил"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает список всех баз знаний с правилами, созданных в системе. Для администратора возвращает базы знаний с правилами для технических систем с проектами, которые доступны по лицензии для организации к которой принадлежит администратор.",
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(type="array", @OA\Items(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Some name"),
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="status", type="integer", example=0),
 *             @OA\Property(property="correctness", type="integer", example=0),
 *             @OA\Property(property="author", type="integer", example=1),
 *             @OA\Property(property="technical_system_id", type="integer", example=1),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="user",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="email", type="string", example="Some email"),
 *                 @OA\Property(property="email_verified_at", type="string", example=null),
 *                 @OA\Property(property="role", type="integer", example=0),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="full_name", type="string", example="Some full name"),
 *                 @OA\Property(property="last_login_date", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="login_ip", type="string", example="Some IP"),
 *                 @OA\Property(property="organization_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             ),
 *             @OA\Property(property="technical_system",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="parent_technical_system_id", type="integer", example=null),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             )
 *         ))
 *     )
 * ),
 *
 * @OA\Post(
 *     path="/api/v1/admin/rule-based-knowledge-bases",
 *     summary="Создание новой базы знаний правил",
 *     tags={"Базы знаний правил"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="status", type="integer", example=0),
 *                     @OA\Property(property="correctness", type="integer", example=0),
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
 *             @OA\Property(property="status", type="integer", example=0),
 *             @OA\Property(property="correctness", type="integer", example=0),
 *             @OA\Property(property="author", type="integer", example=1),
 *             @OA\Property(property="technical_system_id", type="integer", example=1),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="user",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="email", type="string", example="Some email"),
 *                 @OA\Property(property="email_verified_at", type="string", example=null),
 *                 @OA\Property(property="role", type="integer", example=0),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="full_name", type="string", example="Some full name"),
 *                 @OA\Property(property="last_login_date", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="login_ip", type="string", example="Some IP"),
 *                 @OA\Property(property="organization_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             ),
 *             @OA\Property(property="technical_system",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="parent_technical_system_id", type="integer", example=null),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/rule-based-knowledge-bases/{rule-based-knowledge-base}",
 *     summary="Получить единичную базу знаний правил",
 *     tags={"Базы знаний правил"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает любую базу знаний с правилами, созданную в системе. Для администратора возвращает базу знаний с правилами для технической системы с проектом, который доступен по лицензии для организации к которой принадлежит администратор.",
 *
 *     @OA\Parameter(
 *         description="id базы знаний правил",
 *         in="path",
 *         name="rule-based-knowledge-base",
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
 *             @OA\Property(property="status", type="integer", example=0),
 *             @OA\Property(property="correctness", type="integer", example=0),
 *             @OA\Property(property="author", type="integer", example=1),
 *             @OA\Property(property="technical_system_id", type="integer", example=1),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="user",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="email", type="string", example="Some email"),
 *                 @OA\Property(property="email_verified_at", type="string", example=null),
 *                 @OA\Property(property="role", type="integer", example=0),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="full_name", type="string", example="Some full name"),
 *                 @OA\Property(property="last_login_date", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="login_ip", type="string", example="Some IP"),
 *                 @OA\Property(property="organization_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             ),
 *             @OA\Property(property="technical_system",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="parent_technical_system_id", type="integer", example=null),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/v1/admin/rule-based-knowledge-bases/{rule-based-knowledge-base}",
 *     summary="Обновить базу знаний правил",
 *     tags={"Базы знаний правил"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id базы знаний правил",
 *         in="path",
 *         name="rule-based-knowledge-base",
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
 *                     @OA\Property(property="status", type="integer", example=0),
 *                     @OA\Property(property="correctness", type="integer", example=0),
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
 *             @OA\Property(property="status", type="integer", example=0),
 *             @OA\Property(property="correctness", type="integer", example=0),
 *             @OA\Property(property="author", type="integer", example=1),
 *             @OA\Property(property="technical_system_id", type="integer", example=1),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="user",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="email", type="string", example="Some email"),
 *                 @OA\Property(property="email_verified_at", type="string", example=null),
 *                 @OA\Property(property="role", type="integer", example=0),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="full_name", type="string", example="Some full name"),
 *                 @OA\Property(property="last_login_date", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="login_ip", type="string", example="Some IP"),
 *                 @OA\Property(property="organization_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             ),
 *             @OA\Property(property="technical_system",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="parent_technical_system_id", type="integer", example=null),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/v1/admin/rule-based-knowledge-bases/{rule-based-knowledge-base}",
 *     summary="Удалить базу знаний правил",
 *     tags={"Базы знаний правил"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id базы знаний правил",
 *         in="path",
 *         name="rule-based-knowledge-base",
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
class RuleBasedKnowledgeBaseController extends Controller
{
    //
}
