<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/v1/admin/real-time-technical-systems",
 *     summary="Получить список технических систем реального времени",
 *     tags={"Технические системы реального времени"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает список всех технических систем реального времени, созданных в системе. Для администратора возвращает список только тех технических систем реального времени, которые доступны в рамках проекта для той организации к которой принадлежит администратор. Для техника возвращает список только тех технических систем реального времени, доступ к которым установил администратор. Список может быть отфильтрован по различным параметрам.",
 *
 *     @OA\Parameter(
 *         description="код технической системы или объекта при регистрации",
 *         in="query",
 *         name="registration_code",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Описание или часть описания технической системы или объекта",
 *         in="query",
 *         name="registration_description",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Наработка с начала эксплуатации",
 *         in="query",
 *         name="operation_time_from_start",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Наработка со времени последнего ремонта",
 *         in="query",
 *         name="operation_time_from_last_repair",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id технической системы",
 *         in="query",
 *         name="technical_system_id",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id проекта",
 *         in="query",
 *         name="project_id",
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
 *                 @OA\Property(property="registration_code", type="string", example="Some registration code"),
 *                 @OA\Property(property="registration_description", type="string", example="Some description"),
 *                 @OA\Property(property="operation_time_from_start", type="integer", example=1),
 *                 @OA\Property(property="operation_time_from_last_repair", type="integer", example=10),
 *                 @OA\Property(property="technical_system_id", type="integer", example=1),
 *                 @OA\Property(property="project_id", type="integer", example=1),
 *                 @OA\Property(property="technical_system",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="parent_technical_system_id", type="integer", example=null)
 *                 ),
 *                 @OA\Property(property="project",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="type", type="integer", example=0),
 *                     @OA\Property(property="status", type="integer", example=0),
 *                     @OA\Property(property="technical_system_id", type="integer", example=1)
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
 *     path="/api/v1/admin/real-time-technical-systems",
 *     summary="Создание новой технической системы реального времени",
 *     tags={"Технические системы реального времени"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="registration_code", type="string", example="Some registration code"),
 *                     @OA\Property(property="registration_description", type="string", example="Some description"),
 *                     @OA\Property(property="operation_time_from_start", type="integer", example=1),
 *                     @OA\Property(property="operation_time_from_last_repair", type="integer", example=2),
 *                     @OA\Property(property="technical_system_id", type="integer", example=1),
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
 *             @OA\Property(property="id", type="integer", example=2),
 *             @OA\Property(property="registration_code", type="string", example="Some registration code"),
 *             @OA\Property(property="registration_description", type="string", example="Some description"),
 *             @OA\Property(property="operation_time_from_start", type="integer", example=1),
 *             @OA\Property(property="operation_time_from_last_repair", type="integer", example=2),
 *             @OA\Property(property="technical_system_id", type="integer", example=1),
 *             @OA\Property(property="project_id", type="integer", example=1)
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/real-time-technical-systems/{real-time-technical-system}",
 *     summary="Получить единичную техническую систему реального времени",
 *     tags={"Технические системы реального времени"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает любую техническую систему реального времени. Для администратора возвращает техническую систему реального времени, которая доступна в рамках проекта для той организации к которой принадлежит администратор. Для техника возвращает техническую систему реального времени, доступ к которой установил администратор.",
 *
 *     @OA\Parameter(
 *         description="id технической системы реального времени",
 *         in="path",
 *         name="real-time-technical-system",
 *         required=true,
 *         example=1
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="registration_code", type="string", example="Some registration code"),
 *             @OA\Property(property="registration_description", type="string", example="Some description"),
 *             @OA\Property(property="operation_time_from_start", type="integer", example=1),
 *             @OA\Property(property="operation_time_from_last_repair", type="integer", example=10),
 *             @OA\Property(property="technical_system_id", type="integer", example=1),
 *             @OA\Property(property="project_id", type="integer", example=1),
 *             @OA\Property(property="technical_system",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="parent_technical_system_id", type="integer", example=null)
 *                 ),
 *                 @OA\Property(property="project",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="type", type="integer", example=0),
 *                     @OA\Property(property="status", type="integer", example=0),
 *                     @OA\Property(property="technical_system_id", type="integer", example=1)
 *                 )
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/v1/admin/real-time-technical-systems/{real-time-technical-system}",
 *     summary="Обновить техническую систему реального времени",
 *     tags={"Технические системы реального времени"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id технической системы реального времени",
 *         in="path",
 *         name="real-time-technical-system",
 *         required=true,
 *         example=2
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="registration_code", type="string", example="Some registration code for edit"),
 *                     @OA\Property(property="registration_description", type="string", example="Some description for edit"),
 *                     @OA\Property(property="operation_time_from_start", type="integer", example=10),
 *                     @OA\Property(property="operation_time_from_last_repair", type="integer", example=100),
 *                     @OA\Property(property="technical_system_id", type="integer", example=2),
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
 *             @OA\Property(property="id", type="integer", example=2),
 *             @OA\Property(property="registration_code", type="string", example="Some registration code"),
 *             @OA\Property(property="registration_description", type="string", example="Some description"),
 *             @OA\Property(property="operation_time_from_start", type="integer", example=10),
 *             @OA\Property(property="operation_time_from_last_repair", type="integer", example=100),
 *             @OA\Property(property="technical_system_id", type="integer", example=2),
 *             @OA\Property(property="project_id", type="integer", example=2)
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/v1/admin/real-time-technical-systems/{real-time-technical-system}",
 *     summary="Удалить техническую систему реального времени",
 *     tags={"Технические системы реального времени"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id технической системы реального времени",
 *         in="path",
 *         name="real-time-technical-system",
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
class RealTimeTechnicalSystemController extends Controller
{
    //
}
