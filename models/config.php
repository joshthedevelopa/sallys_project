<?php

class Config {
    static function get(string $path = "") : string {
        if($path) {
            $config = $GLOBALS['config'];
            $path = explode("/", $path);

            foreach ($path as $value) {
                if(isset($config[$value])) {
                    $config = $config[$value];
                }
            }
            
            return $config ?? "";
        } 

        return "";
    }
}