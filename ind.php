<?php

// namespace inventory;

// use inventory\lib\frontController;
// use inventory\lib\template;

// if (!defined('DS')) {
//     define('DS', DIRECTORY_SEPARATOR);
// }

// require_once '..' . DS . 'app' . DS . 'config' . DS . 'config.php';
// require_once APP_PATH . 'lib' . DS . 'autoload.php';
// $templateParts = require_once '..' . DS . 'app' . DS . 'config' . DS . 'templateConfig.php';

// $template = new template($templateParts);
// $frontController = new frontController($template);
// $frontController->dispatch();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>InvenHammad</title>
</head>

<body class="bg-gray-100 text-white">

    <!-- Navbar -->
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between relative">
                <!-- Mobile Menu Button -->
                <button type="button" class="sm:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                    aria-controls="mobile-menu" aria-expanded="false" onclick="toggleMobileMenu()">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <!-- Logo -->
                <div class="flex flex-1 items-center justify-center sm:justify-start">
                    <img class="h-10 w-auto" src="images/logo.png" alt="Company Logo">
                    <span class="text-white font-semibold text-lg ml-2">InvenHammad</span>

                    <!-- Desktop Navigation -->
                    <div class="hidden sm:flex sm:ml-6 space-x-4 ml-10">
                        <a href="#" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium">Home</a>
                        <div class="relative">
                            <button id="category-button"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium focus:outline-none"
                                onclick="toggleDropdown('category-dropdown')">Categories</button>
                            <div id="category-dropdown"
                                class="hidden absolute left-0 mt-2 w-40 bg-white rounded-md shadow-lg ring-1 ring-black/5 z-10">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Clothes</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Electronics</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Books</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfumes</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Appliances</a>
                            </div>
                        </div>
                        <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Stock Adjustments</a>
                        <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Reports</a>
                        <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Settings</a>
                    </div>
                </div>

                <!-- Search -->
                <div class="relative">
                    <button id="search-button" class="p-2 bg-gray-800 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                        onclick="toggleSearchBar()">
                        <span class="sr-only">Search</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.707 20.293l-5.4-5.4a8.5 8.5 0 1 0-1.414 1.414l5.4 5.4a1 1 0 0 0 1.414-1.414zM10.5 18a7.5 7.5 0 1 1 7.5-7.5 7.5 7.5 0 0 1-7.5 7.5z" />
                        </svg>
                    </button>

                    <!-- Search Bar Overlay -->
                    <div id="search-bar" class="hidden fixed inset-0 bg-gray-900 bg-opacity-95 z-50 flex items-center justify-center">
                        <div class="w-full max-w-lg px-4">
                            <form class="relative">
                                <input type="text" placeholder="Search for products, categories, or reports..."
                                    class="w-full pl-10 pr-10  py-3 rounded-full bg-gray-800 text-white shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-600 text-lg">
                                <button type="submit" class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400 hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M21.707 20.293l-5.4-5.4a8.5 8.5 0 1 0-1.414 1.414l5.4 5.4a1 1 0 0 0 1.414-1.414zM10.5 18a7.5 7.5 0 1 1 7.5-7.5 7.5 7.5 0 0 1-7.5 7.5z" />
                                    </svg>
                                </button>
                                <button type="button" onclick="toggleSearchBar()"
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="relative ml-3">
                    <button id="user-menu-button" class="flex bg-gray-800 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                        onclick="toggleDropdown('user-menu')">
                        <span class="sr-only">Open user menu</span>
                        <img class="h-10 w-10 rounded-full" src="images/avatar322.jpg" alt="User avatar">
                    </button>
                    <div id="user-menu"
                        class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black/5 focus:outline-none">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                    </div>
                </div>

            </div>
        </div>
        <!-- Add this inside the nav element -->
        <div id="mobile-menu" class="hidden sm:hidden">
            <div class="space-y-1 px-2 pt-2 pb-3">
                <a href="#" class="block bg-gray-900 text-white px-3 py-2 rounded-md text-base font-medium">Home</a>
                <div class="px-2">
                    <button class="w-full text-left text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium focus:outline-none"
                        onclick="toggleDropdown('mobile-category-dropdown')">
                        Categories
                    </button>
                    <div id="mobile-category-dropdown" class="hidden space-y-1 bg-gray-700 rounded-md px-2 py-3">
                        <a href="#" class="block text-gray-300 hover:bg-gray-600 hover:text-white px-3 py-2 rounded-md text-base font-medium">Clothes</a>
                        <a href="#" class="block text-gray-300 hover:bg-gray-600 hover:text-white px-3 py-2 rounded-md text-base font-medium">Electronics</a>
                        <a href="#" class="block text-gray-300 hover:bg-gray-600 hover:text-white px-3 py-2 rounded-md text-base font-medium">Books</a>
                        <a href="#" class="block text-gray-300 hover:bg-gray-600 hover:text-white px-3 py-2 rounded-md text-base font-medium">Perfumes</a>
                        <a href="#" class="block text-gray-300 hover:bg-gray-600 hover:text-white px-3 py-2 rounded-md text-base font-medium">Appliances</a>
                    </div> <a href="#" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Stock Adjustments</a>
                    <a href="#" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Reports</a>
                    <a href="#" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Settings</a>
                </div>
                <!-- Add a collapsible category menu -->

            </div>
        </div>

    </nav>

    <div class="container" style="height: 560px; width:auto;">

    </div>

    <footer class="bg-gray-800 text-white text-center py-4 mt-8">
        <p>&copy; 2024 InvenHammad. All rights reserved.</p>
    </footer>


    <script>
        // Toggle visibility of dropdowns and search bar
        function toggleDropdown(id) {
            const element = document.getElementById(id);
            element.classList.toggle('hidden');
        }

        function toggleSearchBar() {
            const searchBar = document.getElementById('search-bar');
            searchBar.classList.toggle('hidden');
        }

        document.addEventListener('keydown', (event) => {
            const searchBar = document.getElementById('search-bar');
            if (event.key === 'Escape' && !searchBar.classList.contains('hidden')) {
                searchBar.classList.add('hidden');
            }
        });

        // Close all dropdowns except the active one
        document.addEventListener('click', (event) => {
            const dropdowns = ['category-dropdown', 'user-menu'];
            dropdowns.forEach(id => {
                const dropdown = document.getElementById(id);
                const button = document.querySelector(`[onclick*='${id}']`);
                if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });

            // Close search bar if clicked outside
            const searchBar = document.getElementById('search-bar');
            const searchButton = document.getElementById('search-button');
            if (!searchBar.contains(event.target) && !searchButton.contains(event.target)) {
                searchBar.classList.add('hidden');
            }
        });
        //
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        function toggleDropdown(id) {
            const element = document.getElementById(id);
            element.classList.toggle('hidden');
        }
    </script>
</body>

</html>

////////////////////////////////


<section class="bg-gradient-to-br from-blue-100 via-white to-blue-50 min-h-screen flex items-center justify-center relative">

    <!-- Back Button -->
    <div class="absolute top-4 left-4 sm:top-6 sm:left-8 z-30">
        <a href="/index"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-800 rounded-lg shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500">
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <div class="relative z-20 mx-auto px-6 lg:px-8">

        <?php

        use inventory\lib\alertHandler;

        $alertHandler = alertHandler::getInstance();
        $alertHandler->handleAlert();
        ?>

        <!-- Form Container -->
        <div class="w-full max-w-3xl bg-white my-16 p-8 rounded-lg shadow-xl dark:border dark:border-gray-700 sm:max-w-xl xl:p-10 dark:bg-gray-900">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-8">Create Your Account</h2>
            <p class="text-center text-gray-600 dark:text-gray-400 mb-6">
                Join us and start managing your inventory effortlessly!
            </p>

            <!-- Social Media Login -->
            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-6">
                <!-- Google Login -->
                <a href="/auth/google"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm font-medium text-black bg-white hover:bg-white rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-white transition-transform transform hover:scale-105">
                    <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                        <path fill="#EA4335"
                            d="M24 9.5c3.59 0 6.84 1.32 9.35 3.49l7.02-7.03C36.58 2.05 30.69 0 24 0 14.49 0 6.33 5.55 2.77 13.5l8.49 6.59C13.31 14.3 18.32 9.5 24 9.5z" />
                        <path fill="#34A853"
                            d="M46.1 24.5c0-1.77-.18-3.49-.51-5.17H24v9.77h12.45c-1.08 3.68-4.02 6.67-7.65 7.81v6.5h12.38c7.23-6.63 11.37-16.39 11.37-27.41z" />
                        <path fill="#4A90E2"
                            d="M24 48c6.48 0 11.91-2.14 15.87-5.78l-12.38-6.5c-1.56 1.01-3.57 1.6-5.5 1.6-5.68 0-10.69-4.8-11.74-11.21l-8.51 6.58c3.57 7.95 11.73 13.5 21.26 13.5z" />
                        <path fill="#FBBC05"
                            d="M2.77 13.5c-1.45 3.01-2.27 6.39-2.27 9.99s.82 6.98 2.27 9.99l8.49-6.58c-.57-1.72-.89-3.58-.89-5.41s.32-3.69.89-5.41l-8.49-6.58z" />
                    </svg>
                    Continue with Google
                </a>

                <!-- Facebook Login -->
                <a href="/auth/facebook"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition-transform transform hover:scale-105">
                    <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M22.676 0H1.324C.594 0 0 .594 0 1.324v21.352C0 23.406.594 24 1.324 24H12v-9.293H9.293V11.5H12V8.793c0-2.689 1.548-4.207 3.915-4.207 1.136 0 2.332.205 2.332.205v2.573h-1.311c-1.294 0-1.693.804-1.693 1.627V11.5h3.012l-.481 3.207h-2.531V24h4.953c.73 0 1.324-.594 1.324-1.324V1.324C24 .594 23.406 0 22.676 0z" />
                    </svg>
                    Continue with Facebook
                </a>
            </div>

            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
                </div>
                <div class="relative text-center">
                    <span class="bg-white dark:bg-gray-900 px-4 text-sm text-gray-500 dark:text-gray-400">Or sign up with your email</span>
                </div>
            </div>

            <form action="/index/registration" method="POST" class="space-y-6" enctype="multipart/form-data">
                <!-- Name Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-900 dark:text-gray-300">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="first_name" name="first_name" required
                            class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white">
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-900 dark:text-gray-300">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="last_name" name="last_name" required
                            class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900 dark:text-gray-300">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" required placeholder="yourname@example.com"
                        class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white">
                </div>

                <!-- Phone Number with Country Selector -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-900 dark:text-gray-300">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center mt-1">
                        <select id="country_code" name="country_code"
                            class="block w-36 px-4 py-2 bg-gray-50 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm hover:bg-gray-100 transition duration-300 ease-in-out sm:w-40 md:w-44 lg:w-44 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:ring-blue-600 dark:hover:bg-gray-700">
                            <option data-countryCode="KM" value="269">Comoros (+269)</option>
                            <option data-countryCode="DK" value="45">Denmark (+45)</option>
                            <option data-countryCode="DJ" value="253">Djibouti (+253)</option>
                            <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
                            <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
                            <option data-countryCode="EC" value="593">Ecuador (+593)</option>
                            <option data-countryCode="EG" value="20" selected>Egypt (+20)</option>
                            <option data-countryCode="SV" value="503">El Salvador (+503)</option>
                            <option data-countryCode="ZM" value="260">Zambia (+260)</option>
                            <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
                        </select>
                        <input type="tel" id="phone" name="phone" placeholder="123 456 7890" required
                            class="block w-full px-4 py-2 bg-gray-50 border rounded-r-lg focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white">
                    </div>
                </div>

                <!-- Password Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-900 dark:text-gray-300">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white">
                        <small class="text-gray-500 dark:text-gray-400">At least 8 characters, including letters and numbers</small>
                    </div>
                    <div>
                        <label for="confirm_password"
                            class="block text-sm font-medium text-gray-900 dark:text-gray-300">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="confirm_password" name="confirm_password" required
                            class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white">
                    </div>
                </div>

                <!-- Gender Fields -->

                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-900 dark:text-gray-300 mb-2">
                        Gender <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-6">
                        <div class="flex items-center">
                            <input type="radio" id="male" name="gender" value="male"
                                class="w-4 h-4 text-blue-600 bg-gray-50 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="male" class="ml-2 text-sm text-gray-900 dark:text-gray-300">Male</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="female" name="gender" value="female"
                                class="w-4 h-4 text-blue-600 bg-gray-50 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="female" class="ml-2 text-sm text-gray-900 dark:text-gray-300">Female</label>
                        </div>
                    </div>
                </div>


                <!-- Date of birth -->
                <div>
                    <label for="birthday" class="block text-sm font-medium text-gray-900 dark:text-gray-300">
                        Date of birth
                    </label>
                    <input type="date" id="birthday" name="birthday" required
                        class="mt-2 w-full px-4 py-2 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white">
                </div>

                <!-- Terms -->
                <div class="flex items-start mt-4">
                    <input type="checkbox" id="terms" name="terms" required
                        class="w-4 h-4 mt-1 text-blue-600 bg-gray-50 border rounded focus:ring-blue-500 focus:ring-2 dark:bg-gray-800 dark:border-gray-700">
                    <label for="terms" class="ml-3 text-sm text-gray-900 dark:text-gray-300">
                        I agree to the <a href="#" class="text-blue-600 hover:underline">Terms and Conditions</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="w-full px-5 py-3 mt-4 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                        Create Account
                    </button>
                </div>
            </form>

            <p class="mt-6 text-sm text-center text-gray-600 dark:text-gray-400">
                Already have an account? <a href="/index/login" class="text-blue-600 hover:underline font-medium">Login
                    here</a>
            </p>
        </div>
    </div>
</section>