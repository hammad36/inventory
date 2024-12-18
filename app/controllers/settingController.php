<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;
use inventory\lib\alertHandler;
use inventory\lib\inputFilter;

class settingController extends abstractController
{
    use inputFilter;

    private $alertHandler;

    public function __construct()
    {
        $this->alertHandler = alertHandler::getInstance();
    }

    public function defaultAction()
    {
        // Ensure session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Render the settings page
        $this->_view();
    }

    public function editAction()
    {
        // Ensure session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Process form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate inputs
            $first_name = $this->filterString($_POST['first_name']);
            $last_name = $this->filterString($_POST['last_name']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $date_of_birth = $_POST['date_of_birth']; // Add further validation if necessary
            $gender = $this->filterString($_POST['gender']);

            // Validate required fields
            if (empty($first_name) || empty($last_name) || empty($email) || empty($date_of_birth) || empty($gender)) {
                $this->redirectWithAlert('error', '/settings', 'All fields are required.');
                exit;
            }

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->redirectWithAlert('error', '/settings', 'Invalid email format.');
                exit;
            }

            // Update user session data (replace this with database updates in production)
            $_SESSION['user']['first_name'] = $first_name;
            $_SESSION['user']['last_name'] = $last_name;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['date_of_birth'] = $date_of_birth;
            $_SESSION['user']['gender'] = $gender;

            // Redirect with success message
            $this->redirectWithAlert('success', '/settings', 'Settings updated successfully!');
            exit;
        }
    }

    private function redirectWithAlert(string $type, string $url, string $message): void
    {
        $this->alertHandler->redirectWithAlert($url, $type, $message);
    }
}
