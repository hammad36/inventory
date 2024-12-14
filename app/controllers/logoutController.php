<?php

namespace inventory\controllers;

use inventory\controllers\AbstractController;

class LogoutController extends AbstractController
{
    public function defaultAction(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();

        header("Location: /index");
        exit;
    }
}
