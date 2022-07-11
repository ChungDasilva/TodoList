<?php

function view($path, $data = array())
{
    $path = __DIR__ . "/views/{$path}.v.php";
    if (!file_exists($path)) {
        throw new \Exception("Error view file!");
    }

    ob_start();
    include($path);
    $content = ob_get_clean();

    return $content;
}

function redirect($url, $statusCode = 303)
{
    header('Location: ' . $url, true, $statusCode);
    die();
}
