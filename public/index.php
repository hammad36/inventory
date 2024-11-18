<?php

namespace inventory;

use inventory\lib\frontController;
use inventory\lib\template;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

require_once '..' . DS . 'app' . DS . 'config' . DS . 'config.php';
require_once APP_PATH . 'lib' . DS . 'autoload.php';
$templateParts = require_once '..' . DS . 'app' . DS . 'config' . DS . 'templateConfig.php';

$template = new template($templateParts);
$frontController = new frontController($template);
$frontController->dispatch();
