<?php

namespace inventory\controllers;

use inventory\lib\alertHandler;
use inventory\models\usersModel;
use Google\Client;
use Exception;

class googleAuthController extends abstractController
{
    private alertHandler $alertHandler;

    public function __construct()
    {
        $this->alertHandler = alertHandler::getInstance();
    }

    public function authAction(): void
    {
        try {
            // Get Google ID token
            $idToken = $_POST['credential'] ?? null;
            if (!$idToken) {
                throw new Exception('No credential provided');
            }

            // Verify ID token
            $client = new Client(['client_id' => '44476612208-hugqec34fg3n7vkeq3r79rmhcu98pqhm.apps.googleusercontent.com']);
            $payload = $client->verifyIdToken($idToken);

            if (!$payload) {
                throw new Exception('Invalid ID token');
            }

            // Extract user information
            $googleId = $payload['sub'];
            $email = $payload['email'];
            $firstName = $payload['given_name'] ?? '';
            $lastName = $payload['family_name'] ?? '';

            // Check if user exists
            $user = usersModel::findByEmail($email);

            if ($user) {
                if ($user->getAuthProvider() !== 'google') {
                    throw new Exception('This email is already registered. Please use ' . ucfirst($user->getAuthProvider()) . ' login.');
                }
            } else {
                // Create new user
                $user = new usersModel();
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
                $user->setEmail($email);
                $user->setGoogleId($googleId);
                $user->setAuthProvider('google');
                $user->setPassword(bin2hex(random_bytes(32)));
                $user->setRole('user');
                $user->setStatus('active');
                $user->setCreatedAt(date('Y-m-d H:i:s'));
                $user->setGender('Male'); // Default gender
                $user->setDateOfBirth(date('Y-m-d', strtotime('-13 years'))); // Default to minimum age

                if (!$user->save()) {
                    throw new Exception('Failed to create account');
                }
            }

            // Update last login
            $user->updateLastLogin();
            $user->save();

            // Set session
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
                'auth_provider' => $user->getAuthProvider()
            ];

            echo json_encode([
                'success' => true,
                'redirect' => '/dashboard'
            ]);
        } catch (Exception $e) {
            error_log('Google Auth Error: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
