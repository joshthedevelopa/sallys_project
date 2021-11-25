<?php

class Router
{
    private static $_response;
    public static function parse($endpoint, $method, $data, $files)
    {
        self::$_response = new Response();
        switch ($endpoint->url) {
            case "users":
                self::$_response = UserService::render($endpoint->target, $method, $data, $files);
                break;

            case "backups":
                self::$_response = BackupService::render($endpoint->target, $method, $data, $files);
                break;

            case "auth":
                self::$_response = AdminService::auth($data);
                break;

            case "logout":
                self::$_response = AdminService::logout();
                break;

            case "update":
                self::$_response = AdminService::updateAdmin($endpoint->target, $method, $data, $files);
                break;

            case "admin":
                self::$_response = AdminService::render($endpoint->target, $method, $data, $files);
                break;

            default:
        }
    }

    public static function route()
    {
        return json_encode([
            "status" => self::$_response->status,
            "title" => self::$_response->title,
            "message" => self::$_response->message,
            "data" => self::$_response->data
        ]);
    }

}

