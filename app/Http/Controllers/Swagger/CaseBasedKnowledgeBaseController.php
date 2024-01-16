<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/v1/admin/case-based-knowledge-bases",
 *     summary="Получить список всех баз знаний прецедентов",
 *     tags={"Базы знаний прецедентов"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает список всех баз знаний с прецедентами, созданных в системе. Для администратора возвращает базы знаний прецедентов, доступных в рамках проекта к которому принадлежит администратор. Для техника возвращает список только тех баз знаний прецедентов, доступ к которым установил администратор в рамках определенной технической системы реального времени.",
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
 *             @OA\Property(property="real_time_technical_system_id", type="integer", example=1),
 *             @OA\Property(property="project_id", type="integer", example=1),
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
 *             @OA\Property(property="real_time_technical_system",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="registration_code", type="string", example="Some registration code"),
 *                 @OA\Property(property="registration_description", type="string", example="Some description"),
 *                 @OA\Property(property="operation_time_from_start", type="integer", example=10),
 *                 @OA\Property(property="operation_time_from_last_repair", type="integer", example=100),
 *                 @OA\Property(property="technical_system_id", type="integer", example=1),
 *                 @OA\Property(property="project_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             ),
 *             @OA\Property(property="project",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="technical_system_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             )
 *         ))
 *     )
 * ),
 *
 * @OA\Post(
 *     path="/api/v1/admin/case-based-knowledge-bases",
 *     summary="Создание новой базы знаний прецедентов",
 *     tags={"Базы знаний прецедентов"},
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
 *                     @OA\Property(property="real_time_technical_system_id", type="integer", example=1),
 *                     @OA\Property(property="project_id", type="integer", example=1)
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
 *             @OA\Property(property="real_time_technical_system_id", type="integer", example=1),
 *             @OA\Property(property="project_id", type="integer", example=1),
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
 *             @OA\Property(property="real_time_technical_system",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="registration_code", type="string", example="Some registration code"),
 *                 @OA\Property(property="registration_description", type="string", example="Some description"),
 *                 @OA\Property(property="operation_time_from_start", type="integer", example=10),
 *                 @OA\Property(property="operation_time_from_last_repair", type="integer", example=100),
 *                 @OA\Property(property="technical_system_id", type="integer", example=1),
 *                 @OA\Property(property="project_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             ),
 *             @OA\Property(property="project",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="technical_system_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/case-based-knowledge-bases/{case-based-knowledge-base}",
 *     summary="Получить единичную базу знаний прецедентов",
 *     tags={"Базы знаний прецедентов"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает любую базу знаний прецедентов, созданную в системе. Для администратора возвращает базу знаний прецедентов, доступную в рамках проекта к которому принадлежит администратор. Для техника возвращает базу знаний прецедентов, доступ к которой установил администратор в рамках определенной технической системы реального времени.",
 *
 *     @OA\Parameter(
 *         description="id базы знаний прецедентов",
 *         in="path",
 *         name="case-based-knowledge-base",
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
 *             @OA\Property(property="real_time_technical_system_id", type="integer", example=1),
 *             @OA\Property(property="project_id", type="integer", example=1),
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
 *             @OA\Property(property="real_time_technical_system",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="registration_code", type="string", example="Some registration code"),
 *                 @OA\Property(property="registration_description", type="string", example="Some description"),
 *                 @OA\Property(property="operation_time_from_start", type="integer", example=10),
 *                 @OA\Property(property="operation_time_from_last_repair", type="integer", example=100),
 *                 @OA\Property(property="technical_system_id", type="integer", example=1),
 *                 @OA\Property(property="project_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             ),
 *             @OA\Property(property="project",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="technical_system_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/v1/admin/case-based-knowledge-bases/{case-based-knowledge-base}",
 *     summary="Обновить базу знаний прецедентов",
 *     tags={"Базы знаний прецедентов"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id базы знаний прецедентов",
 *         in="path",
 *         name="case-based-knowledge-base",
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
 *                     @OA\Property(property="status", type="integer", example=1),
 *                     @OA\Property(property="correctness", type="integer", example=1),
 *                     @OA\Property(property="real_time_technical_system_id", type="integer", example=2),
 *                     @OA\Property(property="project_id", type="integer", example=2)
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
 *             @OA\Property(property="status", type="integer", example=1),
 *             @OA\Property(property="correctness", type="integer", example=1),
 *             @OA\Property(property="author", type="integer", example=1),
 *             @OA\Property(property="real_time_technical_system_id", type="integer", example=2),
 *             @OA\Property(property="project_id", type="integer", example=2),
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
 *             @OA\Property(property="real_time_technical_system",
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="registration_code", type="string", example="Some registration code"),
 *                 @OA\Property(property="registration_description", type="string", example="Some description"),
 *                 @OA\Property(property="operation_time_from_start", type="integer", example=20),
 *                 @OA\Property(property="operation_time_from_last_repair", type="integer", example=200),
 *                 @OA\Property(property="technical_system_id", type="integer", example=2),
 *                 @OA\Property(property="project_id", type="integer", example=2),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             ),
 *             @OA\Property(property="project",
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="technical_system_id", type="integer", example=2),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/v1/admin/case-based-knowledge-bases/{case-based-knowledge-base}",
 *     summary="Удалить базу знаний прецедентов",
 *     tags={"Базы знаний прецедентов"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id базы знаний прецедентов",
 *         in="path",
 *         name="case-based-knowledge-base",
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
class CaseBasedKnowledgeBaseController extends Controller
{
    //
}
