<?php

namespace App\Validators;

use App\Requests\TaskRequestInterface;

class TaskValidator
{
    const STATUS_VALIDS = [
        'Planning',
        'Doing',
        'Complete'
    ];

    private $taskRequest;
    

    public function __construct(TaskRequestInterface $taskRequest)
    {
        $this->taskRequest = $taskRequest;
    }

    public function isValid()
    {
        $isValid = $this->isNameValid() && $this->isStartValid() && $this->isEndValid() && $this->isStatusValid();
        return $isValid;
    }

    protected function isNameValid()
    {
        $isValid = (strlen($this->taskRequest->getName()) >= 1);
        return $isValid;
    }

    protected function isStartValid()
    {
        $isValid = self::isValidDate($this->taskRequest->getStart());
        return $isValid;
    }

    protected function isEndValid()
    {
        $isValid = self::isValidDate($this->taskRequest->getEnd());
        return $isValid;
    }

    protected function isStatusValid()
    {
         $isValid = in_array($this->taskRequest->getStatus(), self::STATUS_VALIDS);
        return $isValid;
    }

    private static function isValidDate($date)
    {
        return !!strtotime($date);
    }
}
