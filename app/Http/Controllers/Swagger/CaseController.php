<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/v1/admin/cases",
 *     summary="Получить список прецедентов",
 *     tags={"Прецеденты"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает список всех прецедентов, созданных в системе. Для администратора и техника возвращает список прецедентов для определенной базы знаний, к которой у них есть доступ. Список может быть отфильтрован по различным параметрам.",
 *
 *     @OA\Parameter(
 *         description="Дата фиксации прецедента",
 *         in="query",
 *         name="date",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Номер КУНАТ прецедента",
 *         in="query",
 *         name="card_number",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id этапа обнаружения неисправности",
 *         in="query",
 *         name="malfunction_detection_stage_id",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id причины неисправности или отказа",
 *         in="query",
 *         name="malfunction_cause_id",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id технической системы реального времени, которая является причиной неисправности",
 *         in="query",
 *         name="system_id_for_repair",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id начальной выполненной работы",
 *         in="query",
 *         name="initial_completed_operation_id",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id базы знаний прецедентов",
 *         in="query",
 *         name="case_based_knowledge_base_id",
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
 *                 @OA\Property(property="date", type="datetime", example="2024-02-02 01:10:48"),
 *                 @OA\Property(property="card_number", type="string", example="Some card number"),
 *                 @OA\Property(property="malfunction_detection_stage_id", type="integer", example=1),
 *                 @OA\Property(property="malfunction_cause_id", type="integer", example=1),
 *                 @OA\Property(property="system_id_for_repair", type="integer", example=1),
 *                 @OA\Property(property="initial_completed_operation_id", type="integer", example=1),
 *                 @OA\Property(property="case_based_knowledge_base_id", type="integer", example=1),
 *                 @OA\Property(property="malfunction_detection_stage",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name")
 *                 ),
 *                 @OA\Property(property="malfunction_cause",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name")
 *                 ),
 *                 @OA\Property(property="system_for_repair",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="registration_code", type="string", example="Some registration code"),
 *                     @OA\Property(property="registration_description", type="string", example="Some registration description"),
 *                     @OA\Property(property="operation_time_from_start", type="integer", example=1),
 *                     @OA\Property(property="operation_time_from_last_repair", type="integer", example=2),
 *                     @OA\Property(property="technical_system_id", type="integer", example=1),
 *                     @OA\Property(property="project_id", type="integer", example=1)
 *                 ),
 *                 @OA\Property(property="initial_completed_operation",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="operation_id", type="integer", example=2),
 *                     @OA\Property(property="previous_operation_id", type="integer", example=1),
 *                     @OA\Property(property="operation_result_id", type="integer", example=1),
 *                     @OA\Property(property="work_session_id", type="integer", example=1)
 *                 ),
 *                 @OA\Property(property="case_based_knowledge_base",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="status", type="integer", example=0),
 *                     @OA\Property(property="correctness", type="integer", example=0),
 *                     @OA\Property(property="author", type="integer", example=1),
 *                     @OA\Property(property="real_time_technical_system_id", type="integer", example=1),
 *                     @OA\Property(property="project_id", type="integer", example=1)
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
 *     path="/api/v1/admin/cases",
 *     summary="Создание нового прецедента",
 *     tags={"Прецеденты"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="card_number", type="string", example="Some card number"),
 *                     @OA\Property(property="malfunction_detection_stage_id", type="integer", example=1)
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
 *                 @OA\Property(property="date", type="datetime", example="2024-02-02 01:10:48"),
 *                 @OA\Property(property="card_number", type="string", example="Some card number"),
 *                 @OA\Property(property="malfunction_detection_stage_id", type="integer", example=1),
 *                 @OA\Property(property="malfunction_cause_id", type="integer", example=1),
 *                 @OA\Property(property="system_id_for_repair", type="integer", example=1),
 *                 @OA\Property(property="initial_completed_operation_id", type="integer", example=1),
 *                 @OA\Property(property="case_based_knowledge_base_id", type="integer", example=1)
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/cases/{case}",
 *     summary="Получить единичный прецедент",
 *     tags={"Прецеденты"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает любой прецедент. Для администратора и техника возвращает прецедент для определенной базы знаний прецедентов, которая им доступна.",
 *
 *     @OA\Parameter(
 *         description="id прецедента",
 *         in="path",
 *         name="case",
 *         required=true,
 *         example=1
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="date", type="datetime", example="2024-02-02 01:10:48"),
 *             @OA\Property(property="card_number", type="string", example="Some card number"),
 *             @OA\Property(property="malfunction_detection_stage_id", type="integer", example=1),
 *             @OA\Property(property="malfunction_cause_id", type="integer", example=1),
 *             @OA\Property(property="system_id_for_repair", type="integer", example=1),
 *             @OA\Property(property="initial_completed_operation_id", type="integer", example=1),
 *             @OA\Property(property="case_based_knowledge_base_id", type="integer", example=1),
 *             @OA\Property(property="malfunction_detection_stage",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name")
 *             ),
 *             @OA\Property(property="malfunction_cause",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name")
 *             ),
 *             @OA\Property(property="system_for_repair",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="registration_code", type="string", example="Some registration code"),
 *                 @OA\Property(property="registration_description", type="string", example="Some registration description"),
 *                 @OA\Property(property="operation_time_from_start", type="integer", example=1),
 *                 @OA\Property(property="operation_time_from_last_repair", type="integer", example=2),
 *                 @OA\Property(property="technical_system_id", type="integer", example=1),
 *                 @OA\Property(property="project_id", type="integer", example=1)
 *             ),
 *             @OA\Property(property="initial_completed_operation",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="operation_id", type="integer", example=2),
 *                 @OA\Property(property="previous_operation_id", type="integer", example=1),
 *                 @OA\Property(property="operation_result_id", type="integer", example=1),
 *                 @OA\Property(property="work_session_id", type="integer", example=1)
 *             ),
 *             @OA\Property(property="case_based_knowledge_base",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="correctness", type="integer", example=0),
 *                 @OA\Property(property="author", type="integer", example=1),
 *                 @OA\Property(property="real_time_technical_system_id", type="integer", example=1),
 *                 @OA\Property(property="project_id", type="integer", example=1)
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/v1/admin/cases/{case}",
 *     summary="Обновить прецедент",
 *     tags={"Прецеденты"},
 *     security={{ "bearerAuth": {} }},
 *     description="Супер-администратор может редактировать любые прецеденты. Администратор и техник могут редактировать прецеденты только тех баз знаний прецедентов, которые им доступны.",
 *
 *     @OA\Parameter(
 *         description="id прецедента",
 *         in="path",
 *         name="case",
 *         required=true,
 *         example=1
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="card_number", type="string", example="Some card number for edit"),
 *                     @OA\Property(property="malfunction_detection_stage_id", type="integer", example=2)
 *                 )
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="date", type="datetime", example="2024-02-02 01:10:48"),
 *             @OA\Property(property="card_number", type="string", example="Some card number"),
 *             @OA\Property(property="malfunction_detection_stage_id", type="integer", example=2),
 *             @OA\Property(property="malfunction_cause_id", type="integer", example=1),
 *             @OA\Property(property="system_id_for_repair", type="integer", example=1),
 *             @OA\Property(property="initial_completed_operation_id", type="integer", example=1),
 *             @OA\Property(property="case_based_knowledge_base_id", type="integer", example=1)
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/v1/admin/cases/{case}",
 *     summary="Удалить прецедент",
 *     tags={"Прецеденты"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id прецедента",
 *         in="path",
 *         name="case",
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
class CaseController extends Controller
{
    //
}
