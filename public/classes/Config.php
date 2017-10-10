<?php

/**
 * Class Config
 * Used as an accessor to Globals
 * see init file for globals that are being set.
 */
class Config
{
    public static function get($path = null) {
        if($path) {
            $config = $GLOBALS['config'];
            $path = explode('/', $path);
            foreach ($path as $p) {
                if(isset($config[$p])) {
                    $config = $config[$p];
                } else {
                    return false;
                }
            }

            return $config;
        }

        return false;
    }
}