<?php

namespace inventory\lib;

class autoload
{

    public static function autoload($className)
    {
        $className = str_replace('inventory', '', $className);
        $className = $className . '.php';

        if (file_exists(APP_PATH . $className)) {
            require_once APP_PATH . $className;
        }
    }
}
spl_autoload_register(__NAMESPACE__  . '\autoload::autoload');
