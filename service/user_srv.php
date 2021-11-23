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
        extract($data);

        if (is_null($id) || $id == 0) {
            foreach ($data as $key => $value) {
                if (empty($value)) {
                    return new Response(
                        status: "ERROR",
                        title: "Backup Data",
                        message: "All flieds are required",
                        data: [],
                    );
                }
            }

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
        if (count($data) <= 0) {
            $data = null;
        }
        $user = $user->get($data ?? $id);

        if (!$user->error()) {
            if($user->count() > 0) {
                $user_details = $user->results(true);

                if(!$user->error()) {
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
                            status: "ERROR",
                            title: "Backup Data",
                            message: "Your data could not be deleted successfully",
                            data: []
                        );
                    }

                    $users = new User();
                    $users = $users->delete($data ?? $id);

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
        }

        return new Response(
            status: "ERROR",
            title: "User Deletion",
            message: "User could not be deleted successfully",
            data: [],
        );
    }
}
