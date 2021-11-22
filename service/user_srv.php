<?php

class UserService extends Service
{
    public static function get(array $data, int $end)
    {
        $user = new User();
        if(count($data) <= 0) {
            $data = null;
        }
        $user = $user->get($data ?? $end);

        if (!$user->error()) {
            return new Response(
                status: "OK",
                title: "User Data",
                message: "User was updated successfully",
                data: $user->results(false, true)
            );
        }

        return new Response(
            status: "ERROR",
            title: "User Data",
            message: "User could not be retrieved successfully",
            data: [],
        );
    }

    public static function post(array $data, int|null $id = null)
    {
        $user = new User();

        if (is_null($id)) {
            $user = $user->create([
                "name" => $data["name"],
                "contact" => $data['contact'],
                "location" => $data['location'],
                "backup_quota" => $data['backup_quota'],
            ]);
        } else {
            $user = $user->update([
                "name" => $data["name"],
                "contact" => $data['contact'],
                "location" => $data['location'],
                "backup_quota" => $data['backup_quota'],
            ], $id);
        }

        if (!$user->error()) {
            return new Response(
                status: "OK",
                title: is_null($id) ? "User Registration" : "User Update",
                message: is_null($id) ? "User was created successfully" : "User was updated successfully",
                data: is_null($id) ? [] : [
                    "id" => $user->id()
                ],
            );
        }

        return new Response(
            status: "ERROR",
            title: "User Registration",
            message: "User could not be created successfully",
            data: [],
        );
    }

    public static function delete(array $data, int|null $id)
    {
        $user = new User();
        $user = $user->delete($end ?? $data);

        if (!$user->error()) {
            return new Response(
                status: "OK",
                title: "User Deletion",
                message: "User was deleted successfully",
                data: []
            );
        }

        return new Response(
            status: "ERROR",
            title: "User Deletion",
            message: "User could not be deleted successfully",
            data: [],
        );
    }
}
