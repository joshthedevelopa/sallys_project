<?php

class UserService extends Service
{
    public static function get($data, $end)
    {
        $user = new User();
        if (count($data) <= 0) {
            $data = null;
        }
        $user = $user->get($data ?? $end);

        if (!$user->error()) {
            return new Response(
                "OK",
                "User Data",
                "User was updated successfully",
                $user->results(false, true)
            );
        }

        return new Response(
            "ERROR",
            "User Data",
            "User could not be retrieved successfully",
            []
        );
    }

    public static function post($data, $id = null)
    {
        $user = new User();
        extract($data);

        if (is_null($id) || $id == 0) {
            foreach ($data as $key => $value) {
                if (empty($value)) {
                    return new Response(
                        "ERROR",
                        "Backup Data",
                        "All flieds are required",
                        []
                    );
                }
            }

            $user = $user->create([
                "name" => $data["name"],
                "contact" => $data['contact'],
                "location" => $data['location'],
                "backup_quota" => $data['backup_quota']
            ]);
        } else {
            $user = $user->update([
                "name" => $data["name"],
                "contact" => $data['contact'],
                "location" => $data['location'],
                "backup_quota" => $data['backup_quota']
            ], $id);
        }

        if (!$user->error()) {
            return new Response(
                "OK",
                is_null($id) ? "User Registration" : "User Update",
                is_null($id) ? "User was created successfully" : "User was updated successfully",
                is_null($id) ? [] : [
                    "id" => $user->id()
                ]
            );
        }

        return new Response(
            "ERROR",
            "User Registration",
            "User could not be created successfully",
            []
        );
    }

    public static function delete($data, $id)
    {
        $user = new User();
        if (count($data) <= 0) {
            $data = null;
        }
        $user = $user->get($data ?? $id);

        if (!$user->error()) {
            if ($user->count() > 0) {
                $user_details = $user->results(true);

                if (!$user->error()) {
                    $backup = new Backup();
                    $backup = $backup->get(["user_id", "=", (int) $user_details->id]);

                    if (!$backup->error()) {
                        foreach ($backup->results() as $key => $value) {
                            try {
                                unlink("../uploads/" . $value->backup_filename);
                            } catch (\Throwable $th) {
                                continue;
                            }
                        }
                    }

                    $backup = new Backup();
                    $backup = $backup->delete(["user_id", "=", (int) $user_details->id]);

                    if ($backup->error()) {
                        return new Response(
                            "ERROR",
                            "Backup Data",
                            "Your data could not be deleted successfully",
                            []
                        );
                    }

                    $users = new User();
                    $users = $users->delete($data ?? $id);

                    if (!$user->error()) {
                        return new Response(
                            "OK",
                            "User Deletion",
                            "User was deleted successfully",
                            []
                        );
                    }

                    return new Response(
                        "ERROR",
                        "User Deletion",
                        "User could not be deleted successfully",
                        []
                    );
                }
            }
        }

        return new Response(
            "ERROR",
            "User Deletion",
            "User could not be deleted successfully",
            []
        );
    }
}
