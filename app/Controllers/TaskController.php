<?php

namespace App\Controllers;

use App\Repositories\TaskRespositoryInterFace;
use Core\Database;

class TaskController
{
    protected $repository;

    public function __construct(TaskRespositoryInterFace $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        $response = $this->repository->all();
        echo view('index', $response);
    }

    public function create()
    {
        echo view('create');
    }

    public function store()
    {
        $params = (object) $_POST;
        $response = $this->repository->store($params);

        echo Redirect('/');
    }

    public function edit($id)
    {
        $response = $this->repository->edit($id);
        echo view('edit', $response);
    }

    public function update($id)
    {
        $params = (object) $_POST;
        $response = $this->repository->update($id, $params);

        Redirect('/');
    }

    public function delete($id)
    {
        $response = $this->repository->delete($id);
        Redirect('/');
    }
}
