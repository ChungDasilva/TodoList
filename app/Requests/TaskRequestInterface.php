<?php

namespace App\Requests;

interface TaskRequestInterface
{
    public function getName();
    public function getStart();
    public function getEnd();
    public function getStatus();
}
