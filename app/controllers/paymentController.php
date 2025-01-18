<?php

namespace inventory\controllers;

use inventory\lib\alertHandler;
use inventory\lib\inputFilter;

class paymentController extends abstractController
{
    use inputFilter;

    private $alertHandler;

    public function __construct()
    {
        $this->alertHandler = alertHandler::getInstance();
    }

    public function defaultAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->_view();
    }
}
