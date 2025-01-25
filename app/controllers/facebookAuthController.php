<?php

namespace inventory\controllers;

use inventory\lib\alertHandler;
use inventory\models\usersModel;
use Facebook\Facebook;
use Exception;

class facebookAuthController extends abstractController
{
    private alertHandler $alertHandler;
    private Facebook $fb;

    public function __construct()
    {
        $this->alertHandler = alertHandler::getInstance();

        // Initialize Facebook SDK
        $this->fb = new Facebook([
            'app_id' => '2644813512369293', // Your Facebook App ID
            'app_secret' => '4e1c4ebdd7326999ed83e0551ff259ef', // Your Facebook App Secret
            'default_graph_version' => 'v18.0',
        ]);
    }

    public function authAction(): void
    {
        try {
            // Get the access token from the redirect
            $helper = $this->fb->getRedirectLoginHelper();
            $accessToken = $helper->getAccessToken();

            if (!isset($accessToken)) {
                throw new Exception('Failed to get access token from Facebook.');
            }

            // Get user profile data
            $response = $this->fb->get('/me?fields=id,name,email,first_name,last_name', $accessToken);
            $fbUser = $response->getGraphUser();

            // Extract user information
            $facebookId = $fbUser->getId();
            $email = $fbUser->getEmail();
            $firstName = $fbUser->getFirstName();
            $lastName = $fbUser->getLastName();

            // Check if user exists
            $user = usersModel::findByEmail($email);

            if ($user) {
                if ($user->getAuthProvider() !== 'facebook') {
                    throw new Exception('This email is already registered. Please use ' . ucfirst($user->getAuthProvider()) . ' login.');
                }
            } else {
                // Create new user
                $user = new usersModel();
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
                $user->setEmail($email);
                $user->setFacebookId($facebookId);
                $user->setAuthProvider('facebook');
                $user->setPassword(bin2hex(random_bytes(32))); // Generate a random password
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
            error_log('Facebook Auth Error: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
