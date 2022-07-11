<?php

namespace App\Repositories;

interface TaskRespositoryInterFace
{
    public function changeStatus($params);
    public function edit($id);
    public function store($params);
    public function delete($id);
    public function update($id, $params);
    public function all();
    public function move($params);
}
