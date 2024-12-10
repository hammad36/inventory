<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;
use inventory\lib\alertHandler;
use inventory\lib\InputFilter;
use inventory\models\messagesModel;

class aboutController extends abstractController
{
    use InputFilter;

    private $alertHandler;

    public function __construct()
    {
        $this->alertHandler = alertHandler::getInstance();
    }

    public function defaultAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Filter and validate inputs
            $name = $this->filterString($_POST['name'] ?? '');
            $email = $this->filterEmail($_POST['email'] ?? '');
            $message_text = $this->filterString($_POST['message_text'] ?? '');

            // Validate inputs and provide user-friendly feedback
            if (empty($name)) {
                $this->redirectWithAlert('error', '/about', "Name is required.");
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->redirectWithAlert('error', '/about', "Invalid email address.");
                return;
            }

            if (empty($message_text)) {
                $this->redirectWithAlert('error', '/about', "Message cannot be empty.");
                return;
            }

            // Create and save the message
            $message = new messagesModel();
            $message->setName($name);
            $message->setEmail($email);
            $message->setMessageText($message_text);

            if ($message->save()) {
                $this->redirectWithAlert('success', '/about', "Message submitted successfully.");
            } else {
                error_log("Failed to save message: " . json_encode($message));
                $this->redirectWithAlert('error', '/about', "Failed to submit your message.");
            }
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->_view([
            'user' => $_SESSION['user'] ?? null
        ]);
    }


    private function redirectWithAlert(string $alertType, string $url, string $message)
    {
        $this->alertHandler->redirectWithMessage($url, $alertType, $message);
    }
}
