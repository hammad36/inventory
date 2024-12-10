<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;

class homeController extends abstractController
{
    public function defaultAction(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->_view([
            'user' => $_SESSION['user'] ?? null
        ]);
    }
}
