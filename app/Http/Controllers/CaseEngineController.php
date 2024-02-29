<?php

namespace App\Http\Controllers;

use App\Components\CaseEngine;
use App\Http\Requests\CaseEngine\InitializeCaseEngineRequest;
use App\Http\Requests\CaseEngine\StoreCaseEngineRequest;
use App\Models\CaseBasedKnowledgeBase;
use App\Models\CompletedOperation;
use App\Models\ECase;
use App\Models\MalfunctionCode;
use App\Models\MalfunctionCodeCase;
use App\Models\OperationRule;
use App\Models\RealTimeTechnicalSystemUser;
use Illuminate\Http\JsonResponse;

class CaseEngineController extends Controller
{
    /**
     * Start case engine and get cases by malfunction codes.
     *
     * @param InitializeCaseEngineRequest $request
     * @return JsonResponse|null
     */
    public function getCases(InitializeCaseEngineRequest $request)
    {
        // Формирование массива идентификаторов технических систем реального времени, которые доступны технику
        $real_time_technical_system_ids = [];
        $user_tech_sys = RealTimeTechnicalSystemUser::where('user_id', auth()->user()->id)->get();
        foreach ($user_tech_sys as $uts)
            array_push($real_time_technical_system_ids, $uts->real_time_technical_system_id);
        // Поиск всех прецедентов для технических систем реального времени, которые доступны технику
        $cases = ECase::whereIn('system_id_for_repair', $real_time_technical_system_ids)->get();
        $items = [];
        foreach ($cases as $case) {
            // Поиск всех кодов неисправности для текущего прецедента
            $malfunction_codes = MalfunctionCode::whereIn('id',
                MalfunctionCodeCase::select(['malfunction_code_id'])->where('case_id', $case->id))->get();
            // Формирование массива прецедентов с кодами неисправности
            $item = [];
            foreach ($malfunction_codes as $malfunction_code)
                $item[$malfunction_code->type] = $malfunction_code->name;
            $items[$case->id] = $item;
        }

        // Формирование массива с id кодов неисправности
        $malfunction_code_ids = [];
        $validated = $request->validated();
        foreach ($validated as $malfunction_code_id)
            if (is_numeric($malfunction_code_id))
                array_push($malfunction_code_ids, (int)$malfunction_code_id);
        // Поиск кодов неисправности по id
        $malfunction_codes = MalfunctionCode::whereIn('id', $malfunction_code_ids)->get();
        // Формирование массива шаблона прецедента с найденными кодами неисправности
        $pattern = [];
        foreach ($malfunction_codes as $malfunction_code)
            $pattern[$malfunction_code->type] = $malfunction_code->name;

        // Выполнение поиска прецедентов
        $case_scores = CaseEngine::execute($pattern, $items);
        if ($case_scores) {
            $data = [];
            foreach ($case_scores as $case_id => $score)
                if ($score != 0) {
                    $case = ECase::find($case_id);
                    $item = [];
                    $item['id'] = $case->id;
                    $item['malfunction_cause_name'] = $case->malfunction_cause->name;
                    $item['score'] = $score;
                    array_push($data, $item);
                }
            if ($data) {
                // Формирование ответа (прецеденты найдены и их оценки не нулевые)
                $result['code'] = 2;
                $result['message'] = 'Cases have been found.';
                $result['data'] = $data;
            } else {
                // Формирование ответа (прецеденты найдены, но все их оценки нулевые)
                $result['code'] = 1;
                $result['message'] = 'All cases have a zero scoring.';
                $result['data'] = [];
            }
        } else {
            // Формирование ответа (прецеденты не найдены)
            $result['code'] = 0;
            $result['message'] = 'No cases have been found.';
            $result['data'] = [];
        }

        return response()->json($result);
    }

    /**
     * Create a newly case in storage.
     *
     * @param StoreCaseEngineRequest $request
     * @return JsonResponse
     */
    public function createCase(StoreCaseEngineRequest $request)
    {
        $validated = $request->validated();
        // Поиск выполненной начальной работы по id рабочей сессии
        $initial_operation = CompletedOperation::where('work_session_id', $validated['work_session_id'])
            ->where('previous_operation_id', null)
            ->first();
        // Поиск последней выполненной работы по id рабочей сессии
        $last_operation = CompletedOperation::where('work_session_id', $validated['work_session_id'])
            ->orderBy('id', 'DESC')
            ->first();
        // Поиск правила определения работ по id работы в условии
        $operation_rule = OperationRule::where('operation_id_if', $last_operation->operation_id)->first();
        // Поиск базы знаний прецедентов на основе id технической системы реального времени
        $case_based_knowledge_base = CaseBasedKnowledgeBase::where('real_time_technical_system_id',
            $validated['real_time_technical_system_id'])->first();
        // Создание нового прецедента
        $case = ECase::create([
            'date' => $validated['date'],
            'card_number' => $validated['card_number'],
            'operation_time_from_start' => (int)$validated['operation_time_from_start'],
            'operation_time_from_last_repair' => (int)$validated['operation_time_from_last_repair'],
            'malfunction_detection_stage_id' => (int)$validated['malfunction_detection_stage_id'],
            'malfunction_cause_id' => $operation_rule->malfunction_cause_id,
            'system_id_for_repair' => (int)$validated['real_time_technical_system_id'],
            'initial_completed_operation_id' => $initial_operation->operation_id,
            'case_based_knowledge_base_id' => $case_based_knowledge_base->id
        ]);
        return response()->json($case);
    }
}
