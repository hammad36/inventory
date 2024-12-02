<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;

class aboutController extends abstractController
{
    public function defaultAction()
    {
        $this->_view();
    }
}
