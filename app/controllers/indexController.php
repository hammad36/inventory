<?php

namespace inventory\controllers;

use inventory\lib\InputFilter;
use inventory\lib\alertHandler;
use inventory\models\usersModel;

class indexController extends abstractController
{
    use InputFilter;

    private $alertHandler;

    public function __construct()
    {
        $this->alertHandler = alertHandler::getInstance();
    }

    public function defaultAction()
    {
        $this->_view();
    }

    public function registrationAction()
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF Token Validation with hash_equals for security
            if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
                $this->redirectWithAlert('error', 'registration', 'Invalid CSRF token. Please refresh the page and try again.');
                return;
            }

            // Clear the CSRF token after successful validation
            unset($_SESSION['csrf_token']);

            // Sanitize and validate user inputs
            $firstName = $this->filterString($_POST['first_name']);
            $lastName = $this->filterString($_POST['last_name']);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            $phone = preg_replace('/\D/', '', $_POST['phone']);
            $dateOfBirth = $_POST['date_of_birth'];
            $gender = $_POST['gender'];

            // Validate fields
            if (!$firstName || !$lastName || !$email || !$password || !$confirmPassword || !$phone || !$dateOfBirth || !$gender) {
                $this->redirectWithAlert('error', 'registration', 'All fields are required.');
                return;
            }

            if ($password !== $confirmPassword) {
                $this->redirectWithAlert('error', 'registration', 'Passwords do not match.');
                return;
            }

            if (strlen($password) < 8) {
                $this->redirectWithAlert('error', 'registration', 'Password must be at least 8 characters long.');
                return;
            }

            if (!$this->validAge($dateOfBirth, 16)) {
                $this->redirectWithAlert('error', 'registration', 'You must be at least 16 years old to register.');
                return;
            }

            if (usersModel::findByEmail($email)) {
                $this->redirectWithAlert('error', 'registration', 'This email is already registered.');
                return;
            }

            // Create and populate the user instance
            $user = new usersModel();
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setEmail($email);
            $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
            $user->setPhone($phone);
            $user->setDateOfBirth($dateOfBirth);
            $user->setGender($gender);
            $user->setRole('user');
            $user->setStatus(1);

            if ($user->save()) {
                $this->redirectWithAlert('add', 'login', 'Your account has been successfully created!');
            } else {
                $this->redirectWithAlert('error', 'registration', 'Failed to create account. Please try again.');
            }
        } else {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $this->_view();
    }


    public function loginAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = usersModel::findByEmail($_POST['email']);
            if ($user && password_verify($_POST['password'], $user->getPassword())) {
                $_SESSION['user'] = $user;
                header('Location: /inventory');
                exit;
            } else {
                $this->redirectWithAlert('error', 'registration', 'Invalid email or password.');
            }
        }
        $this->_view();
    }

    private function redirectWithAlert(string $alertType, string $url, string $message)
    {
        $this->alertHandler->redirectWithMessage($url, $alertType, $message);
    }
}
