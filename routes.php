<?php

$router->get('/calendar', function () {
    echo view('calendar');
});

$router->get('/', 'TaskController@all');
$router->get('/tasks/{id}/delete', 'TaskController@delete');

$router->get('/tasks/create', 'TaskController@create');
$router->post('/tasks/create', 'TaskController@store');

$router->get('/tasks/{id}/edit', 'TaskController@edit');
$router->post('/tasks/{id}', 'TaskController@update');

// API
$router->post('/api/v1/tasks/create', 'Api\TaskController@store');
$router->post('/api/v1/tasks/{id}/delete', 'Api\TaskController@delete');
$router->get('/api/v1/tasks', 'Api\TaskController@all');
$router->post('/api/v1/tasks/{id}/change-status', 'Api\TaskController@changeStatus');
$router->post('/api/v1/tasks/{id}/move', 'Api\TaskController@move');
