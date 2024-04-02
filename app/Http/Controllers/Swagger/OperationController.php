<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/v1/admin/operations/export-root",
 *     summary="Экспортировать работы РУН (основные операции) в виде CSV-файла",
 *     tags={"Работы (операции)"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает CSV-файл со всеми работами РУН (основными операциями). Для администратора возвращает CSV-файл работ РУН (основных операций), связанных с техническими системами, которые доступны в рамках проекта для той организации к которой принадлежит администратор.",
 *
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\MediaType(mediaType="text/csv;charset=UTF-8")
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/operations",
 *     summary="Получить список работ",
 *     tags={"Работы (операции)"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает список всех работ (операций) РУН вместе с иерархией их под-работ, созданных в системе. Для администратора возвращает список только тех работ (операций) РУН вместе с иерархией их под-работ, принадлежащих определенным техническим системам, которые доступны в рамках проекта для той организации к которой принадлежит администратор. Список может быть отфильтрован по различным параметрам.",
 *
 *     @OA\Parameter(
 *         description="Код работы (операции)",
 *         in="query",
 *         name="code",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Тип работы (операции)",
 *         in="query",
 *         name="type",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Название или часть названия работы в повелительном наклонении",
 *         in="query",
 *         name="imperative_name",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Название или часть названия работы (отглагольное существительное)",
 *         in="query",
 *         name="verbal_name",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Номер раздела в документе",
 *         in="query",
 *         name="document_section",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Номер подраздела в документе",
 *         in="query",
 *         name="document_subsection",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Номер начальной страницы в документе",
 *         in="query",
 *         name="start_document_page",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Номер завершающей страницы в документе",
 *         in="query",
 *         name="end_document_page",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Номер фактической страницы в файле документа",
 *         in="query",
 *         name="actual_document_page",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id документа",
 *         in="query",
 *         name="document_id",
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
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                 @OA\Property(property="verbal_name", type="string", example="Some verbal name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="document_section", type="string", example="Some document section"),
 *                 @OA\Property(property="document_subsection", type="string", example="Some document subsection"),
 *                 @OA\Property(property="start_document_page", type="integer", example=100),
 *                 @OA\Property(property="end_document_page", type="integer", example=101),
 *                 @OA\Property(property="actual_document_page", type="integer", example=123),
 *                 @OA\Property(property="document_id", type="integer", example=1),
 *                 @OA\Property(property="technical_systems", type="array", @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=2),
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="parent_technical_system_id", type="integer", example=1)
 *                 )),
 *                 @OA\Property(property="operation_results", type="array", @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description")
 *                 )),
 *                 @OA\Property(property="operation_conditions", type="array", @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description")
 *                 )),
 *                 @OA\Property(property="malfunction_codes", type="array", @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="type", type="integer", example=0),
 *                     @OA\Property(property="source", type="string", example="Some source"),
 *                     @OA\Property(property="alternative_name", type="string", example="Some alternative name"),
 *                     @OA\Property(property="technical_system_id", type="integer", example=2)
 *                 )),
 *                 @OA\Property(property="malfunction_causes", type="array", @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name")
 *                 )),
 *                 @OA\Property(property="sub_operations", type="array", @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=2),
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="type", type="integer", example=0),
 *                     @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                     @OA\Property(property="verbal_name", type="string", example="Some verbal name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="document_section", type="string", example="Some document section"),
 *                     @OA\Property(property="document_subsection", type="string", example="Some document subsection"),
 *                     @OA\Property(property="start_document_page", type="integer", example=100),
 *                     @OA\Property(property="end_document_page", type="integer", example=101),
 *                     @OA\Property(property="actual_document_page", type="integer", example=123),
 *                     @OA\Property(property="document_id", type="integer", example=1),
 *                     @OA\Property(property="pivot",
 *                         @OA\Property(property="parent_operation_id", type="integer", example=1),
 *                         @OA\Property(property="child_operation_id", type="integer", example="2"),
 *                         @OA\Property(property="designation", type="string", example="Some designation"),
 *                         @OA\Property(property="sequence_number", type="integer", example=1)
 *                     ),
 *                     @OA\Property(property="sub_operations", type="array", @OA\Items())
 *                 ))
 *             )),
 *             @OA\Property(property="page_current", type="integer", example=1),
 *             @OA\Property(property="page_total", type="integer", example=20),
 *             @OA\Property(property="page_size", type="integer", example=10)
 *         )
 *     )
 * ),
 *
 * @OA\Post(
 *     path="/api/v1/admin/operations",
 *     summary="Создание новой работы",
 *     tags={"Работы (операции)"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="type", type="integer", example=0),
 *                     @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                     @OA\Property(property="verbal_name", type="string", example="Some verbal name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="document_section", type="string", example="Some document section"),
 *                     @OA\Property(property="document_subsection", type="string", example="Some document subsection"),
 *                     @OA\Property(property="start_document_page", type="integer", example=100),
 *                     @OA\Property(property="end_document_page", type="integer", example=101),
 *                     @OA\Property(property="actual_document_page", type="integer", example=123),
 *                     @OA\Property(property="document_id", type="integer", example=1)
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
 *             @OA\Property(property="type", type="integer", example=0),
 *             @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *             @OA\Property(property="verbal_name", type="string", example="Some verbal name"),
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="document_section", type="string", example="Some document section"),
 *             @OA\Property(property="document_subsection", type="string", example="Some document subsection"),
 *             @OA\Property(property="start_document_page", type="integer", example=100),
 *             @OA\Property(property="end_document_page", type="integer", example=101),
 *             @OA\Property(property="actual_document_page", type="integer", example=123),
 *             @OA\Property(property="document_id", type="integer", example=1)
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/operations/{operation}",
 *     summary="Получить единичную работу",
 *     tags={"Работы (операции)"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает любую работу (операцию) РУН вместе с иерархией под-работ, созданную в системе. Для администратора возвращает работу (операцию) РУН вместе с иерархией под-работ, принадлежащую определенной технической системе, которые доступна в рамках проекта для той организации к которой принадлежит администратор.",
 *
 *     @OA\Parameter(
 *         description="id работы (операции)",
 *         in="path",
 *         name="operation",
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
 *             @OA\Property(property="type", type="integer", example=0),
 *             @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *             @OA\Property(property="verbal_name", type="string", example="Some verbal name"),
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="document_section", type="string", example="Some document section"),
 *             @OA\Property(property="document_subsection", type="string", example="Some document subsection"),
 *             @OA\Property(property="start_document_page", type="integer", example=100),
 *             @OA\Property(property="end_document_page", type="integer", example=101),
 *             @OA\Property(property="actual_document_page", type="integer", example=123),
 *             @OA\Property(property="document_id", type="integer", example=1),
 *             @OA\Property(property="technical_systems", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="parent_technical_system_id", type="integer", example=1)
 *             )),
 *             @OA\Property(property="operation_results", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description")
 *             )),
 *             @OA\Property(property="operation_conditions", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description")
 *             )),
 *             @OA\Property(property="malfunction_codes", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="source", type="string", example="Some source"),
 *                 @OA\Property(property="alternative_name", type="string", example="Some alternative name"),
 *                 @OA\Property(property="technical_system_id", type="integer", example=2)
 *             )),
 *             @OA\Property(property="malfunction_causes", type="array", @OA\Items(
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="name", type="string", example="Some name")
 *              )),
 *             @OA\Property(property="sub_operations", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                 @OA\Property(property="verbal_name", type="string", example="Some verbal name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="document_section", type="string", example="Some document section"),
 *                 @OA\Property(property="document_subsection", type="string", example="Some document subsection"),
 *                 @OA\Property(property="start_document_page", type="integer", example=100),
 *                 @OA\Property(property="end_document_page", type="integer", example=101),
 *                 @OA\Property(property="actual_document_page", type="integer", example=123),
 *                 @OA\Property(property="document_id", type="integer", example=1),
 *                 @OA\Property(property="pivot",
 *                     @OA\Property(property="parent_operation_id", type="integer", example=1),
 *                     @OA\Property(property="child_operation_id", type="integer", example="2"),
 *                     @OA\Property(property="designation", type="string", example="Some designation"),
 *                     @OA\Property(property="sequence_number", type="integer", example=1)
 *                 ),
 *                 @OA\Property(property="sub_operations", type="array", @OA\Items())
 *             ))
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/v1/admin/operations/{operation}",
 *     summary="Обновить работу",
 *     tags={"Работы (операции)"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id работы (операции)",
 *         in="path",
 *         name="operation",
 *         required=true,
 *         example=1
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="code", type="string", example="Some code for edit"),
 *                     @OA\Property(property="type", type="integer", example=1),
 *                     @OA\Property(property="imperative_name", type="string", example="Some imperative name for edit"),
 *                     @OA\Property(property="verbal_name", type="string", example="Some verbal name for edit"),
 *                     @OA\Property(property="description", type="string", example="Some description for edit"),
 *                     @OA\Property(property="document_section", type="string", example="Some document section for edit"),
 *                     @OA\Property(property="document_subsection", type="string", example="Some document subsection for edit"),
 *                     @OA\Property(property="start_document_page", type="integer", example=200),
 *                     @OA\Property(property="end_document_page", type="integer", example=202),
 *                     @OA\Property(property="actual_document_page", type="integer", example=333),
 *                     @OA\Property(property="document_id", type="integer", example=2)
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
 *             @OA\Property(property="type", type="integer", example=1),
 *             @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *             @OA\Property(property="verbal_name", type="string", example="Some verbal name"),
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="document_section", type="string", example="Some document section"),
 *             @OA\Property(property="document_subsection", type="string", example="Some document subsection"),
 *             @OA\Property(property="start_document_page", type="integer", example=100),
 *             @OA\Property(property="end_document_page", type="integer", example=101),
 *             @OA\Property(property="actual_document_page", type="integer", example=123),
 *             @OA\Property(property="document_id", type="integer", example=1)
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/v1/admin/operations/{operation}",
 *     summary="Удалить работу",
 *     tags={"Работы (операции)"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id работы (операции)",
 *         in="path",
 *         name="operation",
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
class OperationController extends Controller
{
    //
}
