<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/v1/admin/organizations",
 *     summary="Получить список всех организаций",
 *     tags={"Организации"},
 *     security={{ "bearerAuth": {} }},
 *     description="Возвращает список всех организаций, созданных в системе (только для супер-администратора).",
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(type="array", @OA\Items(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Some name"),
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="actual_address", type="string", example="Some actual address"),
 *             @OA\Property(property="legal_address", type="string", example="Some legal address"),
 *             @OA\Property(property="tin", type="string", example="Some tin"),
 *             @OA\Property(property="rboc", type="string", example="Some rboc"),
 *             @OA\Property(property="psrn", type="string", example="Some psrn"),
 *             @OA\Property(property="phone", type="string", example="Some phone"),
 *             @OA\Property(property="bank_account", type="string", example="Some bank account"),
 *             @OA\Property(property="bank_name", type="string", example="Some bank name"),
 *             @OA\Property(property="bik", type="string", example="Some bik"),
 *             @OA\Property(property="correspondent_account", type="string", example="Some correspondent account"),
 *             @OA\Property(property="full_director_name", type="string", example="Some full director name"),
 *             @OA\Property(property="treaty_number", type="string", example="Some treaty number"),
 *             @OA\Property(property="treaty_date", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *         ))
 *     )
 * ),
 *
 * @OA\Post(
 *     path="/api/v1/admin/organizations",
 *     summary="Создание новой организации",
 *     tags={"Организации"},
 *     security={{ "bearerAuth": {} }},
 *     description="Создание новой организации доступно только супер-администратору.",
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="actual_address", type="string", example="Some actual address"),
 *                     @OA\Property(property="legal_address", type="string", example="Some legal address"),
 *                     @OA\Property(property="tin", type="string", example="Some tin"),
 *                     @OA\Property(property="rboc", type="string", example="Some rboc"),
 *                     @OA\Property(property="psrn", type="string", example="Some psrn"),
 *                     @OA\Property(property="phone", type="string", example="Some phone"),
 *                     @OA\Property(property="bank_account", type="string", example="Some bank account"),
 *                     @OA\Property(property="bank_name", type="string", example="Some bank name"),
 *                     @OA\Property(property="bik", type="string", example="Some bik"),
 *                     @OA\Property(property="correspondent_account", type="string", example="Some correspondent account"),
 *                     @OA\Property(property="full_director_name", type="string", example="Some full director name"),
 *                     @OA\Property(property="treaty_number", type="string", example="Some treaty number"),
 *                     @OA\Property(property="treaty_date", type="datetime", example="2023-09-15")
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
 *             @OA\Property(property="actual_address", type="string", example="Some actual address"),
 *             @OA\Property(property="legal_address", type="string", example="Some legal address"),
 *             @OA\Property(property="tin", type="string", example="Some tin"),
 *             @OA\Property(property="rboc", type="string", example="Some rboc"),
 *             @OA\Property(property="psrn", type="string", example="Some psrn"),
 *             @OA\Property(property="phone", type="string", example="Some phone"),
 *             @OA\Property(property="bank_account", type="string", example="Some bank account"),
 *             @OA\Property(property="bank_name", type="string", example="Some bank name"),
 *             @OA\Property(property="bik", type="string", example="Some bik"),
 *             @OA\Property(property="correspondent_account", type="string", example="Some correspondent account"),
 *             @OA\Property(property="full_director_name", type="string", example="Some full director name"),
 *             @OA\Property(property="treaty_number", type="string", example="Some treaty number"),
 *             @OA\Property(property="treaty_date", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/organizations/{organization}",
 *     summary="Получить единичную организацию",
 *     tags={"Организации"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает любую организацию, созданную в системе. Для администратора возвращает только ту организацию к которой принадлежит сам администратор.",
 *
 *     @OA\Parameter(
 *         description="id организации",
 *         in="path",
 *         name="organization",
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
 *             @OA\Property(property="actual_address", type="string", example="Some actual address"),
 *             @OA\Property(property="legal_address", type="string", example="Some legal address"),
 *             @OA\Property(property="tin", type="string", example="Some tin"),
 *             @OA\Property(property="rboc", type="string", example="Some rboc"),
 *             @OA\Property(property="psrn", type="string", example="Some psrn"),
 *             @OA\Property(property="phone", type="string", example="Some phone"),
 *             @OA\Property(property="bank_account", type="string", example="Some bank account"),
 *             @OA\Property(property="bank_name", type="string", example="Some bank name"),
 *             @OA\Property(property="bik", type="string", example="Some bik"),
 *             @OA\Property(property="correspondent_account", type="string", example="Some correspondent account"),
 *             @OA\Property(property="full_director_name", type="string", example="Some full director name"),
 *             @OA\Property(property="treaty_number", type="string", example="Some treaty number"),
 *             @OA\Property(property="treaty_date", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/v1/admin/organizations/{organization}",
 *     summary="Обновить организацию",
 *     tags={"Организации"},
 *     security={{ "bearerAuth": {} }},
 *     description="Обновление данных по организации доступно только супер-администратору.",
 *
 *     @OA\Parameter(
 *         description="id организации",
 *         in="path",
 *         name="organization",
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
 *                     @OA\Property(property="actual_address", type="string", example="Some actual address for edit"),
 *                     @OA\Property(property="legal_address", type="string", example="Some legal address for edit"),
 *                     @OA\Property(property="tin", type="string", example="Some tin for edit"),
 *                     @OA\Property(property="rboc", type="string", example="Some rboc for edit"),
 *                     @OA\Property(property="psrn", type="string", example="Some psrn for edit"),
 *                     @OA\Property(property="phone", type="string", example="Some phone for edit"),
 *                     @OA\Property(property="bank_account", type="string", example="Some bank account for edit"),
 *                     @OA\Property(property="bank_name", type="string", example="Some bank name for edit"),
 *                     @OA\Property(property="bik", type="string", example="Some bik for edit"),
 *                     @OA\Property(property="correspondent_account", type="string", example="Some correspondent account for edit"),
 *                     @OA\Property(property="full_director_name", type="string", example="Some full director name for edit"),
 *                     @OA\Property(property="treaty_number", type="string", example="Some treaty number for edit"),
 *                     @OA\Property(property="treaty_date", type="datetime", example="2023-09-20")
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
 *             @OA\Property(property="actual_address", type="string", example="Some actual address"),
 *             @OA\Property(property="legal_address", type="string", example="Some legal address"),
 *             @OA\Property(property="tin", type="string", example="Some tin"),
 *             @OA\Property(property="rboc", type="string", example="Some rboc"),
 *             @OA\Property(property="psrn", type="string", example="Some psrn"),
 *             @OA\Property(property="phone", type="string", example="Some phone"),
 *             @OA\Property(property="bank_account", type="string", example="Some bank account"),
 *             @OA\Property(property="bank_name", type="string", example="Some bank name"),
 *             @OA\Property(property="bik", type="string", example="Some bik"),
 *             @OA\Property(property="correspondent_account", type="string", example="Some correspondent account"),
 *             @OA\Property(property="full_director_name", type="string", example="Some full director name"),
 *             @OA\Property(property="treaty_number", type="string", example="Some treaty number"),
 *             @OA\Property(property="treaty_date", type="datetime", example="2023-09-20T01:50:10.000000Z"),
 *             @OA\Property(property="created_at", type="datetime", example="2023-09-15T01:52:11.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2023-09-15T01:52:11.000000Z")
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/v1/admin/organizations/{organization}",
 *     summary="Удалить организацию",
 *     tags={"Организации"},
 *     security={{ "bearerAuth": {} }},
 *     description="Удаление организации доступно только супер-администратору.",
 *
 *     @OA\Parameter(
 *         description="id организации",
 *         in="path",
 *         name="organization",
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
class OrganizationController extends Controller
{
    //
}
