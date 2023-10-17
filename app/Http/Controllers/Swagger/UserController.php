<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/v1/admin/users",
 *     summary="Получить список всех пользователей",
 *     tags={"Пользователи"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(type="array", @OA\Items(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Some name"),
 *             @OA\Property(property="email", type="string", example="Some email"),
 *             @OA\Property(property="password", type="string", example="Some password"),
 *             @OA\Property(property="role", type="integer", example=0),
 *             @OA\Property(property="status", type="integer", example=0),
 *             @OA\Property(property="full_name", type="string", example="Some full name"),
 *             @OA\Property(property="last_login_date", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="login_ip", type="string", example="Some IP"),
 *             @OA\Property(property="organization_id", type="integer", example=1),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="organization", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="actual_address", type="string", example="Some actual address"),
 *                 @OA\Property(property="legal_address", type="string", example="Some legal address"),
 *                 @OA\Property(property="phone", type="string", example="Some phone"),
 *                 @OA\Property(property="tin", type="string", example="Some tin"),
 *                 @OA\Property(property="rboc", type="string", example="Some rboc"),
 *                 @OA\Property(property="psrn", type="string", example="Some psrn"),
 *                 @OA\Property(property="bank_account", type="string", example="Some bank account"),
 *                 @OA\Property(property="bank_name", type="string", example="Some bank name"),
 *                 @OA\Property(property="bik", type="string", example="Some bik"),
 *                 @OA\Property(property="correspondent_account", type="string", example="Some correspondent account"),
 *                 @OA\Property(property="full_director_name", type="string", example="Some full director name"),
 *                 @OA\Property(property="treaty_number", type="string", example="Some treaty number"),
 *                 @OA\Property(property="treaty_date", type="datetime", example="2023-10-16 07:09:30"),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             )
 *         ))
 *     )
 * ),
 *
 * @OA\Post(
 *     path="/api/v1/admin/users",
 *     summary="Создание нового пользователя",
 *     tags={"Пользователи"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="email", type="string", example="Some email"),
 *                     @OA\Property(property="password", type="string", example="Some password"),
 *                     @OA\Property(property="password_confirmation", type="string", example="Password confirmation"),
 *                     @OA\Property(property="role", type="integer", example=0),
 *                     @OA\Property(property="status", type="integer", example=0),
 *                     @OA\Property(property="organization_id", type="integer", example=1)
 *                 )
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="New user (technician) successfully registered."),
 *             @OA\Property(property="user", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="email", type="string", example="Some email"),
 *                 @OA\Property(property="password", type="string", example="Some password"),
 *                 @OA\Property(property="role", type="integer", example=0),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="full_name", type="string", example="Some full name"),
 *                 @OA\Property(property="last_login_date", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="login_ip", type="string", example="Some IP"),
 *                 @OA\Property(property="organization_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="organization", type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="actual_address", type="string", example="Some actual address"),
 *                     @OA\Property(property="legal_address", type="string", example="Some legal address"),
 *                     @OA\Property(property="phone", type="string", example="Some phone"),
 *                     @OA\Property(property="tin", type="string", example="Some tin"),
 *                     @OA\Property(property="rboc", type="string", example="Some rboc"),
 *                     @OA\Property(property="psrn", type="string", example="Some psrn"),
 *                     @OA\Property(property="bank_account", type="string", example="Some bank account"),
 *                     @OA\Property(property="bank_name", type="string", example="Some bank name"),
 *                     @OA\Property(property="bik", type="string", example="Some bik"),
 *                     @OA\Property(property="correspondent_account", type="string", example="Some correspondent account"),
 *                     @OA\Property(property="full_director_name", type="string", example="Some full director name"),
 *                     @OA\Property(property="treaty_number", type="string", example="Some treaty number"),
 *                     @OA\Property(property="treaty_date", type="datetime", example="2023-10-16 07:09:30"),
 *                     @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                     @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *                 )
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/users/{user}",
 *     summary="Получить данные пользователя",
 *     tags={"Пользователи"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id пользователя",
 *         in="path",
 *         name="user",
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
 *             @OA\Property(property="email", type="string", example="Some email"),
 *             @OA\Property(property="password", type="string", example="Some password"),
 *             @OA\Property(property="role", type="integer", example=0),
 *             @OA\Property(property="status", type="integer", example=0),
 *             @OA\Property(property="full_name", type="string", example="Some full name"),
 *             @OA\Property(property="last_login_date", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="login_ip", type="string", example="Some IP"),
 *             @OA\Property(property="organization_id", type="integer", example=1),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="organization", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="actual_address", type="string", example="Some actual address"),
 *                 @OA\Property(property="legal_address", type="string", example="Some legal address"),
 *                 @OA\Property(property="phone", type="string", example="Some phone"),
 *                 @OA\Property(property="tin", type="string", example="Some tin"),
 *                 @OA\Property(property="rboc", type="string", example="Some rboc"),
 *                 @OA\Property(property="psrn", type="string", example="Some psrn"),
 *                 @OA\Property(property="bank_account", type="string", example="Some bank account"),
 *                 @OA\Property(property="bank_name", type="string", example="Some bank name"),
 *                 @OA\Property(property="bik", type="string", example="Some bik"),
 *                 @OA\Property(property="correspondent_account", type="string", example="Some correspondent account"),
 *                 @OA\Property(property="full_director_name", type="string", example="Some full director name"),
 *                 @OA\Property(property="treaty_number", type="string", example="Some treaty number"),
 *                 @OA\Property(property="treaty_date", type="datetime", example="2023-10-16 07:09:30"),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/v1/admin/users/{user}",
 *     summary="Обновить пользователя",
 *     tags={"Пользователи"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id пользователя",
 *         in="path",
 *         name="user",
 *         required=true,
 *         example=1
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Some name for edit"),
 *                     @OA\Property(property="email", type="string", example="Some email for edit"),
 *                     @OA\Property(property="password", type="string", example="Some password for edit"),
 *                     @OA\Property(property="password_confirmation", type="string", example="Password confirmation for edit"),
 *                     @OA\Property(property="role", type="integer", example=0),
 *                     @OA\Property(property="status", type="integer", example=0),
 *                     @OA\Property(property="full_name", type="string", example="Some full name for edit"),
 *                     @OA\Property(property="organization_id", type="integer", example=1)
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
 *             @OA\Property(property="email", type="string", example="Some email"),
 *             @OA\Property(property="password", type="string", example="Some password"),
 *             @OA\Property(property="role", type="integer", example=0),
 *             @OA\Property(property="status", type="integer", example=0),
 *             @OA\Property(property="full_name", type="string", example="Some full name"),
 *             @OA\Property(property="last_login_date", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="login_ip", type="string", example="Some IP"),
 *             @OA\Property(property="organization_id", type="integer", example=1),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="organization", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="actual_address", type="string", example="Some actual address"),
 *                 @OA\Property(property="legal_address", type="string", example="Some legal address"),
 *                 @OA\Property(property="phone", type="string", example="Some phone"),
 *                 @OA\Property(property="tin", type="string", example="Some tin"),
 *                 @OA\Property(property="rboc", type="string", example="Some rboc"),
 *                 @OA\Property(property="psrn", type="string", example="Some psrn"),
 *                 @OA\Property(property="bank_account", type="string", example="Some bank account"),
 *                 @OA\Property(property="bank_name", type="string", example="Some bank name"),
 *                 @OA\Property(property="bik", type="string", example="Some bik"),
 *                 @OA\Property(property="correspondent_account", type="string", example="Some correspondent account"),
 *                 @OA\Property(property="full_director_name", type="string", example="Some full director name"),
 *                 @OA\Property(property="treaty_number", type="string", example="Some treaty number"),
 *                 @OA\Property(property="treaty_date", type="datetime", example="2023-10-16 07:09:30"),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/v1/admin/users/{user}",
 *     summary="Удалить пользователя",
 *     tags={"Пользователи"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id пользователя",
 *         in="path",
 *         name="user",
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
 * ),
 *
 * @OA\Post(
 *     path="/api/v1/admin/users/register-technician",
 *     summary="Регистрация техника",
 *     tags={"Пользователи"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="email", type="string", example="Some email"),
 *                     @OA\Property(property="password", type="string", example="Some password"),
 *                     @OA\Property(property="password_confirmation", type="string", example="Password confirmation")
 *                 )
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="New user (technician) successfully registered."),
 *             @OA\Property(property="user", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="email", type="string", example="Some email"),
 *                 @OA\Property(property="password", type="string", example="Some password"),
 *                 @OA\Property(property="role", type="integer", example=0),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="full_name", type="string", example="Some full name"),
 *                 @OA\Property(property="last_login_date", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="login_ip", type="string", example="Some IP"),
 *                 @OA\Property(property="organization_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                 @OA\Property(property="organization", type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="actual_address", type="string", example="Some actual address"),
 *                     @OA\Property(property="legal_address", type="string", example="Some legal address"),
 *                     @OA\Property(property="phone", type="string", example="Some phone"),
 *                     @OA\Property(property="tin", type="string", example="Some tin"),
 *                     @OA\Property(property="rboc", type="string", example="Some rboc"),
 *                     @OA\Property(property="psrn", type="string", example="Some psrn"),
 *                     @OA\Property(property="bank_account", type="string", example="Some bank account"),
 *                     @OA\Property(property="bank_name", type="string", example="Some bank name"),
 *                     @OA\Property(property="bik", type="string", example="Some bik"),
 *                     @OA\Property(property="correspondent_account", type="string", example="Some correspondent account"),
 *                     @OA\Property(property="full_director_name", type="string", example="Some full director name"),
 *                     @OA\Property(property="treaty_number", type="string", example="Some treaty number"),
 *                     @OA\Property(property="treaty_date", type="datetime", example="2023-10-16 07:09:30"),
 *                     @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *                     @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *                 )
 *             )
 *         )
 *     )
 * )
 */
class UserController extends Controller
{
    //
}
