<?php

namespace inventory\controllers;

use inventory\controllers\AbstractController;

class LogoutController extends AbstractController
{
    public function defaultAction(): void
    {
        // Start the session if it hasn't been started yet
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Destroy the session to log the user out
        $_SESSION = []; // Clear session data
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy(); // Destroy the session

        // Redirect the user to the login page or home page
        header("Location: /home");
        exit;
    }
}
