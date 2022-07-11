<?php

use Core\Container;

$container = new Container();
$container->bind(App\Repositories\TaskRespositoryInterFace::class, App\Repositories\TaskRespository::class);
