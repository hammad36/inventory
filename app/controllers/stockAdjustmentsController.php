<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;
use inventory\lib\InputFilter;
use inventory\lib\alertHandler;
use inventory\models\productsModel;
use inventory\models\productPhotosModel;
use inventory\models\categoriesModel;

class stockAdjustmentsController extends abstractController
{
    public function defaultAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->_view();
    }
}
