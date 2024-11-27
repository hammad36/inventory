<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;

class about extends abstractController
{
    public function defaultAction()
    {
        $this->_view();
    }
    public function addAction()
    {
        $this->_view();
    }
}
