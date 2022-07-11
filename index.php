<?php

spl_autoload_register(function (string $class_name) {
    include_once __DIR__ . '/' . $class_name . '.php';
});

$router = new Core\Route();
include_once __DIR__ . '/routes.php';
include_once __DIR__ . '/RegisterContainer.php';
include_once __DIR__ . '/helpers-function.php';

$request_url = !empty($_GET['url']) ? '/' . $_GET['url'] : '/';

$method_url = !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';

$router->map($request_url, $method_url);
