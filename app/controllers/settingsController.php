<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;
use inventory\lib\alertHandler;
use inventory\lib\inputFilter;
use inventory\models\usersModel;

class settingsController extends abstractController
{
    use inputFilter;

    private $alertHandler;

    public function __construct()
    {
        $this->alertHandler = alertHandler::getInstance();
    }

    public function defaultAction()
    {
        // Fetch user data, e.g., from the session or database
        $user = usersModel::getByPK($_SESSION['user']['id']);

        if (!$user) {
            // Handle the case where the user data isn't found
            die("User not found.");
        }

        // Pass the user data to the view
        $this->_data['user'] = $user;

        $this->_view();
    }
    public function personalInfoAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->_view();
    }

    public function changePasswordAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->_view();
    }

    public function termsAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->_view();
    }

    public function editAction()
    {
        // Ensure session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['user_id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $userId) {
            // Fetch user data
            $user = usersModel::getByPK($userId);
            if (!$user) {
                $this->redirectWithAlert('error', '/login', 'User not found.');
                exit;
            }

            // Sanitize and validate inputs
            $first_name = $this->filterString($_POST['first_name']);
            $last_name = $this->filterString($_POST['last_name']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $date_of_birth = $_POST['date_of_birth'];
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

            // Update user data
            try {
                $user->setFirstName($first_name);
                $user->setLastName($last_name);
                $user->setEmail($email);
                $user->setDateOfBirth($date_of_birth);
                $user->setGender($gender);
                $user->save();

                $this->redirectWithAlert('success', '/settings', 'settings updated successfully!');
            } catch (\Exception $e) {
                $this->redirectWithAlert('error', '/settings', $e->getMessage());
            }
        } else {
            $this->redirectWithAlert('error', '/login', 'Unauthorized access.');
        }
    }

    private function redirectWithAlert(string $type, string $url, string $message): void
    {
        $this->alertHandler->redirectWithAlert($url, $type, $message);
    }
}
