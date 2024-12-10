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
            $this->handleLogin();
        } else {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $this->_view([
                'user' => $_SESSION['user'] ?? null
            ]);
        }
    }

    private function handleLogin(): void
    {
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            $this->redirectWithAlert('error', 'login', 'Invalid email or password.');
            return;
        }

        $user = UsersModel::findByEmail($email);

        if ($user && password_verify($password, $user->getPassword())) {
            $this->initializeUserSession($user);
            $this->redirectOnly('/home');
        } else {
            $this->redirectWithAlert('error', '/index', 'Invalid email or password.');
        }
    }

    public function registrationAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleRegistration();
        } else {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $this->_view([
                'user' => $_SESSION['user'] ?? null
            ]);
        }
    }

    private function handleRegistration(): void
    {
        $inputs = $this->sanitizeRegistrationInputs($_POST);
        $validationResult = $this->validateRegistrationInputs($inputs);

        if ($validationResult['error']) {
            $this->redirectWithAlert('error', '/index/registration', $validationResult['message']);
            return;
        }

        $user = $this->createUserFromInputs($inputs);

        if ($user->save()) {
            $this->redirectWithAlert('success', '/index', 'Account created successfully! Log in to get started.');
        } else {
            $this->redirectWithAlert('error', '/index/registration', 'Failed to create account. Please try again.');
        }
    }

    private function sanitizeRegistrationInputs(array $data): array
    {
        return [
            'first_name' => $this->filterString($data['first_name'] ?? ''),
            'last_name' => $this->filterString($data['last_name'] ?? ''),
            'email' => filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL),
            'password' => $data['password'] ?? '',
            'confirm_password' => $data['confirm_password'] ?? '',
            'date_of_birth' => $data['date_of_birth'] ?? '',
            'gender' => $data['gender'] ?? '',
        ];
    }

    private function validateRegistrationInputs(array $inputs): array
    {
        if (in_array('', $inputs, true)) {
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

    private function createUserFromInputs(array $inputs): UsersModel
    {
        $user = new UsersModel();
        $user->setFirstName($inputs['first_name']);
        $user->setLastName($inputs['last_name']);
        $user->setEmail($inputs['email']);
        $user->setPassword(password_hash($inputs['password'], PASSWORD_BCRYPT));
        $user->setDateOfBirth($inputs['date_of_birth']);
        $user->setGender($inputs['gender']);
        $user->setRole('user');

        return $user;
    }

    private function initializeUserSession(UsersModel $user): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => $user->getUserID(),
            'name' => "{$user->getFirstName()} {$user->getLastName()}",
            'role' => $user->getRole()
        ];
    }

    private function redirectWithAlert(string $alertType, string $url, string $message): void
    {
        $this->alertHandler->redirectWithMessage($url, $alertType, $message);
    }


    private function redirectOnly(string $url): void
    {
        $this->alertHandler->redirectOnly($url);
    }
}
