<?php

namespace inventory\controllers;

use inventory\lib\InputFilter;
use inventory\lib\alertHandler;


class indexController extends abstractController
{
    use InputFilter;

    private $alertHandler;

    public function __construct()
    {
        $this->alertHandler = alertHandler::getInstance();
    }

    public function defaultAction()
    {
        $this->_view();
    }
    public function registrationAction()
    {
        $this->_view();
    }
    public function loginAction()
    {
        $this->_view();
    }
}
