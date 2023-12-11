<?php

namespace App\Http\Controllers;

use App\Http\Requests\RuleEngine\InitializeRuleEngineRequest;
use App\Models\ExecutionRuleQueue;
use App\Models\MalfunctionCauseRule;
use App\Models\MalfunctionCauseRuleIf;
use App\Models\MalfunctionCauseRuleThen;
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

            // Правила по указанным кодам неисправности действительно найдено
            if ($confirmation) {
                // Формирование успешного ответа (причины неисправности найдены)
                $result['code'] = 2;
                $result['message'] = "Malfunction causes were found.";
                // Поиск действия правила
                $mcr_then = MalfunctionCauseRuleThen::where('malfunction_cause_rule_id', $rule->id)->first();
                // Поиск рабочих сессий созданных авторизованным пользователем по правилу определения причин неисправности
                $work_sessions = WorkSession::where('malfunction_cause_rule_id', $rule->id)
                    ->where('user_id', auth()->user()->id)->get();
                foreach ($work_sessions as $work_session) {
                    if ($work_session->status != WorkSession::DONE_STATUS) {
                        // Формирование неуспешного ответа (выполнение правил уже запущено)
                        $result['code'] = 1;
                        $result['message'] = "Rule execution has already started.";
                        $data = [];
                        $data['failed_technical_system'] = $mcr_then->technical_system;
                        $data['malfunction_causes'] = $rule->malfunction_causes;
                        $data['work_session'] = $work_session;
                        $result['data'] = $data;
                    }
                }
                if ($result['code'] == 2) {
                    // Создание новой рабочей сессии для выполнения правил работ, если она не была создана ранее
                    $work_session = WorkSession::create([
                        'status' => WorkSession::MALFUNCTION_CAUSE_DETECTED_STATUS,
                        'stop_time' => Carbon::now(),
                        'malfunction_cause_rule_id' => $rule->id,
                        'user_id' => auth()->user()->id
                    ]);
                    // Добавление данных в ответ
                    $data = [];
                    $data['failed_technical_system'] = $mcr_then->technical_system;
                    $data['malfunction_causes'] = $rule->malfunction_causes;
                    $data['work_session'] = $work_session;
                    $result['data'] = $data;
                    // Поиск правил определения последовательности работ по контексту
                    $operation_rules = OperationRule::where('context', $mcr_then->operation->code)->get();
                    // Поиск начального правила определения последовательности работ по id работы из условия
                    $operation_rule_id = OperationRule::where('operation_id_if', $mcr_then->operation_id)
                        ->first()->id;
                    // Обход найденных правил работ
                    foreach ($operation_rules as $operation_rule) {
                        // Создание листа (массива) исходных правил
                        $operation_rule_list = OperationRuleList::create([
                            'status' => OperationRuleList::NOT_COMPLETED_STATUS,
                            'work_session_id' => $work_session->id,
                            'operation_rule_id' => $operation_rule->id
                        ]);
                        // Создание правила в очереди
                        if ($operation_rule_id == $operation_rule->id)
                            ExecutionRuleQueue::create(['operation_rule_list_id' => $operation_rule_list->id]);
                    }
                }
            }
        }

        return response()->json($result);
    }
}
