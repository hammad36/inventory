<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;
use inventory\models\stockAdjustmentsModel;

class reportsController extends abstractController
{
    /**
     * Default action: display all stock adjustments.
     */
    public function defaultAction(): void
    {
        $this->initializeSession();

        // Fetch all stock adjustments and pass them to the view.
        $this->_data['stockAdjustments'] = stockAdjustmentsModel::getAll();
        $this->_view();
    }

    /**
     * Filter action: retrieve stock adjustments based on a specific filter (day, week, month, year).
     */
    public function filterAction(): void
    {
        $this->initializeSession();

        // Get filter type from the request.
        $type = $_GET['type'] ?? null;
        $stockAdjustments = $type ? stockAdjustmentsModel::getFiltered($type) : [];

        // Return the filtered results as a JSON response.
        $this->sendJsonResponse($stockAdjustments);
    }

    /**
     * Initialize the session if not already started.
     */
    private function initializeSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Send a JSON response and exit.
     *
     * @param mixed $data The data to encode and send.
     */
    private function sendJsonResponse($data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
