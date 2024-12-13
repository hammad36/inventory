<?php

namespace inventory\lib;

class alertHandler
{
    private static $instance = null;

    // Expanded alert types with more descriptive styles
    private $alertTypes = [
        'add'        => ['class' => 'bg-green-100 border-green-400 text-green-900', 'icon' => '✅'],
        'success'    => ['class' => 'bg-green-100 border-green-400 text-green-900', 'icon' => '✅'],
        'remove'     => ['class' => 'bg-red-100 border-red-400 text-red-900', 'icon' => '❌'],
        'edit'       => ['class' => 'bg-blue-100 border-blue-400 text-blue-900', 'icon' => '✏️'],
        'error'      => ['class' => 'bg-yellow-100 border-yellow-400 text-yellow-900', 'icon' => '⚠️'],
        'warning'    => ['class' => 'bg-orange-100 border-orange-400 text-orange-900', 'icon' => '🚨']
    ];

    private function __construct()
    {
        $this->initSession();
    }

    private function initSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function sanitize($data)
    {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    public function setAlert($type, $message)
    {
        $this->initSession();

        // Validate alert type
        if (!isset($this->alertTypes[$type])) {
            $type = 'error'; // Default to error if type is invalid
        }

        $_SESSION['alert'] = [
            'type' => $type,
            'message' => $message,
            'timestamp' => time()
        ];
    }

    public function displayAlert()
    {
        $this->initSession();

        if (isset($_SESSION['alert'])) {
            $alert = $_SESSION['alert'];
            $type = $alert['type'];
            $message = $this->sanitize($alert['message']);
            $alertConfig = $this->alertTypes[$type];

            echo $this->renderAlertHTML($alertConfig['class'], $alertConfig['icon'], $message);

            // Clear the alert after displaying
            unset($_SESSION['alert']);
        }
    }

    private function renderAlertHTML($class, $icon, $message)
    {
        return <<<HTML
        <div class="alert max-w-4xl mx-auto mt-4 flex items-center p-4 rounded-lg shadow-md $class" role="alert">
            <span class="mr-3 text-2xl">$icon</span>
            <div class="flex-1">
                $message
            </div>
            <button type="button" class="ml-4 text-gray-500 hover:text-gray-700" onclick="this.parentElement.remove()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        HTML;
    }

    public function handleAlert()
    {
        $this->displayAlert();
    }

    public function redirectWithAlert($path, $type, $message)
    {
        $this->initSession();

        // Set alert in session
        $this->setAlert($type, $message);

        // Close session and redirect
        session_write_close();
        header("Location: $path");
        exit();
    }

    public function redirectOnly($path)
    {
        session_write_close();
        header("Location: $path");
        exit();
    }

    // New method to check if an alert exists
    public function hasAlert()
    {
        return isset($_SESSION['alert']);
    }

    // New method to clear alerts manually if needed
    public function clearAlert()
    {
        unset($_SESSION['alert']);
    }
}
