<?php

namespace inventory\controllers;

use inventory\lib\alertHandler;
use inventory\models\UsersModel;
use Exception;
use DateTime;

class IndexController extends AbstractController
{
    private alertHandler $alertHandler;
    private const MIN_PASSWORD_LENGTH = 12;
    private const MAX_PASSWORD_LENGTH = 64;
    private const MIN_AGE = 13;

    public function __construct()
    {
        $this->alertHandler = alertHandler::getInstance();
    }

    public function registrationAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleRegistration();
        } else {
            $this->initializeSession();
            $this->_view();
        }
    }

    private function handleRegistration(): void
    {
        try {
            $inputs = $_POST;

            $this->validateRequiredFields($inputs, ['first_name', 'last_name', 'email', 'password', 'confirm_password', 'date_of_birth', 'gender', 'role']);

            $user = $this->createUserFromInputs($inputs);
            $user->setStatus('active');

            if ($user->save()) {
                $this->redirectWithAlert('success', '/index', 'Account created successfully! Log in to get started.');
            } else {
                throw new Exception('Failed to create account. Please try again.');
            }
        } catch (Exception $e) {
            $this->redirectWithAlert('error', '/index/registration', $e->getMessage());
        }
    }

    private function validateRequiredFields(array $inputs, array $requiredFields): void
    {
        foreach ($requiredFields as $field) {
            if (empty($inputs[$field])) {
                throw new Exception("The {$field} field is required.");
            }
        }
    }

    private function createUserFromInputs(array $inputs): UsersModel
    {
        $user = new UsersModel();
        $user->setFirstName($inputs['first_name']);
        $user->setLastName($inputs['last_name']);
        $user->setEmail($inputs['email']);
        $user->setPassword($inputs['password']);
        $user->setDateOfBirth($inputs['date_of_birth']);
        $user->setGender($inputs['gender']);
        $user->setRole($inputs['role']);

        return $user;
    }

    private function initializeSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function redirectWithAlert(string $type, string $url, string $message): void
    {
        $this->alertHandler->redirectWithAlert($url, $type, $message);
    }
    private function redirectONly(string $url)
    {
        $this->alertHandler->redirectOnly($url);
    }

    public function defaultAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleLogin();
        } else {
            $this->initializeSession();
            $this->_view();
        }
    }

    private function handleLogin(): void
    {
        try {
            $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (!$email || !$password) {
                throw new Exception('Invalid email or password.');
            }

            $user = UsersModel::findByEmail($email);

            if (!$user || !password_verify($password, $user->getPassword())) {
                throw new Exception('Invalid email or password.');
            }

            if ($user->getStatus() !== 'active') {
                throw new Exception('Account is not active. Please contact support.');
            }

            $user->updateLastLogin();
            $this->initializeUserSession($user);
            $this->redirectOnly('/home');
            $this->redirectWithAlert('success', '/home', 'Welcome back!');
        } catch (Exception $e) {
            $this->redirectWithAlert('error', '/index', $e->getMessage());
        }
    }

    private function initializeUserSession(UsersModel $user): void
    {
        $this->initializeSession();
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => $user->getUserID(),
            'name' => $user->getFullName(),
            'email' => $user->getEmail(),
            'date_of_birth' => $user->getDateOfBirth(),
            'gender' => $user->getGender(),
            'role' => $user->getRole(),
            'status' => $user->getStatus(),
            'created_at' => $user->getCreatedAt(),
        ];
    }
}
