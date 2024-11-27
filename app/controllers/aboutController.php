<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;

class about extends abstractController
{
    public function defaultAction()
    {
        echo 'hello';
        $this->_view();
    }
    public function _view()
    {
        $view = VIEWS_PATH . $this->_controller . DS . $this->_action . '.view.php';
        if (file_exists($view)) {
            require_once $view; // Temporary test
        } else {
            echo 'View not found: ' . $view;
        }
    }
}
