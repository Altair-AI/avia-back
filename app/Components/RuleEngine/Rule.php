<?php

namespace App\Components\RuleEngine;

class Rule
{
    // Типы правил
    const DISPOSABLE_TYPE = 0; // Одноразовое правило
    const REUSABLE_TYPE = 1;   // Многоразовое правило

    // Статус правила
    const IN_PROGRESS_STATUS = 0;   // В процессе выполнения
    const NO_OPERATION_STATUS = 1;  // Отсутствует факт работы
    const NO_STATUS_STATUS = 2;     // Отсутствует факт статуса работы
    const NO_RESULT_STATUS = 3;     // Отсутствует факт результата работы
    const DONE_STATUS = 4;          // Выполнено
    const NOT_COMPLETED_STATUS = 5; // Не выполнено (находится в рабочей памяти)

    // Статус работы
    const NOT_COMPLETED_OPERATION_STATUS = 0; // Не выполнена
    const COMPLETED_OPERATION_STATUS = 1;     // Выполнена
    const INITIATED_OPERATION_STATUS = 2;     // Инициирована

    private int $id;

    private int $type;

    private int $status;

    private int $priority;

    private int $repeat_voice;

    private int $operation_condition;

    private int $operation_status_condition;

    private int|null $operation_result_condition;

    private int $operation_action;

    private int $operation_status_action;

    private int|null $operation_result_action;

    public function __construct(int $id, int $type, int $status, int|null $priority, int $repeat_voice,
        int $operation_condition,int $operation_status_condition, int|null $operation_result_condition,
        int $operation_action, int $operation_status_action, int|null $operation_result_action)
    {
        $this->id = $id;
        $this->type = $type;
        $this->status = $status;
        $this->priority = isset($priority) ? $priority : 0;
        $this->repeat_voice = $repeat_voice;
        $this->operation_condition = $operation_condition;
        $this->operation_status_condition = $operation_status_condition;
        $this->operation_result_condition = $operation_result_condition;
        $this->operation_action = $operation_action;
        $this->operation_status_action = $operation_status_action;
        $this->operation_result_action = $operation_result_action;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    public function getRepeatVoice()
    {
        return $this->repeat_voice;
    }

    public function setRepeatVoice($repeat_voice)
    {
        $this->repeat_voice = $repeat_voice;
    }

    public function getOperationCondition()
    {
        return $this->operation_condition;
    }

    public function setOperationCondition($operation_condition)
    {
        $this->operation_condition = $operation_condition;
    }

    public function getOperationStatusCondition()
    {
        return $this->operation_status_condition;
    }

    public function setOperationStatusCondition($operation_status_condition)
    {
        $this->operation_status_condition = $operation_status_condition;
    }

    public function getOperationResultCondition()
    {
        return $this->operation_result_condition;
    }

    public function setOperationResultCondition($operation_result_condition)
    {
        $this->operation_result_condition = $operation_result_condition;
    }

    public function getOperationAction()
    {
        return $this->operation_action;
    }

    public function setOperationAction($operation_action)
    {
        $this->operation_action = $operation_action;
    }

    public function getOperationStatusAction()
    {
        return $this->operation_status_action;
    }

    public function setOperationStatusAction($operation_status_action)
    {
        $this->operation_status_action = $operation_status_action;
    }

    public function getOperationResultAction()
    {
        return $this->operation_result_action;
    }

    public function setOperationResultAction($operation_result_action)
    {
        $this->operation_result_action = $operation_result_action;
    }
}
