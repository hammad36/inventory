<?php

namespace inventory\lib;

class autoload
{

    public static function autoload($className)
    {

        $className = str_replace('\\', DS, $className);

        $className = str_replace('inventory' . DS, '', $className);
        $className = $className . '.php';
        $fullPath = APP_PATH . $className;

        if (file_exists($fullPath)) {
            require_once $fullPath;
        }
    }
}
spl_autoload_register(__NAMESPACE__  . '\autoload::autoload');
