<?php

namespace App\Components\RuleEngine;

class RuleEngine
{
    // Код выполнения правил в машине вывода
    const DONE_CODE = 0;         // Успешное завершение цепочки правил
    const NO_OPERATION_CODE = 1; // Неверная работа
    const NO_STATUS_CODE = 2;    // Неверный статус работы
    const NO_RESULT_CODE = 3;    // Неверный результат работы
    const ERROR_CODE = 4;        // Непредвиденная ошибка
    const IN_PROGRESS_CODE = 5;  // В процессе выполнения правил

    private int $status;

    private array $work_memory;

    private array $rule_queue;

    private Rule|null $execution_rule;

    private array $completed_operations;

    public function __construct(int $status, array $work_memory, array $rule_queue = [], Rule $execution_rule = null,
                                array $completed_operations = [])
    {
        $this->status = $status;
        $this->work_memory = $work_memory;
        $this->rule_queue = $rule_queue;
        $this->execution_rule = $execution_rule;
        $this->completed_operations = $completed_operations;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getWorkMemory()
    {
        return $this->work_memory;
    }

    public function getRuleQueue()
    {
        return $this->rule_queue;
    }

    public function getExecutionRule()
    {
        return $this->execution_rule;
    }

    public function getCompletedOperations()
    {
        return $this->completed_operations;
    }

    /**
     * Продвижение правил в машине вывода (обновление правил в рабочей памяти, очереди и обнуление
     * текущего выполняемого правила.
     */
    public function refresh() {
        // Удаление текущего выполняемого правила из очереди
        foreach ($this->rule_queue as $key => $rule)
            if ($rule->getId() == $this->execution_rule->getId())
                unset($this->rule_queue[$key]);
        // Замена статуса правила в рабочей памяти на выполнено
        foreach ($this->work_memory as $rule) {
            if ($rule->getId() == $this->execution_rule->getId() and $rule->getType() == Rule::DISPOSABLE_TYPE)
                $rule->setStatus(Rule::DONE_STATUS);
            if ($rule->getId() == $this->execution_rule->getId() and $rule->getType() == Rule::REUSABLE_TYPE)
                $rule->setStatus(Rule::NOT_COMPLETED_STATUS);
        }
        // Добавление выполненной работы и ее результата в общий массив выполненных работ
        $operation['operation'] = $this->execution_rule->getOperationAction();
        $operation['operation_status'] = $this->execution_rule->getOperationStatusAction();
        $operation['operation_result'] = $this->execution_rule->getOperationResultAction();
        $operation['operation_rule_id'] = $this->execution_rule->getId();
        array_push($this->completed_operations, $operation);
        // Обнуление текущего выполняемого правила
        $this->execution_rule = null;
    }

    /**
     * Запуск машины вывода.
     *
     * @param int|null $operation_status - новый статус работы
     * @param int|null $operation_result - новый результат работы
     */
    public function run(int|null $operation_status, int|null $operation_result) {
        // Обработка правил в очереди
        while (!empty($this->rule_queue)) {

            // Если текущее выполняемое правило существует, то меняем факты статуса и результата работы
            if (isset($this->execution_rule)) {
                if ($this->execution_rule->getStatus() == Rule::NO_STATUS_STATUS and isset($operation_status))
                    $this->execution_rule->setOperationStatusAction($operation_status);
                if ($this->execution_rule->getStatus() == Rule::NO_RESULT_STATUS and isset($operation_result))
                    $this->execution_rule->setOperationResultAction($operation_result);
            } else {
                $this->execution_rule = end($this->rule_queue);
                $this->execution_rule->setStatus(Rule::IN_PROGRESS_STATUS);
            }

            // Нахождение правил у которых совпадают все три факта (работа, статус и результат работы)
            $found_rules = [];
            foreach ($this->work_memory as $rule)
                if ($rule->getStatus() == Rule::NOT_COMPLETED_STATUS and
                    $rule->getOperationCondition() == $this->execution_rule->getOperationAction() and
                    $rule->getOperationStatusCondition() == $this->execution_rule->getOperationStatusAction() and
                    $rule->getOperationResultCondition() == $this->execution_rule->getOperationResultAction())
                    if (empty($found_rules))
                        array_push($found_rules, $rule);
                    else {
                        if ($found_rules[0]->getPriority() == $rule->getPriority())
                            array_push($found_rules, $rule);
                        if ($found_rules[0]->getPriority() < $rule->getPriority())
                            $found_rules = [$rule];
                    }

            if (empty($found_rules)) {
                // Поиск правил у которых не совпадают факты работы, статуса и результата работы
                $operation_exists = false;
                $operation_status_exists = false;
                foreach ($this->work_memory as $rule)
                    if ($rule->getStatus() == Rule::NOT_COMPLETED_STATUS)
                        if ($rule->getOperationCondition() == $this->execution_rule->getOperationAction()) {
                            $operation_exists = true;
                            if ($rule->getOperationStatusCondition() == $this->execution_rule->getOperationStatusAction())
                                $operation_status_exists = true;
                        }
                // Если нет совпадения факта работы
                if ($operation_exists == false)
                    if ($this->execution_rule->getOperationStatusAction() == Rule::COMPLETED_OPERATION_STATUS)
                        self::refresh();
                    else {
                        $this->status = self::NO_OPERATION_CODE;
                        $this->execution_rule->setStatus(Rule::NO_OPERATION_STATUS);
                        break;
                    }
                // Если нет совпадения факта статуса работы
                if ($operation_exists == true and $operation_status_exists == false) {
                    $this->status = self::NO_STATUS_CODE;
                    $this->execution_rule->setStatus(Rule::NO_STATUS_STATUS);
                    break;
                }
                // Если нет совпадения факта результата работы
                if ($operation_exists == true and $operation_status_exists == true) {
                    $this->status = self::NO_RESULT_CODE;
                    $this->execution_rule->setStatus(Rule::NO_RESULT_STATUS);
                    break;
                }
            } else {
                // Добавление найденных правил в очередь
                foreach ($found_rules as $found_rule)
                    array_push($this->rule_queue, $found_rule);
                self::refresh();
            }
        }

        if (empty($this->rule_queue))
            $this->status = self::DONE_CODE;
    }
}
