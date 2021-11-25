<?php

class BackupService extends Service
{

    public static function get($data, $end)
    {
        $backups = new Backup();
        if (count($data) <= 0) {
            $data = null;
        }
        $backups = $backups->get($data ?? $end);

        if (!$backups->error()) {
            return new Response(
                "OK",
                "Backup Data",
                "Backup was retrieved successfully",
                $backups->results(false, true)
            );
        }

        return new Response(
            "ERROR",
            "Backup Data",
            "Backup could not be retrieved successfully",
            []
        );
    }

    public static function post($data, $id = null)
    {
        $backups = new Backup();
        $datetime = date("Y-m-d_H:i:s");

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

            if (!isset($files) || count($files) <= 0) {
                return new Response(
                    "ERROR",
                    "Backup Data",
                    "Backup file is required",
                    []
                );
            }
        }

        if (isset($files) && count($files) > 0) {
            $fileName = $files['name'];
            $size = round($files['size'] / (1024 * 1024), 4);
            $type = $files['type'];
            $file = $files['tmp_name'];

            $new_filename = str_replace(":", "_", str_replace("-", "_", $datetime)) . "__" . $fileName;

            if (!move_uploaded_file($file, "../uploads/" . $new_filename)) {
                return new Response(
                    "ERROR",
                    "Backup Data",
                    "File could not be uploaded to our server",
                    [],
                );
            }
        }

        if (is_null($id) || $id == 0) {
            $user = new User();
            $user = $user->get((int) $data['user']);

            if ($user->error()) {
                return new Response(
                    "ERROR",
                    "Backup Data",
                    "User does not exist",
                    []
                );
            }

            $user_details = $user->results(true);

            $user = new User();
            $user = $user->update([
                "backup_size" => $user_details->backup_size + ($size ?? 0)
            ], $user_details->id);

            if ($user->error()) {
                return new Response(
                    "ERROR",
                    "Backup Data",
                    "Your data could not be backedup successfully",
                    []
                );
            }

            $backups = $backups->create([
                "user_id" => $data['user'],
                "name" => $data['name'],
                "description" => $data['description'],
                "backup_filename" => $new_filename ?? "",
                "backup_size" => $size ?? "",
                "date_created" => str_replace("_", " ", $datetime)
            ]);
        } else {
            $backups = $backups->update([
                "name" => $data['name'],
                "description" => $data['description'],
            ], $id);
        }

        if (!$backups->error()) {
            return new Response(
                "OK",
                "Backup Data",
                "Your data was backedup successfully",
                $backups->results(false, true)
            );
        }

        return new Response(
            "ERROR",
            "Backup Data",
            "Your data could not be backedup successfully",
            $backups->results(false, true)
        );
    }

    public static function delete($data, $id)
    {
        $backups = new Backup();
        if (count($data) <= 0) {
            $data = null;
        }
        $backups = $backups->get($data ?? $id);

        if (!$backups->error()) {
            if ($backups->count() > 0) {
                $backup_details = $backups->results(true);

                $backups = new Backup();
                $backups = $backups->delete($data ?? $id);

                if (!$backups->error()) {
                    $user = new User();
                    $user = $user->get((int) $backup_details->user_id);

                    if ($user->error()) {
                        return new Response(
                            "ERROR",
                            "Backup Data",
                            "User does not exist",
                            []
                        );
                    }

                    $user_details = $user->results(true);

                    $user = new User();
                    $user = $user->update([
                        "backup_size" => $user_details->backup_size - ($backup_details->backup_size ?? 0)
                    ], $user_details->id);

                    if ($user->error()) {
                        return new Response(
                            "ERROR",
                            "Backup Data",
                            "Your data could not be deleted successfully",
                            []
                        );
                    }

                    if (!unlink("../uploads/" . $backup_details->backup_filename)) {
                        return new Response(
                            "ERROR",
                            "Backup Data",
                            "File could not be uploaded to our server",
                            [],
                        );
                    }

                    return new Response(
                        "OK",
                        "Backup Data",
                        "Backup was deleted successfully",
                        []
                    );
                }
            }
        }

        return new Response(
            "ERROR",
            "Backup Data",
            "Backup could not be delected successfully",
            [],
        );
    }
}
