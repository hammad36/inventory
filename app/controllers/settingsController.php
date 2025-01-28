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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->_view();
    }
    public function personalInfoAction()
    {
        // Ensure session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            $this->redirectWithAlert('error', '/login', 'Please log in to access settings.');
            exit;
        }

        // Fetch user data
        $user = usersModel::getByPK($_SESSION['user']['id']);
        if (!$user) {
            $this->redirectWithAlert('error', '/login', 'User not found.');
            exit;
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Filter and validate inputs using inputFilter trait methods
                $firstName = $this->filterString($_POST['first_name'] ?? '');
                $lastName = $this->filterString($_POST['last_name'] ?? '');
                $email = $this->filterEmail($_POST['email'] ?? '');
                $dateOfBirth = $this->filterDate($_POST['date_of_birth'] ?? '');
                $gender = $this->filterString($_POST['gender'] ?? '', 1, 10);

                // Check if any validation failed
                if (!$firstName || !$lastName || !$email || !$dateOfBirth || !$gender) {
                    throw new \Exception('Please fill in all fields correctly.');
                }

                // Validate gender options
                if (!in_array($gender, ['Male', 'Female', 'Other'])) {
                    throw new \Exception('Invalid gender option selected.');
                }

                // Check if email is already taken by another user
                $existingUser = usersModel::findByEmail($email);
                if ($existingUser && $existingUser->getUserID() !== $user->getUserID()) {
                    throw new \Exception('Email address is already in use.');
                }

                // Validate age (must be at least 13 years old)
                if (!$this->validAge($dateOfBirth, 13)) {
                    throw new \Exception('You must be at least 13 years old.');
                }

                // Update user data
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
                $user->setEmail($email);
                $user->setDateOfBirth($dateOfBirth);
                $user->setGender($gender);
                $user->setUpdatedAt(date('Y-m-d H:i:s'));
                $user->save();

                // Store current session data we want to keep
                $keepData = [
                    'user_id' => $_SESSION['user']['id'],
                    // Add any other session data you need to preserve
                ];

                // Clear session data
                $_SESSION = array();

                // Regenerate session ID
                session_regenerate_id(true);

                // Restore necessary session data
                $_SESSION['user'] = [
                    'id' => $user->getUserID(),
                    'first_name' => $user->getFirstName(),
                    'last_name' => $user->getLastName(),
                    'name' => $user->getFullName(),
                    'email' => $user->getEmail(),
                    'date_of_birth' => $user->getDateOfBirth(),
                    'gender' => $user->getGender(),
                    'role' => $user->getRole(),
                    'status' => $user->getStatus(),
                    'created_at' => $user->getCreatedAt(),
                    'updated_at' => $user->getUpdatedAt(),
                ];

                // Merge back any additional data we kept
                $_SESSION = array_merge($_SESSION, ['kept_data' => $keepData]);

                $this->redirectWithAlert('success', '/settings/personalInfo', 'Personal information updated successfully!');
            } catch (\Exception $e) {
                $this->redirectWithAlert('error', '/settings/personalInfo', $e->getMessage());
            }
        }

        // Pass data to view and render
        $this->_data['user'] = $user;
        $this->_view();
    }

    public function changePasswordAction()
    {
        // Ensure session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            $this->redirectWithAlert('error', '/login', 'Please log in to change your password.');
            exit;
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Get user data
                $user = usersModel::getByPK($_SESSION['user']['id']);
                if (!$user) {
                    throw new \Exception('User not found.');
                }

                // Validate and sanitize inputs
                $currentPassword = $this->filterString($_POST['current_password'] ?? '');
                $newPassword = $this->filterString($_POST['new_password'] ?? '');
                $confirmPassword = $this->filterString($_POST['confirm_new_password'] ?? '');

                // Check if all fields are filled
                if (!$currentPassword || !$newPassword || !$confirmPassword) {
                    throw new \Exception('All password fields are required.');
                }

                // Verify current password using password_verify()
                if (!password_verify($currentPassword, $user->getPassword())) {
                    throw new \Exception('Current password is incorrect.');
                }

                // Validate new password matches confirmation
                if ($newPassword !== $confirmPassword) {
                    throw new \Exception('New passwords do not match.');
                }

                // Prevent reusing the same password
                if ($currentPassword === $newPassword) {
                    throw new \Exception('New password must be different from current password.');
                }

                // Validate password strength
                $this->validatePasswordStrength($newPassword);

                // Update user password - the model will handle the hashing
                $user->setPassword($newPassword);
                $user->setUpdatedAt(date('Y-m-d H:i:s'));
                $user->save();

                // Regenerate session ID for security
                session_regenerate_id(true);

                $this->redirectWithAlert('success', '/settings/changePassword', 'Password changed successfully! Please use your new password next time you log in.');
            } catch (\Exception $e) {
                $this->redirectWithAlert('error', '/settings/changePassword', $e->getMessage());
            }
        }

        // Display the view
        $this->_view();
    }

    //Validates password strength against requirements

    private function validatePasswordStrength(string $password): void
    {
        $errors = [];

        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters long';
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter';
        }

        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain at least one lowercase letter';
        }

        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number';
        }

        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $errors[] = 'Password must contain at least one special character';
        }

        if (!empty($errors)) {
            throw new \Exception(implode('. ', $errors));
        }
    }

    public function termsAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->_view();
    }
    public function privacySettingsAction()
    {
        try {
            // Ensure session is started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Handle account deletion request
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_account'])) {
                // Fetch user data
                $userId = (int)$_SESSION['user']['id'];
                $user = usersModel::getByPK($userId);

                if (!$user) {
                    throw new \Exception('User not found. Unable to delete account.');
                }

                // Delete user from database
                if (!$user->delete()) {
                    throw new \Exception('Failed to delete account. Please try again later.');
                }

                // Clear session and destroy it
                session_unset();
                session_destroy();

                // Redirect with success message
                $this->redirectWithAlert('remove', '/index', 'Your account has been successfully deleted.');
                exit;
            }

            // Display the privacy settings view
            $this->_view();
        } catch (\Exception $e) {
            // Redirect with error message
            $this->redirectWithAlert('error', '/settings/privacySettings', $e->getMessage());
        }
    }

    private function redirectWithAlert(string $type, string $url, string $message): void
    {
        $this->alertHandler->redirectWithAlert($url, $type, $message);
    }
    private function redirectOnly(string $url): void
    {
        $this->alertHandler->redirectOnly($url);
    }
}
