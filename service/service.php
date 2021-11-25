<?php

// include_once HOST . 'core/init.php';

abstract class Service
{
    public static function render($end, $method, $data, $files)
    {

        switch ($method) {
            case "POST":
                return static::post(["data" => $data, "files" => $files], (int) $end);

            case "GET":
                return static::get($data, (int) $end);

            case "PUT":
                return static::put();

            case "DELETE":
                return static::delete($data, (int) $end);

            default:
                return new Response(
                    "INVALID_METHOD",
                    "Invalid URL",
                    "This endpoint does not exist"
                );
        }
    }

    protected static function get($data, $end)
    {
        return new Response(
            "INVALID_METHOD",
            "Invalid URL",
            "This endpoint does not exist"
        );
    }

    protected static function post($data, $id = null)
    {
        return new Response(
            "INVALID_METHOD",
            "Invalid URL",
            "This endpoint does not exist"
        );
    }

    protected static function put()
    {
        return new Response(
            "INVALID_METHOD",
            "Invalid URL",
            "This endpoint does not exist"
        );
    }

    protected static function delete($data, $id)
    {
        return new Response(
            "INVALID_METHOD",
            "Invalid URL",
            "This endpoint does not exist"
        );
    }
}
