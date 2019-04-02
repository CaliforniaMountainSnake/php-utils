<?php

$arr = [
    'basic_info' => [
        'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
        'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
        'HTTP_REFERER' => $_SERVER['HTTP_REFERER'],
        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
    ],
    'GET' => $_GET,
    'POST' => $_POST,
    'FILES' => $_FILES,
    'COOKIE' => $_COOKIE,
    'SERVER' => $_SERVER,
];


echo \json_encode($arr);
