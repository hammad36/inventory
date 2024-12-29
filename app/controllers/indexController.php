<?php

namespace inventory\controllers;

use inventory\lib\alertHandler;
use inventory\lib\inputFilter;
use inventory\models\usersModel;
use Exception;

class indexController extends abstractController
{
    use inputFilter;

    private alertHandler $alertHandler;

    private const MIN_PASSWORD_LENGTH = 12;
    private const MAX_PASSWORD_LENGTH = 64;
    private const MIN_AGE = 13;
    private const VALID_GENDERS = ['Male', 'Female'];
    private const VALID_ROLES = ['user', 'admin'];

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

            $filteredInputs = $this->filterAndValidateInputs($inputs, [
                'first_name' => fn($value) => $this->filterString($value, 2, 50),
                'last_name' => fn($value) => $this->filterString($value, 2, 50),
                'email' => fn($value) => $this->filterEmail($value),
                'password' => fn($value) => $value,
                'confirm_password' => fn($value) => $value,
                'date_of_birth' => fn($value) => $this->filterDate($value),
                'gender' => fn($value) => $this->validateGender($value),
                'role' => fn($value) => $this->validateRole($value)
            ]);

            $this->validatePassword($filteredInputs['password'], $filteredInputs['confirm_password']);
            $this->validateAge($filteredInputs['date_of_birth']);

            $user = $this->createUserFromInputs($filteredInputs);
            $user->setStatus('active');
            $user->setCreatedAt(date('Y-m-d H:i:s'));

            if ($user->save()) {
                $this->redirectWithAlert('success', '/index', 'Account created successfully! Log in to get started.');
            } else {
                throw new Exception('Failed to create account. Please try again.');
            }
        } catch (Exception $e) {
            $this->redirectWithAlert('error', '/index/registration', $e->getMessage());
        }
    }

    private function filterAndValidateInputs(array $inputs, array $validators): array
    {
        $filteredInputs = [];
        foreach ($validators as $field => $validator) {
            $value = $inputs[$field] ?? null;
            $filtered = $validator($value);
            if ($filtered === null || $filtered === '') {
                throw new Exception("The {$field} field is invalid or missing.");
            }
            $filteredInputs[$field] = $filtered;
        }
        return $filteredInputs;
    }

    private function validatePassword(string $password, string $confirmPassword): void
    {
        if (strlen($password) < self::MIN_PASSWORD_LENGTH || strlen($password) > self::MAX_PASSWORD_LENGTH) {
            throw new Exception('Password must be between 12 and 64 characters.');
        }

        if ($password !== $confirmPassword) {
            throw new Exception('Passwords do not match.');
        }
    }

    private function validateAge(string $dateOfBirth): void
    {
        if (!$this->validAge($dateOfBirth, self::MIN_AGE)) {
            throw new Exception('You must be at least 13 years old to register.');
        }
    }

    private function validateGender(string $gender): string
    {
        $gender = ucfirst(strtolower($gender));
        if (!in_array($gender, self::VALID_GENDERS)) {
            throw new Exception("Invalid gender. Allowed values: " . implode(', ', self::VALID_GENDERS) . '.');
        }
        return $gender;
    }

    private function validateRole(string $role): string
    {
        if (!in_array($role, self::VALID_ROLES)) {
            throw new Exception("Invalid role. Allowed values: " . implode(', ', self::VALID_ROLES) . '.');
        }
        return $role;
    }

    private function createUserFromInputs(array $inputs): usersModel
    {
        $user = new usersModel();
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
        session_regenerate_id(true);
    }

    private function redirectWithAlert(string $type, string $url, string $message): void
    {
        $this->alertHandler->redirectWithAlert($url, $type, $message);
    }
    private function redirectOnly(string $url): void
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
            $email = $this->filterEmail($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!$email || !$password) {
                throw new Exception('Email and password are required.');
            }

            $user = usersModel::findByEmail($email);

            if (!$user || !password_verify($password, $user->getPassword())) {
                throw new Exception('Invalid email or password.');
            }

            if ($user->getStatus() !== 'active') {
                throw new Exception('Account is not active. Please contact support.');
            }

            $user->updateLastLogin();
            $this->initializeUserSession($user);
            $this->redirectOnly('/home');
        } catch (Exception $e) {
            $this->redirectWithAlert('error', '/index', $e->getMessage());
        }
    }

    private function initializeUserSession(usersModel $user): void
    {
        $this->initializeSession();
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
        ];
    }
}
