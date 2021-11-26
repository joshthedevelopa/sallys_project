<?php

class AdminService extends Service
{
    public static function logout()
    {
        Session::clear();
        return new Response(
            "OK",
            "Logout Request",
            "You have successfully logout of the account",
            []
        );
    }

    public static function auth($data)
    {
        if (isset($data['username']) && isset($data['password'])) {
            extract($data);

            $admin = new Admin();
            $admin = $admin->get(["username", "=", $username]);

            if ($admin->count() > 0) {
                $admin = new Admin();
                $admin = $admin->get([["username", "=", $username], ["password", "=", md5($password)]]);

                if ($admin->count() > 0) {
                    $admin = $admin->results(true, true);
                    Session::initialize("admin");
                    foreach ($admin as $key => $value) {
                        Session::set($key, $value);
                    }

                    return new Response(
                        "OK",
                        "Authorization Request",
                        "Authorization was successful!",
                        $admin
                    );
                }

                return new Response(
                    "ERROR",
                    "Authorization Request",
                    "Given credentials do not match any account!",
                    []
                );
            }

            return new Response(
                "ERROR",
                "Authorization Request",
                "This Administrator's account does not exist!",
                []
            );
        }

        return new Response(
            "ERROR",
            "Authorization Request",
            "All fields are required!",
            []
        );
    }

    public static function get($data, $end)
    {
        $user = new Admin();
        if (count($data) <= 0) {
            $data = null;
        }

        if($end == 0) {
            $end = null;
        }

        $user = $user->get($data ?? $end ?? (int) Session::get("id"));

        if (!$user->error()) {
            return new Response(
                "OK",
                "User Data",
                "User was updated successfully",
                $user->results(!isset($data), true)
            );
        }

        return new Response(
            "ERROR",
            "User Data",
            "User could not be retrieved successfully",
            []
        );
    }

    public static function updateAdmin($type, $method, $data, $files)
    {
        $admin = new Admin();
        $admin = $admin->get((int) Session::get("id"));

        if ($admin->count() > 0) {
            $admin_details = $admin->results(true);

            if ($type == "details") {
                if (isset($data["firstname"]) && isset($data['lastname'])) {
                    $_name = $data['firstname'] . " " . $data['lastname'];
                } else {
                    $_name = null;
                }

                $admin = new Admin();
                $admin = $admin->update([
                    "username" => $data['username'] ?? $admin_details->username,
                    "name" => $_name ?? $admin_details->name,
                ], $admin_details->id);

                if (!$admin->error()) {
                    $admin = new Admin();
                    $admin = $admin->get((int) Session::get("id"));
                    foreach ($admin->results(true, true) as $key => $value) {
                        Session::set($key, $value);
                    }

                    return new Response(
                        "OK",
                        "Account Update",
                        "Your account was updated successfully!",
                        []
                    );
                }
            } else if ($type == "password") {
                if (isset($data['current_password'])) {

                    if (isset($data['new_password']) && isset($data['confirm_password'])) {

                        if ($data['new_password'] == $data['confirm_password']) {
                            if (md5($data["current_password"]) == $admin_details->password) {
                                $admin = new Admin();
                                $admin = $admin->update([
                                    "password" => md5($data['new_password']),
                                ], $admin_details->id);

                                if (!$admin->error()) {

                                    return new Response(
                                        "OK",
                                        "Account Update",
                                        "Your account password was updated successfully!",
                                        []
                                    );
                                }
                            }

                            return new Response(
                                "ERROR",
                                "Account Update",
                                "Your current password was incorrect!",
                                []
                            );
                        }

                        return new Response(
                            "ERROR",
                            "Account Update",
                            "Please ensure your new password matches your old password",
                            []
                        );
                    }

                    return new Response(
                        "ERROR",
                        "Account Update",
                        "Please fill in both new and confirm password fields!",
                        []
                    );
                }

                return new Response(
                    "ERROR",
                    "Account Update",
                    "Please type in your current password!",
                    []
                );
            }
        }

        return new Response(
            "ERROR",
            "Account Update",
            "Error occured in updating your account!",
            []
        );
    }
}
