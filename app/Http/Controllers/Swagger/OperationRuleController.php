<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/v1/admin/operation-rules",
 *     summary="Получить список правил определения последовательности работ (операций)",
 *     tags={"Правила определения последовательности работ"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает список правил определения последовательности работ. Для администратора возвращает список только тех правил определения последовательности работ, принадлежащих базе знаний правил, которая доступна в рамках проекта для той организации к которой принадлежит администратор. Список может быть отфильтрован по различным параметрам.",
 *
 *     @OA\Parameter(
 *         description="Тип правила",
 *         in="query",
 *         name="type",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Приоритет (важность) правила",
 *         in="query",
 *         name="priority",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Флаг показывающий надо ли повторять озвучку",
 *         in="query",
 *         name="repeat_voice",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Код работы или блока работ, которая выполняется в текущий момент (является контекстом)",
 *         in="query",
 *         name="context",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id работы (условие)",
 *         in="query",
 *         name="operation_id_if",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Статус работы (условие)",
 *         in="query",
 *         name="operation_status_if",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id результата работы (условие)",
 *         in="query",
 *         name="operation_result_id_if",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id работы (действие)",
 *         in="query",
 *         name="operation_id_then",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="Статус работы (действие)",
 *         in="query",
 *         name="operation_status_then",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id результата работы (действие)",
 *         in="query",
 *         name="operation_result_id_then",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id базы знаний правил",
 *         in="query",
 *         name="rule_based_knowledge_base_id",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id причины неисправности (отказа)",
 *         in="query",
 *         name="malfunction_cause_id",
 *         required=false
 *     ),
 *     @OA\Parameter(
 *         description="id отказавшей технической системы или объекта",
 *         in="query",
 *         name="malfunction_system_id",
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
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="priority", type="integer", example=100),
 *                 @OA\Property(property="repeat_voice", type="integer", example=1),
 *                 @OA\Property(property="context", type="string", example="Some operation code"),
 *                 @OA\Property(property="operation_id_if", type="integer", example=1),
 *                 @OA\Property(property="operation_status_if", type="integer", example=2),
 *                 @OA\Property(property="operation_result_id_if", type="integer", example=1),
 *                 @OA\Property(property="operation_id_then", type="integer", example=2),
 *                 @OA\Property(property="operation_status_then", type="integer", example=1),
 *                 @OA\Property(property="operation_result_id_then", type="integer", example=2),
 *                 @OA\Property(property="rule_based_knowledge_base_id", type="integer", example=1),
 *                 @OA\Property(property="malfunction_cause_id", type="integer", example=1),
 *                 @OA\Property(property="malfunction_system_id", type="integer", example=1),
 *                 @OA\Property(property="document_id", type="integer", example=1),
 *                 @OA\Property(property="operation_if",
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
 *                     @OA\Property(property="document_id", type="integer", example=1)
 *                 ),
 *                 @OA\Property(property="operation_result_if",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description")
 *                 ),
 *                 @OA\Property(property="operation_then",
 *                     @OA\Property(property="id", type="integer", example=2),
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                     @OA\Property(property="verbal_name", type="string", example="Some verbal name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="document_section", type="string", example="Some document section"),
 *                     @OA\Property(property="document_subsection", type="string", example="Some document subsection"),
 *                     @OA\Property(property="start_document_page", type="integer", example=100),
 *                     @OA\Property(property="end_document_page", type="integer", example=101),
 *                     @OA\Property(property="actual_document_page", type="integer", example=123),
 *                     @OA\Property(property="document_id", type="integer", example=1)
 *                 ),
 *                 @OA\Property(property="operation_result_then",
 *                     @OA\Property(property="id", type="integer", example=2),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description")
 *                 ),
 *                 @OA\Property(property="rule_based_knowledge_base",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="status", type="integer", example=0),
 *                     @OA\Property(property="correctness", type="integer", example=0),
 *                     @OA\Property(property="author", type="integer", example=1),
 *                     @OA\Property(property="technical_system_id", type="integer", example=1)
 *                 ),
 *                 @OA\Property(property="malfunction_cause",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Some name")
 *                 ),
 *                 @OA\Property(property="malfunction_system",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="parent_technical_system_id", type="integer", example=1)
 *                 ),
 *                 @OA\Property(property="document",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="code", type="string", example="Some code"),
 *                     @OA\Property(property="name", type="string", example="Some name"),
 *                     @OA\Property(property="type", type="integer", example=0),
 *                     @OA\Property(property="version", type="string", example="Some version"),
 *                     @OA\Property(property="file", type="string", example="Some path to file")
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
 *     path="/api/v1/admin/operation-rules",
 *     summary="Создание нового правила определения последовательности работ",
 *     tags={"Правила определения последовательности работ"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="description", type="string", example="Some description"),
 *                     @OA\Property(property="type", type="integer", example=0),
 *                     @OA\Property(property="priority", type="integer", example=100),
 *                     @OA\Property(property="repeat_voice", type="integer", example=1),
 *                     @OA\Property(property="context", type="string", example="Some operation code"),
 *                     @OA\Property(property="operation_id_if", type="integer", example=1),
 *                     @OA\Property(property="operation_status_if", type="integer", example=2),
 *                     @OA\Property(property="operation_result_id_if", type="integer", example=1),
 *                     @OA\Property(property="operation_id_then", type="integer", example=2),
 *                     @OA\Property(property="operation_status_then", type="integer", example=1),
 *                     @OA\Property(property="operation_result_id_then", type="integer", example=2),
 *                     @OA\Property(property="rule_based_knowledge_base_id", type="integer", example=1),
 *                     @OA\Property(property="malfunction_cause_id", type="integer", example=1),
 *                     @OA\Property(property="malfunction_system_id", type="integer", example=1),
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
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="type", type="integer", example=0),
 *             @OA\Property(property="priority", type="integer", example=100),
 *             @OA\Property(property="repeat_voice", type="integer", example=1),
 *             @OA\Property(property="context", type="string", example="Some operation code"),
 *             @OA\Property(property="operation_id_if", type="integer", example=1),
 *             @OA\Property(property="operation_status_if", type="integer", example=2),
 *             @OA\Property(property="operation_result_id_if", type="integer", example=1),
 *             @OA\Property(property="operation_id_then", type="integer", example=2),
 *             @OA\Property(property="operation_status_then", type="integer", example=1),
 *             @OA\Property(property="operation_result_id_then", type="integer", example=2),
 *             @OA\Property(property="rule_based_knowledge_base_id", type="integer", example=1),
 *             @OA\Property(property="malfunction_cause_id", type="integer", example=1),
 *             @OA\Property(property="malfunction_system_id", type="integer", example=1),
 *             @OA\Property(property="document_id", type="integer", example=1),
 *             @OA\Property(property="operation_if",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                 @OA\Property(property="verbal_name", type="string", example="Some verbal name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="document_section", type="string", example="Some document section"),
 *                 @OA\Property(property="document_subsection", type="string", example="Some document subsection"),
 *                 @OA\Property(property="start_document_page", type="integer", example=100),
 *                 @OA\Property(property="end_document_page", type="integer", example=101),
 *                 @OA\Property(property="actual_document_page", type="integer", example=123),
 *                 @OA\Property(property="document_id", type="integer", example=1)
 *             ),
 *             @OA\Property(property="operation_result_if",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description")
 *             ),
 *             @OA\Property(property="operation_then",
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                 @OA\Property(property="verbal_name", type="string", example="Some verbal name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="document_section", type="string", example="Some document section"),
 *                 @OA\Property(property="document_subsection", type="string", example="Some document subsection"),
 *                 @OA\Property(property="start_document_page", type="integer", example=100),
 *                 @OA\Property(property="end_document_page", type="integer", example=101),
 *                 @OA\Property(property="actual_document_page", type="integer", example=123),
 *                 @OA\Property(property="document_id", type="integer", example=1)
 *             ),
 *             @OA\Property(property="operation_result_then",
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description")
 *             ),
 *             @OA\Property(property="rule_based_knowledge_base",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="correctness", type="integer", example=0),
 *                 @OA\Property(property="author", type="integer", example=1),
 *                 @OA\Property(property="technical_system_id", type="integer", example=1)
 *             ),
 *             @OA\Property(property="malfunction_cause",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name")
 *             ),
 *             @OA\Property(property="malfunction_system",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="parent_technical_system_id", type="integer", example=1)
 *             ),
 *             @OA\Property(property="document",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="version", type="string", example="Some version"),
 *                 @OA\Property(property="file", type="string", example="Some path to file")
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/admin/operation-rules/{operation-rule}",
 *     summary="Получить единичное правило определения последовательности работ",
 *     tags={"Правила определения последовательности работ"},
 *     security={{ "bearerAuth": {} }},
 *     description="Для супер-администратора возвращает любое правило определения последовательности работ. Для администратора возвращает правило определения последовательности работ, которое принадлежит определенной базе знаний правил, которая доступна в рамках проекта для той организации к которой принадлежит администратор.",
 *
 *     @OA\Parameter(
 *         description="id правила определения последовательности работ",
 *         in="path",
 *         name="operation-rule",
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
 *             @OA\Property(property="type", type="integer", example=0),
 *             @OA\Property(property="priority", type="integer", example=100),
 *             @OA\Property(property="repeat_voice", type="integer", example=1),
 *             @OA\Property(property="context", type="string", example="Some operation code"),
 *             @OA\Property(property="operation_id_if", type="integer", example=1),
 *             @OA\Property(property="operation_status_if", type="integer", example=2),
 *             @OA\Property(property="operation_result_id_if", type="integer", example=1),
 *             @OA\Property(property="operation_id_then", type="integer", example=2),
 *             @OA\Property(property="operation_status_then", type="integer", example=1),
 *             @OA\Property(property="operation_result_id_then", type="integer", example=2),
 *             @OA\Property(property="rule_based_knowledge_base_id", type="integer", example=1),
 *             @OA\Property(property="malfunction_cause_id", type="integer", example=1),
 *             @OA\Property(property="malfunction_system_id", type="integer", example=1),
 *             @OA\Property(property="document_id", type="integer", example=1),
 *             @OA\Property(property="operation_if",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                 @OA\Property(property="verbal_name", type="string", example="Some verbal name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="document_section", type="string", example="Some document section"),
 *                 @OA\Property(property="document_subsection", type="string", example="Some document subsection"),
 *                 @OA\Property(property="start_document_page", type="integer", example=100),
 *                 @OA\Property(property="end_document_page", type="integer", example=101),
 *                 @OA\Property(property="actual_document_page", type="integer", example=123),
 *                 @OA\Property(property="document_id", type="integer", example=1)
 *             ),
 *             @OA\Property(property="operation_result_if",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description")
 *             ),
 *             @OA\Property(property="operation_then",
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                 @OA\Property(property="verbal_name", type="string", example="Some verbal name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="document_section", type="string", example="Some document section"),
 *                 @OA\Property(property="document_subsection", type="string", example="Some document subsection"),
 *                 @OA\Property(property="start_document_page", type="integer", example=100),
 *                 @OA\Property(property="end_document_page", type="integer", example=101),
 *                 @OA\Property(property="actual_document_page", type="integer", example=123),
 *                 @OA\Property(property="document_id", type="integer", example=1)
 *             ),
 *             @OA\Property(property="operation_result_then",
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description")
 *             ),
 *             @OA\Property(property="rule_based_knowledge_base",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="correctness", type="integer", example=0),
 *                 @OA\Property(property="author", type="integer", example=1),
 *                 @OA\Property(property="technical_system_id", type="integer", example=1)
 *             ),
 *             @OA\Property(property="malfunction_cause",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name")
 *             ),
 *             @OA\Property(property="malfunction_system",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="parent_technical_system_id", type="integer", example=1)
 *             ),
 *             @OA\Property(property="document",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="version", type="string", example="Some version"),
 *                 @OA\Property(property="file", type="string", example="Some path to file")
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Put(
 *     path="/api/v1/admin/operation-rules/{operation-rule}",
 *     summary="Обновить правило определения последовательности работ",
 *     tags={"Правила определения последовательности работ"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id правила определения последовательности работ",
 *         in="path",
 *         name="operation-rule",
 *         required=true,
 *         example=1
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="description", type="string", example="Some description for edit"),
 *                     @OA\Property(property="type", type="integer", example=1),
 *                     @OA\Property(property="priority", type="integer", example=200),
 *                     @OA\Property(property="repeat_voice", type="integer", example=0),
 *                     @OA\Property(property="context", type="string", example="Some operation code for edit"),
 *                     @OA\Property(property="operation_id_if", type="integer", example=10),
 *                     @OA\Property(property="operation_status_if", type="integer", example=1),
 *                     @OA\Property(property="operation_result_id_if", type="integer", example=3),
 *                     @OA\Property(property="operation_id_then", type="integer", example=11),
 *                     @OA\Property(property="operation_status_then", type="integer", example=1),
 *                     @OA\Property(property="operation_result_id_then", type="integer", example=4),
 *                     @OA\Property(property="rule_based_knowledge_base_id", type="integer", example=1),
 *                     @OA\Property(property="malfunction_cause_id", type="integer", example=2),
 *                     @OA\Property(property="malfunction_system_id", type="integer", example=10),
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
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="type", type="integer", example=1),
 *             @OA\Property(property="priority", type="integer", example=200),
 *             @OA\Property(property="repeat_voice", type="integer", example=0),
 *             @OA\Property(property="context", type="string", example="Some operation code"),
 *             @OA\Property(property="operation_id_if", type="integer", example=10),
 *             @OA\Property(property="operation_status_if", type="integer", example=1),
 *             @OA\Property(property="operation_result_id_if", type="integer", example=3),
 *             @OA\Property(property="operation_id_then", type="integer", example=11),
 *             @OA\Property(property="operation_status_then", type="integer", example=1),
 *             @OA\Property(property="operation_result_id_then", type="integer", example=4),
 *             @OA\Property(property="rule_based_knowledge_base_id", type="integer", example=1),
 *             @OA\Property(property="malfunction_cause_id", type="integer", example=2),
 *             @OA\Property(property="malfunction_system_id", type="integer", example=10),
 *             @OA\Property(property="document_id", type="integer", example=1),
 *             @OA\Property(property="operation_if",
 *                 @OA\Property(property="id", type="integer", example=10),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                 @OA\Property(property="verbal_name", type="string", example="Some verbal name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="document_section", type="string", example="Some document section"),
 *                 @OA\Property(property="document_subsection", type="string", example="Some document subsection"),
 *                 @OA\Property(property="start_document_page", type="integer", example=100),
 *                 @OA\Property(property="end_document_page", type="integer", example=101),
 *                 @OA\Property(property="actual_document_page", type="integer", example=123),
 *                 @OA\Property(property="document_id", type="integer", example=1)
 *             ),
 *             @OA\Property(property="operation_result_if",
 *                 @OA\Property(property="id", type="integer", example=3),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description")
 *             ),
 *             @OA\Property(property="operation_then",
 *                 @OA\Property(property="id", type="integer", example=11),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="imperative_name", type="string", example="Some imperative name"),
 *                 @OA\Property(property="verbal_name", type="string", example="Some verbal name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="document_section", type="string", example="Some document section"),
 *                 @OA\Property(property="document_subsection", type="string", example="Some document subsection"),
 *                 @OA\Property(property="start_document_page", type="integer", example=100),
 *                 @OA\Property(property="end_document_page", type="integer", example=101),
 *                 @OA\Property(property="actual_document_page", type="integer", example=123),
 *                 @OA\Property(property="document_id", type="integer", example=1)
 *             ),
 *             @OA\Property(property="operation_result_then",
 *                 @OA\Property(property="id", type="integer", example=4),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description")
 *             ),
 *             @OA\Property(property="rule_based_knowledge_base",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="correctness", type="integer", example=0),
 *                 @OA\Property(property="author", type="integer", example=1),
 *                 @OA\Property(property="technical_system_id", type="integer", example=1)
 *             ),
 *             @OA\Property(property="malfunction_cause",
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="name", type="string", example="Some name")
 *             ),
 *             @OA\Property(property="malfunction_system",
 *                 @OA\Property(property="id", type="integer", example=10),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="parent_technical_system_id", type="integer", example=1)
 *             ),
 *             @OA\Property(property="document",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="Some code"),
 *                 @OA\Property(property="name", type="string", example="Some name"),
 *                 @OA\Property(property="type", type="integer", example=0),
 *                 @OA\Property(property="version", type="string", example="Some version"),
 *                 @OA\Property(property="file", type="string", example="Some path to file")
 *             )
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *     path="/api/v1/admin/operation-rules/{operation-rule}",
 *     summary="Удалить правило определения последовательности работ",
 *     tags={"Правила определения последовательности работ"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="id правила определения последовательности работ",
 *         in="path",
 *         name="operation-rule",
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
class OperationRuleController extends Controller
{
    //
}
