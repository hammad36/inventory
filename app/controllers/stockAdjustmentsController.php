<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;
use inventory\models\productsModel;
use inventory\models\StockAdjustmentsModel;

class stockAdjustmentsController extends abstractController
{
    public function defaultAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Fetch stock adjustments from the database
        $stockAdjustments = StockAdjustmentsModel::getAll();

        // Pass data to the view
        $this->_data['stockAdjustments'] = $stockAdjustments;

        $this->_view();
    }
}
