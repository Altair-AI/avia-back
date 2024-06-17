<?php

namespace App\Http\Controllers;

use App\Components\Helper;
use App\Components\RuleEngine\Rule;
use App\Components\RuleEngine\RuleEngine;
use App\Http\Requests\RuleEngine\InitializeRuleEngineRequest;
use App\Http\Requests\RuleEngine\RunRuleEngineRequest;
use App\Http\Resources\MalfunctionCauseOperation\MalfunctionCauseOperationResource;
use App\Http\Resources\Operation\OperationResource;
use App\Http\Resources\OperationResult\OperationResultResource;
use App\Models\CompletedOperation;
use App\Models\ExecutionRule;
use App\Models\ExecutionRuleQueue;
use App\Models\MalfunctionCauseOperation;
use App\Models\MalfunctionCauseRule;
use App\Models\MalfunctionCauseRuleIf;
use App\Models\MalfunctionCauseRuleThen;
use App\Models\Operation;
use App\Models\OperationRule;
use App\Models\OperationRuleList;
use App\Models\WorkSession;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class RuleEngineController extends Controller
{
    /**
     * Start rule engine and determine malfunction causes.
     *
     * @param InitializeRuleEngineRequest $request
     * @return JsonResponse|null
     */
    public function defineMalfunctionCauses(InitializeRuleEngineRequest $request)
    {
        // Формирование неуспешного ответа (причины неисправности не найдены)
        $result['code'] = 0;
        $result['message'] = "Malfunction causes could not be found.";
        $result['data'] = [];

        // Формирование массива с id кодов неисправности
        $malfunction_code_ids = [];
        $validated = $request->validated();
        foreach ($validated as $malfunction_code_id)
            if (is_numeric($malfunction_code_id))
                array_push($malfunction_code_ids, (int)$malfunction_code_id);

        // Поиск возможных правил определения причин неисправности по кодам
        $malfunction_cause_rules = MalfunctionCauseRule::whereIn('id',
            MalfunctionCauseRuleIf::select(['malfunction_cause_rule_id'])
            ->whereIn('malfunction_code_id', $malfunction_code_ids))->get();

        // Обход найденных возможных правил
        foreach ($malfunction_cause_rules as $rule) {
            // Подтверждение нахождения всех корректных кодов неисправности в условиях данного правила
            $confirmation = false;
            $mcr_if = MalfunctionCauseRuleIf::where('malfunction_cause_rule_id', $rule->id)->get();
            if (count($mcr_if) == count($malfunction_code_ids)) {
                $confirmation = true;
                foreach ($mcr_if as $condition)
                    if (!in_array($condition->malfunction_code_id, $malfunction_code_ids))
                        $confirmation = false;
            }

            // Правила по указанным кодам неисправности найдены
            if ($confirmation) {
                // Поиск действия правила
                $mcr_then = MalfunctionCauseRuleThen::where('malfunction_cause_rule_id', $rule->id)->first();
                // Поиск правил определения последовательности работ по контексту
                $operation_rules = OperationRule::where('context', $mcr_then->operation->code)->get();
                // Поиск начального правила определения последовательности работ по id работы из условия
                $initial_operation_rule = OperationRule::where('operation_id_if', $mcr_then->operation_id)
                    ->first();
                if ($initial_operation_rule) {
                    // Формирование успешного ответа (причины неисправности найдены)
                    $result['code'] = 2;
                    $result['message'] = "Malfunction causes were found.";
                    $work_session = null;
                    // Поиск рабочих сессий созданных авторизованным пользователем по правилу определения причин неисправности
                    $work_sessions = WorkSession::where('malfunction_cause_rule_id', $rule->id)
                        ->where('user_id', auth()->user()->id)->get();
                    foreach ($work_sessions as $workSession)
                        if ($workSession->status != WorkSession::DONE_RESOLVED_STATUS or
                            $workSession->status != WorkSession::DONE_NOT_RESOLVED_STATUS)
                            $work_session = $workSession;
                    if ($result['code'] == 2) {
                        // Создание новой рабочей сессии для выполнения правил работ, если она не была создана ранее
                        $work_session = WorkSession::create([
                            'status' => WorkSession::MALFUNCTION_CAUSE_DETECTED_STATUS,
                            'stop_time' => Carbon::now(),
                            'malfunction_cause_rule_id' => $rule->id,
                            'user_id' => auth()->user()->id
                        ]);
                        // Обход найденных правил работ
                        foreach ($operation_rules as $operation_rule) {
                            // Создание листа (массива) исходных правил
                            $operation_rule_list = OperationRuleList::create([
                                'status' => OperationRuleList::NOT_COMPLETED_STATUS,
                                'work_session_id' => $work_session->id,
                                'operation_rule_id' => $operation_rule->id
                            ]);
                            // Создание правила в очереди
                            if ($initial_operation_rule->id == $operation_rule->id)
                                ExecutionRuleQueue::create(['operation_rule_list_id' => $operation_rule_list->id]);
                        }
                    }
                    // Поиск причин неисправности по работе РУН
                    $mc_ops = MalfunctionCauseOperation::where('operation_id', $mcr_then->operation_id)->get();
                    // Добавление данных в ответ
                    $data['failed_technical_system'] = $mcr_then->technical_system;
                    $data['malfunction_causes'] = MalfunctionCauseOperationResource::collection($mc_ops);
                    $data['work_session'] = $work_session;
                    $result['data'] = $data;
                } else {
                    $result['code'] = 3;
                    $result['message'] = "Malfunction causes were found, but operation rules with the initial operation were not found.";
                    $result['data'] = [];
                }
            }
        }

        return response()->json($result);
    }

    /**
     * Run rule engine to determine the sequence of operations.
     *
     * @param RunRuleEngineRequest $request
     * @return JsonResponse|null
     */
    public function troubleshooting(RunRuleEngineRequest $request)
    {
        // Формирование ответа о рабочей сессии по умолчанию (непредвиденная ошибка)
        $result['code'] = RuleEngine::ERROR_CODE;
        $result['message'] = "Error! Something has gone wrong.";
        $result['data'] = [];

        $validated = $request->validated();

        $work_session = WorkSession::find($validated['work_session']);

        if (empty($work_session))
            return response()->json(['error' => 'The work session could not be found.'], 403);

        if ($work_session->status == WorkSession::MALFUNCTION_CAUSE_DETECTED_STATUS) {
            // Обновление статуса рабочей сессии
            $work_session->status = WorkSession::IN_PROGRESS_STATUS;
            $work_session->save();
            // Получение первой работы из списка
            $operation_rule_list = OperationRuleList::whereWorkSessionId($work_session->id)->first();
            // Создание первой выполненной работы по условию
            CompletedOperation::create([
                'operation_id' => $operation_rule_list->operation_rule->operation_id_if,
                'previous_operation_id' => null,
                'operation_status' => CompletedOperation::INITIATED_OPERATION_STATUS,
                'operation_result_id' => $operation_rule_list->operation_rule->operation_result_id_if,
                'work_session_id' => $work_session->id
            ]);
        }

        if ($work_session->status == WorkSession::IN_PROGRESS_STATUS) {
            /* Загрузка данных в машину вывода */
            $work_memory = [];
            $rule_queue = [];
            $execution_rule = null;
            foreach ($work_session->operation_rule_lists as $orl) {
                $rule = new Rule($orl->id, $orl->operation_rule->type,
                    $orl->status == OperationRuleList::NOT_COMPLETED_STATUS ? Rule::NOT_COMPLETED_STATUS :
                        Rule::DONE_STATUS,
                    $orl->operation_rule->priority, $orl->operation_rule->repeat_voice,
                    $orl->operation_rule->operation_id_if, $orl->operation_rule->operation_status_if,
                    $orl->operation_rule->operation_result_id_if, $orl->operation_rule->operation_id_then,
                    $orl->operation_rule->operation_status_then, $orl->operation_rule->operation_result_id_then);
                array_push($work_memory, $rule);
                foreach ($work_session->execution_rule_queues as $erq)
                    if ($erq->operation_rule_list_id == $orl->id)
                        array_push($rule_queue, $rule);
                foreach ($work_session->execution_rules as $er)
                    if ($er->status != ExecutionRule::DONE_RULE_STATUS and $er->operation_rule_list_id == $orl->id) {
                        $execution_rule = $rule;
                        $execution_rule->setStatus($er->status);
                        $execution_rule->setOperationStatusAction($er->operation_status);
                        $execution_rule->setOperationResultAction($er->operation_result_id);
                    }
            }

            // Поиск корневого узла начальной работы РУН для машины вывода
            $completed_parent_operation = CompletedOperation::where('work_session_id', $work_session->id)
                ->where('previous_operation_id', null)
                ->first();
            /* Запуск машины вывода и получение результата */
            $rule_engine = new RuleEngine(RuleEngine::IN_PROGRESS_CODE, $completed_parent_operation->operation_id,
                $work_memory, $rule_queue, $execution_rule);
            $operation_status = isset($validated['operation_status']) ? $validated['operation_status'] : null;
            $operation_result = isset($validated['operation_result']) ? $validated['operation_result'] : null;
            $rule_engine->run($operation_status, $operation_result);

            /* Представлние результатов работы машины вывода для ответа сервера */
            if ($rule_engine->getStatus() == RuleEngine::DONE_CODE) {
                $result['code'] = RuleEngine::DONE_CODE;
                $result['message'] = "The execution of rules completed successfully.";
                // Обновление статуса рабочей сессии
                $work_session->status = WorkSession::DONE_RESOLVED_STATUS;
                $work_session->save();
            }
            if ($rule_engine->getStatus() == RuleEngine::NO_OPERATION_CODE) {
                $result['code'] = RuleEngine::NO_OPERATION_CODE;
                $result['message'] = "The execution of rules completed unsuccessfully.";
                // Обновление статуса рабочей сессии
                $work_session->status = WorkSession::DONE_NOT_RESOLVED_STATUS;
                $work_session->save();
            }
            if ($rule_engine->getStatus() == RuleEngine::NO_STATUS_CODE) {
                $result['code'] = RuleEngine::NO_STATUS_CODE;
                $result['message'] = "The fact of operation status is incorrect.";
            }
            if ($rule_engine->getStatus() == RuleEngine::NO_RESULT_CODE) {
                $result['code'] = RuleEngine::NO_RESULT_CODE;
                $result['message'] = "The fact of operation result is incorrect.";
            }
            $data = [];
            foreach ($rule_engine->getCompletedOperations() as $operation) {
                $last_operation = CompletedOperation::whereWorkSessionId($work_session->id)
                    ->orderBy('id', 'DESC')
                    ->first();
                // Сохранение данных о выполненных работах и их результатах в БД
                CompletedOperation::create([
                    'operation_id' => $operation['operation'],
                    'previous_operation_id' => $last_operation->operation_id,
                    'operation_status' => $operation['operation_status'],
                    'operation_result_id' => $operation['operation_result'],
                    'work_session_id' => $work_session->id
                ]);
                // Сохранение данных о выполненных правилах в БД
                $execution_rule = ExecutionRule::where('operation_rule_list_id',
                    $operation['operation_rule_id'])
                    ->whereNotIn('operation_status', [ExecutionRule::DONE_RULE_STATUS])->first();
                if (isset($execution_rule)) {
                    $execution_rule->status = ExecutionRule::DONE_RULE_STATUS;
                    $execution_rule->operation_status = $operation['operation_status'];
                    $execution_rule->operation_result_id = $operation['operation_result'];
                    $execution_rule->save();
                } else
                    ExecutionRule::create([
                        'status' => ExecutionRule::DONE_RULE_STATUS,
                        'operation_id' => $operation['operation'],
                        'operation_status' => $operation['operation_status'],
                        'operation_result_id' => $operation['operation_result'],
                        'operation_rule_list_id' => $operation['operation_rule_id'],
                    ]);
                // Добавление работы из действия правила в массив (формирование списка названий работ)
                array_push($data, new OperationResource(Operation::find($operation['operation'])));
            }
            $result['data']['chain_operations'] = $data;

            /* Сохранение результатов работы машины вывода в БД */
            // Обновление статусов правил в массиве
            foreach ($rule_engine->getWorkMemory() as $rule)
                if ($rule->getStatus() == Rule::DONE_STATUS) {
                    $operation_rule_list = OperationRuleList::find($rule->getId());
                    $operation_rule_list->status = OperationRuleList::COMPLETED_STATUS;
                    $operation_rule_list->save();
                }
            // Обновление правил в очереди
            $operation_rule_list_ids = OperationRuleList::select('id')
                ->where('work_session_id', $work_session->id)
                ->get();
            ExecutionRuleQueue::whereIn('operation_rule_list_id', $operation_rule_list_ids)->delete();
            foreach ($rule_engine->getRuleQueue() as $rule)
                ExecutionRuleQueue::create(['operation_rule_list_id' => $rule->getId()]);
            // Добавление или обновление текущего выполняемого правила в БД
            $current_operation = null;
            $opr_res = [];
            $rule = $rule_engine->getExecutionRule();
            if (isset($rule)) {
                $execution_rule = ExecutionRule::where('operation_rule_list_id', $rule->getId())
                    ->whereNotIn('operation_status', [ExecutionRule::DONE_RULE_STATUS])
                    ->first();
                if (isset($execution_rule)) {
                    $execution_rule->status = $rule->getStatus();
                    $execution_rule->operation_status = $rule->getOperationStatusAction();
                    $execution_rule->operation_result_id = $rule->getOperationResultAction();
                    $execution_rule->save();
                } else
                    ExecutionRule::create([
                        'status' => $rule->getStatus(),
                        'operation_id' => $rule->getOperationAction(),
                        'operation_status' => $rule->getOperationStatusAction(),
                        'operation_result_id' => $rule->getOperationResultAction(),
                        'operation_rule_list_id' => $rule->getId(),
                    ]);
                // Добавление названия текущей работы, которую надо выполнить (если она есть)
                $last_execution_rule = ExecutionRule::where('operation_rule_list_id', $rule->getId())
                    ->whereNotIn('operation_status', [ExecutionRule::DONE_RULE_STATUS])
                    ->orderBy('id', 'DESC')
                    ->first();
                if ($last_execution_rule) {
                    $current_operation = new OperationResource(Operation::find($last_execution_rule->operation_id));
                    if ($last_execution_rule->operation_rule_list->operation_rule->operation_result_id_then != null)
                        $opr_res = OperationResultResource::collection(
                            $last_execution_rule->operation->operation_results
                        );
                }
            }
            $result['data']['current_operation'] = $current_operation;
            $result['data']['operation_results'] = $opr_res;
        }

        // Формирование дерева выполненных работ
        $result['data']['completed_operations'] = Helper::create_operation_tree($work_session->id);

        if ($work_session->status == WorkSession::DONE_RESOLVED_STATUS) {
            $result['code'] = RuleEngine::DONE_CODE;
            $result['message'] = "The execution of rules completed successfully.";
        }

        if ($work_session->status == WorkSession::DONE_NOT_RESOLVED_STATUS) {
            $result['code'] = RuleEngine::NO_OPERATION_CODE;
            $result['message'] = "The execution of rules completed unsuccessfully.";
        }

        return response()->json($result);
    }
}
