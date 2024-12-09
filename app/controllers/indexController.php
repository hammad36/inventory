<?php

namespace inventory\controllers;

use inventory\lib\InputFilter;
use inventory\lib\AlertHandler;
use inventory\models\UsersModel;

class IndexController extends AbstractController
{
    use InputFilter;

    private AlertHandler $alertHandler;

    public function __construct()
    {
        $this->alertHandler = AlertHandler::getInstance();
    }

    public function defaultAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];

            if (!$email || !$password) {
                $this->redirectWithAlert('error', 'login', 'Invalid email or password.');
                return;
            }

            $user = UsersModel::findByEmail($email);
            if ($user && password_verify($password, $user->getPassword())) {
                $this->initializeUserSession($user);
                $this->redirectWithAlert('success', 'dashboard', 'Welcome back!');
            } else {
                $this->redirectWithAlert('error', 'login', 'Invalid email or password.');
            }
        }

        $this->_view();
    }

    public function registrationAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // CSRF Protection
            if (!$this->validateCsrfToken($_POST['csrf_token'])) {
                $this->redirectWithAlert('error', 'registration', 'Invalid CSRF token. Refresh and try again.');
                return;
            }
            unset($_SESSION['csrf_token']);

            // Input sanitization and validation
            $inputs = $this->sanitizeRegistrationInputs($_POST);
            $validationResult = $this->validateRegistrationInputs($inputs);
            if ($validationResult['error']) {
                $this->redirectWithAlert('error', 'registration', $validationResult['message']);
                return;
            }

            // Save the user
            $user = new UsersModel();
            $this->mapRegistrationInputsToUser($user, $inputs);

            if ($user->save()) {
                $this->redirectWithAlert('success', 'login', 'Account created successfully! Log in to get started.');
            } else {
                $this->redirectWithAlert('error', 'registration', 'Failed to create account. Please try again.');
            }
        } else {
            $this->generateCsrfToken();
        }

        $this->_view();
    }

    public function loginAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];

            if (!$email || !$password) {
                $this->redirectWithAlert('error', 'login', 'Invalid email or password.');
                return;
            }

            $user = UsersModel::findByEmail($email);
            if ($user && password_verify($password, $user->getPassword())) {
                $this->initializeUserSession($user);
                $this->redirectWithAlert('success', 'dashboard', 'Welcome back!');
            } else {
                $this->redirectWithAlert('error', 'login', 'Invalid email or password.');
            }
        }

        $this->_view();
    }

    private function sanitizeRegistrationInputs(array $data): array
    {
        return [
            'first_name' => $this->filterString($data['first_name']),
            'last_name' => $this->filterString($data['last_name']),
            'email' => filter_var($data['email'], FILTER_VALIDATE_EMAIL),
            'password' => $data['password'],
            'confirm_password' => $data['confirm_password'],
            'phone' => preg_replace('/\D/', '', $data['phone']),
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
        ];
    }

    private function validateRegistrationInputs(array $inputs): array
    {
        if (in_array(null, $inputs, true)) {
            return ['error' => true, 'message' => 'All fields are required.'];
        }
        if ($inputs['password'] !== $inputs['confirm_password']) {
            return ['error' => true, 'message' => 'Passwords do not match.'];
        }
        if (strlen($inputs['password']) < 8) {
            return ['error' => true, 'message' => 'Password must be at least 8 characters long.'];
        }

        if (UsersModel::findByEmail($inputs['email'])) {
            return ['error' => true, 'message' => 'Email is already registered.'];
        }
        return ['error' => false];
    }

    private function mapRegistrationInputsToUser(UsersModel $user, array $inputs): void
    {
        $user->setFirstName($inputs['first_name']);
        $user->setLastName($inputs['last_name']);
        $user->setEmail($inputs['email']);
        $user->setPassword($inputs['password']);
        $user->setPhone($inputs['phone']);
        $user->setDateOfBirth($inputs['date_of_birth']);
        $user->setGender($inputs['gender']);
        $user->setRole('user');
        $user->setStatus(1);
    }

    private function generateCsrfToken(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    private function validateCsrfToken(string $token): bool
    {
        return hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }

    private function initializeUserSession(UsersModel $user): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->getUserID();
        $_SESSION['user_name'] = "{$user->getFirstName()} {$user->getLastName()}";
        $_SESSION['user_role'] = $user->getRole();
    }

    private function redirectWithAlert(string $alertType, string $url, string $message): void
    {
        $this->alertHandler->redirectWithMessage($url, $alertType, $message);
    }
}
