<?php

namespace App\Requests;

class TaskRequest implements TaskRequestInterface
{
    private $name;
    private $start;
    private $end;
    private $status;

    public function __construct($name, $start, $end, $status)
    {
        $this->name = $name;
        $this->start = $start;
        $this->end = $end;
        $this->status = $status;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function getStatus()
    {
        return $this->status;
    }
}
