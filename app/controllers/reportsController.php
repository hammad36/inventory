<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;

class reportsController extends abstractController
{
    public function defaultAction()
    {
        $this->_view();
    }
}
