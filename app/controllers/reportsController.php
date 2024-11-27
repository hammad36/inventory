<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;

class reports extends abstractController
{
    public function defaultAction()
    {
        $this->_view();
    }
}
