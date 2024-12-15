<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;
use inventory\models\stockAdjustmentsModel;

class reportsController extends abstractController
{
    public function defaultAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $stockAdjustments = stockAdjustmentsModel::getAll();

        // Pass data to the view
        $this->_data['stockAdjustments'] = $stockAdjustments;

        $this->_view();
    }
}
