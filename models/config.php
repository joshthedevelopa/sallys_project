<?php

class Config
{
    static function get($path = "")
    {
        if ($path) {
            $config = $GLOBALS['config'];
            $path = explode("/", $path);

            foreach ($path as $value) {
                if (isset($config[$value])) {
                    $config = $config[$value];
                }
            }

            return $config ?? "";
        }

        return "";
    }
}

