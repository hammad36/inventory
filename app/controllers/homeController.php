<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;

class homeController extends abstractController
{
    public function defaultAction()
    {
        $this->_view();
    }
}
