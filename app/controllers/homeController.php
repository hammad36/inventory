<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;

use inventory\models\categoriesModel;
use inventory\models\productPhotosModel;
use inventory\models\productsModel;
use inventory\models\usersModel;

class homeController extends abstractController
{
    public function defaultAction(): void
    {
        $categoryNumber = categoriesModel::countAll();
        $productNumber  = productsModel::countAll();
        $usersNumber    = usersModel::countAll();
        $this->_data['categoryNumber'] = $categoryNumber;
        $this->_data['productNumber']  = $productNumber;
        $this->_data['usersNumber']     = $usersNumber;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->_view();
    }
}
