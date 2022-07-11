<?php

namespace App\Repositories;

use Core\Database;
use App\Requests\TaskRequest;
use App\Validators\TaskValidator;

class TaskRespository implements TaskRespositoryInterFace
{
    public function changeStatus($params)
    {
        $db = Database::getDbConn();

        $insert = "UPDATE tasks SET status = :status WHERE id = :id";

        $stmt = $db->prepare($insert);

        $stmt->bindParam(':status', $params->status);
        $stmt->bindParam(':id', $params->id);

        $stmt->execute();

        $response = new \stdClass();
        $response->success = true;
        $response->message = 'Update successful';
        return $response;
    }

    public function edit($id)
    {
        $db = Database::getDbConn();
        $stmt = $db->prepare('SELECT * FROM tasks WHERE id = :id');
        $stmt->bindParam(':id', $id);

        $stmt->execute();
        $result = $stmt->fetch();
        $e = new \stdClass();
        if ($result) {
            $e->id = $result['id'];
            $e->name = $result['name'];
            $e->start = $result['start'];
            $e->end = $result['end'];
            $e->status = $result['status'];
        }
        return $e;
    }

    public function store($params)
    {
        $taskRequest = new TaskRequest(
            $params->name,
            $params->start,
            $params->end,
            $params->status
        );
        $taskValidator = new TaskValidator($taskRequest);

        if (!$taskValidator->isValid()) {
            $response = new \stdClass();
            $response->success = false;
            $response->message = 'Invalid post data';
            return $response;
        }

        $db = Database::getDbConn();

        $insert = "INSERT INTO tasks (name, start, end, status) VALUES (:name, :start, :end, :status)";

        $stmt = $db->prepare($insert);

        $stmt->bindParam(':start', $params->start);
        $stmt->bindParam(':end', $params->end);
        $stmt->bindParam(':name', $params->name);
        $stmt->bindParam(':status', $params->status);

        $stmt->execute();

        $response = new \stdClass();
        $response->success = true;
        $response->id = $db->lastInsertId();
        $response->message = 'Created with id: '.$db->lastInsertId();

        return $response;
    }

    public function delete($id)
    {
        $db = Database::getDbConn();

        $insert = "DELETE FROM tasks WHERE id = :id";

        $stmt = $db->prepare($insert);

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $response = new \stdClass();
        $response->success = true;
        $response->message = 'Update successful';

        return $response;
    }

    public function update($id, $params)
    {
        $taskRequest = new TaskRequest(
            $params->name,
            $params->start,
            $params->end,
            $params->status
        );
        $taskValidator = new TaskValidator($taskRequest);

        if (!$taskValidator->isValid()) {
            $response = new \stdClass();
            $response->success = false;
            $response->message = 'Invalid post data';
            return $response;
        }

        $db = Database::getDbConn();

        $insert = "UPDATE tasks SET name = :name, start = :start, end = :end, status = :status WHERE id = :id";

        $stmt = $db->prepare($insert);

        $stmt->bindParam(':name', $params->name);
        $stmt->bindParam(':start', $params->start);
        $stmt->bindParam(':end', $params->end);
        $stmt->bindParam(':status', $params->status);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $response = new \stdClass();
        $response->success = true;
        $response->message = 'Update successful';

        return $response;
    }

    public function all()
    {
        $db = Database::getDbConn();

        $start = isset($_GET["start"]) ? $_GET["start"] : '2000-01-01';
        $end = isset($_GET["end"]) ? $_GET["end"] : '3000-01-01';
        $stmt = $db->prepare('SELECT * FROM tasks WHERE NOT ((end <= :start) OR (start >= :end))');

        $stmt->bindParam(':start', $start);
        $stmt->bindParam(':end', $end);

        $stmt->execute();
        $result = $stmt->fetchAll();
        $tasks = array();

        foreach ($result as $row) {
            $e = new \stdClass();
            $e->id = $row['id'];
            $e->text = $row['name'];
            $e->start = $row['start'];
            $e->end = $row['end'];
            $e->status = $row['status'];
            if ($e->status == 'Planning') {
                $e->backColor = '#e69138';
            } elseif ($e->status == 'Doing') {
                $e->backColor = '#3d85c6';
            } else {
                $e->backColor = '#6aa84f';
            }
            $tasks[] = $e;
        }

        return $tasks;
    }

    public function move($params)
    {
        $db = Database::getDbConn();

        $insert = "UPDATE tasks SET start = :start, end = :end WHERE id = :id";

        $stmt = $db->prepare($insert);

        $stmt->bindParam(':start', $params->newStart);
        $stmt->bindParam(':end', $params->newEnd);
        $stmt->bindParam(':id', $params->id);

        $stmt->execute();

        $response = new \stdClass();
        $response->success = true;
        $response->message = 'Update successful';

        return $response;
    }
}
