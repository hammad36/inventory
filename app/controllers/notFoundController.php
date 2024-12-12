<?php

namespace inventory\controllers;

class notFoundController extends abstractController
{
    public function notFoundAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->_view();
    }
}
