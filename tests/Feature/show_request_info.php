<?php

// Get PUT/DELETE data.
\parse_str(\file_get_contents('php://input'), $inputData);

$requestMethod = $_SERVER['REQUEST_METHOD'];
$arr = [
    'basic_info' => [
        'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
        'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
        'HTTP_REFERER' => $_SERVER['HTTP_REFERER'],
        'REQUEST_METHOD' => $requestMethod,
    ],
    'GET' => $_GET,
    'POST' => $_POST,
    'PUT' => $requestMethod === 'PUT' ? $inputData : [],
    'DELETE' => $requestMethod === 'DELETE' ? $inputData : [],
    'PATCH' => $requestMethod === 'PATCH' ? $inputData : [],
    'OPTIONS' => $requestMethod === 'OPTIONS' ? $inputData : [],
    'FILES' => $_FILES,
    'COOKIE' => $_COOKIE,
    'SERVER' => $_SERVER,
];

echo \json_encode($arr);
