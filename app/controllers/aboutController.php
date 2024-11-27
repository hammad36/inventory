<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;
use inventory\lib\InputFilter;
use inventory\lib\alertHandler;
use inventory\models\productsModel;
use inventory\models\productPhotosModel;
use inventory\models\categoriesModel;

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
