<?php

namespace App\Controllers\Api;

use App\Repositories\TaskRespositoryInterFace;

class TaskController
{
    protected $repository;

    public function __construct(TaskRespositoryInterFace $repository)
    {
        $this->repository = $repository;
    }

    public function changeStatus()
    {
        $json = file_get_contents('php://input');
        $params = json_decode($json);
        $response = $this->repository->changeStatus($params);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function store()
    {
        $json = file_get_contents('php://input');
        $params = json_decode($json);
        $params->status = 'Planning';
        $params->name = $params->text;
        $response = $this->repository->store($params);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function delete($id)
    {
        $response = $this->repository->delete($id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function all()
    {
        $response = $this->repository->all();
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function move()
    {
        $json = file_get_contents('php://input');
        $params = json_decode($json);
        $response = $this->repository->move($params);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
