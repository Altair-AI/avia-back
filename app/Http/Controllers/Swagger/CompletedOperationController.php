<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/v1/admin/completed-operations",
 *     summary="Получить список всех выполненных работ",
 *     tags={"Выполненные работы"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора и администратора возвращает список всех выполненных работ в системе.",
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(type="array", @OA\Items(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="operation_id", type="integer", example=2),
 *             @OA\Property(property="previous_operation_id", type="integer", example=1),
 *             @OA\Property(property="operation_status", type="integer", example=0),
 *             @OA\Property(property="operation_result_id", type="integer", example=1),
 *             @OA\Property(property="work_session_id", type="integer", example=1),
 *             @OA\Property(property="operation",
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                 @OA\Property(property="verbal_name", type="string", example="Some verbal name")
 *             ),
 *             @OA\Property(property="previous_operation",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                 @OA\Property(property="verbal_name", type="string", example="Some verbal name")
 *             ),
 *             @OA\Property(property="operation_result",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name")
 *             ),
 *             @OA\Property(property="work_session",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="stop_time", type="datetime", example="2024-05-01T01:52:11.000000Z"),
 *                 @OA\Property(property="malfunction_cause_rule_id", type="integer", example=1),
 *                 @OA\Property(property="user_id", type="integer", example=1)
 *             )
 *         ))
 *     )
 * ),
 *
 * @OA\Post(
 *     path="/api/v1/admin/completed-operations",
 *     summary="Создание выполненной работы",
 *     tags={"Выполненные работы"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="operation_id", type="integer", example=2),
 *                     @OA\Property(property="previous_operation_id", type="integer", example=1),
 *                     @OA\Property(property="operation_status", type="integer", example=0),
 *                     @OA\Property(property="operation_result_id", type="integer", example=1),
 *                     @OA\Property(property="work_session_id", type="integer", example=1)
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
 *             @OA\Property(property="operation_id", type="integer", example=2),
 *             @OA\Property(property="previous_operation_id", type="integer", example=1),
 *             @OA\Property(property="operation_status", type="integer", example=0),
 *             @OA\Property(property="operation_result_id", type="integer", example=1),
 *             @OA\Property(property="work_session_id", type="integer", example=1)
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/completed-operations/{completed-operation}",
 *     summary="Получить единичную выполненную работу",
 *     tags={"Выполненные работы"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора и администратора возвращает любую выполненную работу, созданную в системе.",
 *
 *     @OA\Parameter(
 *         description="id выполненной работы",
 *         in="path",
 *         name="completed-operation",
 *         required=true,
 *         example=1
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="operation_id", type="integer", example=2),
 *             @OA\Property(property="previous_operation_id", type="integer", example=1),
 *             @OA\Property(property="operation_status", type="integer", example=0),
 *             @OA\Property(property="operation_result_id", type="integer", example=1),
 *             @OA\Property(property="work_session_id", type="integer", example=1),
 *             @OA\Property(property="operation",
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                 @OA\Property(property="verbal_name", type="string", example="Some verbal name")
 *             ),
 *             @OA\Property(property="previous_operation",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                 @OA\Property(property="verbal_name", type="string", example="Some verbal name")
 *             ),
 *             @OA\Property(property="operation_result",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name")
 *             ),
 *             @OA\Property(property="work_session",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="stop_time", type="datetime", example="2024-05-01T01:52:11.000000Z"),
 *                 @OA\Property(property="malfunction_cause_rule_id", type="integer", example=1),
 *                 @OA\Property(property="user_id", type="integer", example=1)
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/v1/admin/completed-operations/{completed-operation}",
 *     summary="Обновить выполненную работу",
 *     tags={"Выполненные работы"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id выполненной работы",
 *         in="path",
 *         name="completed-operation",
 *         required=true,
 *         example=1
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="operation_id", type="integer", example=20),
 *                     @OA\Property(property="previous_operation_id", type="integer", example=10),
 *                     @OA\Property(property="operation_status", type="integer", example=1),
 *                     @OA\Property(property="operation_result_id", type="integer", example=10),
 *                     @OA\Property(property="work_session_id", type="integer", example=10)
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
 *             @OA\Property(property="operation_id", type="integer", example=20),
 *             @OA\Property(property="previous_operation_id", type="integer", example=10),
 *             @OA\Property(property="operation_status", type="integer", example=1),
 *             @OA\Property(property="operation_result_id", type="integer", example=10),
 *             @OA\Property(property="work_session_id", type="integer", example=10)
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/v1/admin/completed-operations/{completed-operation}",
 *     summary="Удалить выполненную работу",
 *     tags={"Выполненные работы"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id выполненной работы",
 *         in="path",
 *         name="completed-operation",
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
class CompletedOperationController extends Controller
{
    //
}
