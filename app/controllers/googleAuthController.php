<?php

namespace inventory\controllers;

require_once __DIR__ . '/../../vendor/autoload.php';

use Google\Client;
use Google\Service\Oauth2;
use inventory\models\usersModel;
use inventory\lib\alertHandler;
use Exception;

class googleAuthController extends abstractController
{
    private Client $client;
    private alertHandler $alertHandler;

    public function __construct()
    {
        parent::__construct();
        $this->alertHandler = alertHandler::getInstance();
        $this->initializeGoogleClient();
        $this->validateGoogleCredentials();
    }

    private function initializeGoogleClient(): void
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        $this->client = new Client();
        $this->client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $this->client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        $this->client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
        $this->client->addScope(['email', 'profile']);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
        $this->client->setIncludeGrantedScopes(true);
    }

    private function validateGoogleCredentials(): void
    {
        if (empty($_ENV['GOOGLE_CLIENT_ID']) || empty($_ENV['GOOGLE_CLIENT_SECRET'])) {
            throw new Exception('Google authentication credentials are not configured properly');
        }
    }

    public function loginAction(): void
    {
        try {
            $this->preventSessionFixation();
            $_SESSION['oauth_state'] = bin2hex(random_bytes(32));
            $this->client->setState($_SESSION['oauth_state']);

            header('Location: ' . $this->client->createAuthUrl());
            exit;
        } catch (Exception $e) {
            error_log('Google Login Error: ' . $e->getMessage());
            $this->alertHandler->redirectWithAlert('/login', 'error', 'Unable to initiate Google login');
        }
    }

    public function callbackAction(): void
    {
        try {
            $this->validateStateParameter();
            $this->validateAuthorizationCode();

            $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
            $this->validateAccessToken($token);

            $oauth = new Oauth2($this->client);
            $googleUser = $oauth->userinfo->get();
            $this->validateGoogleUser($googleUser);

            $user = $this->findOrCreateUser($googleUser);
            $this->updateUserSession($user);

            // Redirect to /home after successful login
            $this->alertHandler->redirectOnly('/home');
        } catch (Exception $e) {
            error_log('Google Auth Error: ' . $e->getMessage());
            $this->alertHandler->redirectWithAlert('/login', 'error', $e->getMessage());
        }
    }

    private function preventSessionFixation(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }

    private function validateStateParameter(): void
    {
        if (empty($_GET['state']) || !hash_equals($_SESSION['oauth_state'] ?? '', $_GET['state'])) {
            throw new Exception('Invalid authentication state');
        }
        unset($_SESSION['oauth_state']);
    }

    private function validateAuthorizationCode(): void
    {
        if (empty($_GET['code'])) {
            throw new Exception('Missing authorization code');
        }
    }

    private function validateAccessToken(array $token): void
    {
        if (isset($token['error'])) {
            throw new Exception('Google API error: ' . $token['error_description'] ?? $token['error']);
        }
    }

    private function validateGoogleUser(Oauth2\Userinfo $googleUser): void
    {
        if (!$googleUser->getVerifiedEmail()) {
            throw new Exception('Google account email not verified');
        }
    }

    private function findOrCreateUser(Oauth2\Userinfo $googleUser): usersModel
    {
        $user = usersModel::findByGoogleId($googleUser->getId());

        if (!$user) {
            $user = usersModel::findByEmail($googleUser->getEmail());
            if ($user && $user->getAuthProvider() !== 'google') {
                throw new Exception('Email already exists with different login method');
            }

            $user = new usersModel();
            $user->setGoogleId($googleUser->getId());
            $user->setEmail($googleUser->getEmail());
            $user->setFirstName($this->sanitizeName($googleUser->getGivenName()));
            $user->setLastName($this->sanitizeName($googleUser->getFamilyName()));
            $user->setAuthProvider('google');
            $user->setRole('user');
            $user->setStatus('active');
            $user->setCreatedAt(date('Y-m-d H:i:s'));
        }

        $user->updateLastLogin();
        if (!$user->save()) {
            throw new Exception('Failed to save user data');
        }

        return $user;
    }

    private function sanitizeName(?string $name): string
    {
        return trim(substr($name ?? '', 0, 50));
    }

    private function updateUserSession(usersModel $user): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => $user->getUserID(),
            'email' => $user->getEmail(),
            'name' => $user->getFullName(),
            'role' => $user->getRole(),
            'auth_provider' => $user->getAuthProvider(),
            'last_login' => $user->getLastLogin()
        ];

        // Set session expiration (1 hour)
        $_SESSION['expire_time'] = time() + 3600;
    }
}
