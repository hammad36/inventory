<?php

namespace inventory;

use inventory\lib\frontController;
use inventory\lib\template;

// ==================== [1] BASIC CONFIGURATION ====================
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

// ==================== [2] ENVIRONMENT SETUP ====================
// Load composer autoloader first
require_once __DIR__ . DS . '..' . DS . 'vendor' . DS . 'autoload.php';

// Load configuration files
require_once '..' . DS . 'app' . DS . 'config' . DS . 'config.php';
require_once APP_PATH . 'lib' . DS . 'autoload.php';

// ==================== [3] ERROR HANDLING ====================
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// ==================== [4] SESSION MANAGEMENT ====================
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_secure' => IS_SECURE, // Requires HTTPS
        'cookie_httponly' => true,
        'use_strict_mode' => true
    ]);
}

// ==================== [5] SECURITY HEADERS ====================
header("Content-Security-Policy: default-src 'self' https: 'unsafe-inline' 'unsafe-eval'");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("Referrer-Policy: strict-origin-when-cross-origin");

// ==================== [6] FORCE HTTPS IN PRODUCTION ====================
if (!IS_SECURE && !DEBUG_MODE) {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

// ==================== [7] APPLICATION BOOTSTRAP ====================
try {
    $templateParts = require_once '..' . DS . 'app' . DS . 'config' . DS . 'templateConfig.php';
    $template = new template($templateParts);
    $frontController = new frontController($template);
    $frontController->dispatch();
} catch (\Throwable $e) {
    // Log error and show generic message
    error_log("Critical Error: " . $e->getMessage());
    http_response_code(500);
    die('<h1>Application Error</h1><p>Please try again later.</p>');
}
