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

        // Fetch all stock adjustments
        $stockAdjustments = stockAdjustmentsModel::getAll();
        $this->_data['stockAdjustments'] = $stockAdjustments;

        $this->_view();
    }

    public function filterAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Get filter type from request (day, week, month, year)
        $type = $_GET['type'] ?? null;

        // Fetch filtered stock adjustments
        $stockAdjustments = [];

        if ($type) {
            $stockAdjustments = stockAdjustmentsModel::getFiltered($type);
        }

        // Send JSON response for AJAX request
        header('Content-Type: application/json');
        echo json_encode($stockAdjustments);
        exit;
    }
}
