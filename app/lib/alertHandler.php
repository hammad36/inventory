<?php

namespace inventory\lib;

class alertHandler
{
    private static $instance = null;

    // Tailwind alert styles mapped to alert types
    private $alertTypes = [
        'add' => 'bg-green-200  text-green-900',
        'remove' => 'bg-red-200 text-red-900',
        'edit' => 'bg-blue-200  text-blue-900',
        'error' => 'bg-yellow-200  text-yellow-900'
    ];

    private function __construct() {}

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

    public function displayAlert($type, $message)
    {
        if (!isset($this->alertTypes[$type])) return;
        $alertClass = $this->alertTypes[$type];
        $message = $this->sanitize($message);

        echo <<<HTML
        <div class="alert max-w-4xl mx-auto mt-4 flex items-start p-6 rounded-lg shadow-xl shadow-gray-300 hover:shadow-2xl hover:shadow-gray-400 
        transition-shadow duration-300 border-gradient-to-r from-blue-400 to-purple-500 $alertClass" role="alert">
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
        if (isset($_GET['msg'], $_GET['type']) && isset($this->alertTypes[$_GET['type']])) {
            $this->displayAlert($_GET['type'], $_GET['msg']);
        }
    }

    public function redirectWithMessage($path, $type, $message)
    {
        session_write_close();
        $location = "{$path}?msg=" . urlencode($message) . "&type=" . urlencode($type);
        header("Location: $location");
        exit();
    }
}
