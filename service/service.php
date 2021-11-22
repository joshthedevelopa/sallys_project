<?php

// include_once HOST . 'core/init.php';

abstract class Service
{    
    public static function render(string $end, string $method, array $data, array $files)
    {

        switch ($method) {
            case "POST":
                return static::post(["data" => $data, "files" => $files], $end);

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

    protected static function get(array $data, int $end)
    {
        return new Response(
            "INVALID_METHOD",
            "Invalid URL",
            "This endpoint does not exist"
        );
    }

    protected static function post(array $data, int|null $id = null)
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

    protected static function delete(array $data, int|null $id)
    {
        return new Response(
            "INVALID_METHOD",
            "Invalid URL",
            "This endpoint does not exist"
        );
    }
}
