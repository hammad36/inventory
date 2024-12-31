<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;
use inventory\models\stockAdjustmentsModel;

class reportsController extends abstractController
{

    public function defaultAction(): void
    {
        $this->initializeSession();

        $this->_data['stockAdjustments'] = stockAdjustmentsModel::getAll();
        $this->_view();
    }


    public function filterAction(): void
    {
        $this->initializeSession();

        $type = $_GET['type'] ?? null;
        $stockAdjustments = $type ? stockAdjustmentsModel::getFiltered($type) : [];

        $this->sendJsonResponse($stockAdjustments);
    }


    private function initializeSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function sendJsonResponse($data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
