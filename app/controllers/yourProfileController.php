<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;

class yourProfileController extends abstractController
{
    public function defaultAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->_view([
            'user' => $_SESSION['user'] ?? null
        ]);
    }
}
