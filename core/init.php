<?php

define("HOST", "../");

$GLOBALS['config'] = [
    "mysql" => [
        "host" => "127.0.0.1",
        "database" => "sally",
        "username" => "root",
        "password" =>  ""
    ],
];

spl_autoload_register(function ($class) {
    $class = strtolower($class);
    if (preg_match('/([a-zA-Z0-9]*)[Ss]ervice/', $class)) {
        try {
            if ($class == "service") {
                require_once HOST . "service/service.php";
            } else {
                require_once HOST . "service/" . str_replace("service", "_srv", $class) . ".php";
            }
        } catch (\Throwable $th) {
            if ($class == "service") {
                require_once "../service/service.php";
            } else {
                require_once "../service/" . str_replace("service", "_srv", $class) . ".php";
            }
        }
    } else {
        try {
            require_once HOST . "models/" . strtolower($class) . ".php";
        } catch (\Throwable $th) {
            require_once "../models/" . strtolower($class) . ".php";
        }
    }
});
