<?php

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}


define('APP_PATH', realpath(dirname(dirname(__FILE__))) . DS);
define('VIEWS_PATH', APP_PATH  . 'views' . DS);
define('TEMPLATE_PATH', APP_PATH  . 'template' . DS);
define('CSS', '/css/');
define('JS', '/js/');


define('DEBUG_MODE', true); // Set to false in production
define('IS_SECURE', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on');

defined('DATABASE_HOST_NAME')   ? null : define('DATABASE_HOST_NAME', 'localhost');
defined('DATABASE_USER_NAME')   ? null : define('DATABASE_USER_NAME', 'hammad');
// defined('DATABASE_USER_NAME')   ? null : define('DATABASE_USER_NAME', 'Mohamed');
defined('DATABASE_PASSWORD')   ? null : define('DATABASE_PASSWORD', 'My@2530');
// defined('DATABASE_PASSWORD')   ? null : define('DATABASE_PASSWORD', 'My@2530');
defined('DATABASE_DB_NAME')   ? null : define('DATABASE_DB_NAME', 'inventory');
defined('DATABASE_PORT_NAME')   ? null : define('DATABASE_PORT_NAME', 3306);
defined('DATABASE_CONN_DRIVER') ? null : define('DATABASE_CONN_DRIVER', 1);
//defined('DATABASE_CONN_DRIVER') ? null : define('DATABASE_CONN_DRIVER', 'mysql');
