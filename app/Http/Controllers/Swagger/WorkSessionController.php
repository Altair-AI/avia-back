<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/v1/admin/work-sessions",
 *     summary="Получить список рабочих сессий",
 *     tags={"Рабочие сессии"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает список всех рабочих сессий, созданных в системе. Для администратора возвращает список только тех рабочих сессий пользователей, принадлежащих к той же организации, что и администратор. Список может быть отфильтрован по различным параметрам.",
 *
 *     @OA\Parameter(
 *         description="Статус рабочей сессии",
 *         in="query",
 *         name="status",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Дата и время последней остановки машины вывода",
 *         in="query",
 *         name="stop_time",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id правила для определения причины неисправности",
 *         in="query",
 *         name="malfunction_cause_rule_id",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id пользователя",
 *         in="query",
 *         name="user_id",
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
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="stop_time", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="malfunction_cause_rule_id", type="integer", example=1),
 *                 @OA\Property(property="user_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="user",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="email", type="string", example="Some email"),
 *                     @OA\Property(property="email_verified_at", type="string", example=null),
 *                     @OA\Property(property="role", type="integer", example=0),
 *                     @OA\Property(property="status", type="integer", example=0),
 *                     @OA\Property(property="full_name", type="string", example="Some full name"),
 *                     @OA\Property(property="last_login_date", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                     @OA\Property(property="login_ip", type="string", example="Some IP"),
 *                     @OA\Property(property="organization_id", type="integer", example=1),
 *                     @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                     @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
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
 *     path="/api/v1/admin/work-sessions",
 *     summary="Создание новой рабочей сессии",
 *     tags={"Рабочие сессии"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="status", type="integer", example=0),
 *                     @OA\Property(property="malfunction_cause_rule_id", type="integer", example=1),
 *                     @OA\Property(property="user_id", type="integer", example=2)
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
 *             @OA\Property(property="status", type="integer", example=0),
 *             @OA\Property(property="stop_time", type="datetime", example=null),
 *             @OA\Property(property="malfunction_cause_rule_id", type="integer", example=1),
 *             @OA\Property(property="user_id", type="integer", example=2),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="user",
 *                 @OA\Property(property="id", type="integer", example=2),
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
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/work-sessions/{work-session}",
 *     summary="Получить единичную рабочую сессию",
 *     tags={"Рабочие сессии"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает любую рабочую сессию. Для администратора возвращает рабочую сессию пользователя, принадлежащего к той же организации, что и администратор.",
 *
 *     @OA\Parameter(
 *         description="id рабочей сессии",
 *         in="path",
 *         name="work-session",
 *         required=true,
 *         example=1
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="status", type="integer", example=0),
 *             @OA\Property(property="stop_time", type="datetime", example=null),
 *             @OA\Property(property="malfunction_cause_rule_id", type="integer", example=1),
 *             @OA\Property(property="user_id", type="integer", example=2),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="user",
 *                 @OA\Property(property="id", type="integer", example=2),
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
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/v1/admin/work-sessions/{work-session}",
 *     summary="Обновить рабочую сессию",
 *     tags={"Рабочие сессии"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id рабочей сессии",
 *         in="path",
 *         name="work-session",
 *         required=true,
 *         example=2
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="status", type="integer", example=2),
 *                     @OA\Property(property="stop_time", type="datetime", example="2023-12-15T01:52:11.000000Z"),
 *                     @OA\Property(property="malfunction_cause_rule_id", type="integer", example=2),
 *                     @OA\Property(property="user_id", type="integer", example=3)
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
 *             @OA\Property(property="status", type="integer", example=2),
 *             @OA\Property(property="stop_time", type="datetime", example="2023-12-15T01:52:11.000000Z"),
 *             @OA\Property(property="malfunction_cause_rule_id", type="integer", example=2),
 *             @OA\Property(property="user_id", type="integer", example=3),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="user",
 *                 @OA\Property(property="id", type="integer", example=3),
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
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/v1/admin/work-sessions/{work-session}",
 *     summary="Удалить рабочую сессию",
 *     tags={"Рабочие сессии"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id рабочей сессии",
 *         in="path",
 *         name="work-session",
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
class WorkSessionController extends Controller
{
    //
}
