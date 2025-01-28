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
    <nav class="bg-gray-800 sticky top-0 z-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Mobile Menu Button -->
                <div class="flex items-center sm:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        aria-controls="mobile-menu" aria-expanded="false" onclick="toggleMobileMenu()">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>

                <!-- Logo -->
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex items-center group">
                        <img class="h-10 w-auto transition-all duration-300 transform group-hover:rotate-6 group-hover:scale-110"
                            src="../../images/logo.png"
                            alt="Company Logo">
                        <a href="/home"
                            class="text-white font-bold text-lg sm:text-xl ml-2 sm:ml-3 tracking-wider hover:text-blue-300 transition-all duration-300 transform group-hover:translate-x-1">
                            InvenHammad
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden sm:flex sm:ml-6 space-x-4">
                        <a href="/home" class="relative text-gray-300 hover:text-white px-3 py-2 text-sm font-medium group">
                            <span class="relative z-10">Home</span>
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-400 origin-left transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-out"></span>
                        </a>
                        <a href="/categories" class="relative text-gray-300 hover:text-white px-3 py-2 text-sm font-medium group">
                            <span class="relative z-10">Categories</span>
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-400 origin-left transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-out"></span>
                        </a>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                            <a href="/stockAdjustments" class="relative text-gray-300 hover:text-white px-3 py-2 text-sm font-medium group">
                                <span class="relative z-10">Stock Adjustments</span>
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-400 origin-left transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-out"></span>
                            </a>
                            <a href="/reports" class="relative text-gray-300 hover:text-white px-3 py-2 text-sm font-medium group">
                                <span class="relative z-10">Reports</span>
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-400 origin-left transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-out"></span>
                            </a>
                        <?php endif; ?>
                        <a href="/about" class="relative text-gray-300 hover:text-white px-3 py-2 text-sm font-medium group">
                            <span class="relative z-10">About Us</span>
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-400 origin-left transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-out"></span>
                        </a>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <!-- Shopping Basket -->
                    <a href="/cart" class="relative p-2 bg-transparent rounded-full text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 transition-all duration-300 ease-in-out transform hover:scale-110 group">
                        <span class="sr-only">Shopping basket</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                        <?php if (isset($_SESSION['basket_count']) && $_SESSION['basket_count'] > 0): ?>
                            <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                                <?php echo $_SESSION['basket_count']; ?>
                            </span>
                        <?php endif; ?>
                    </a>

                    <!-- User Menu -->
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="relative">
                            <button id="user-menu-button" class="p-2 bg-transparent rounded-full text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 transition-all duration-300 ease-in-out transform hover:scale-110"
                                onclick="toggleDropdown('user-menu')">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 sm:h-10 sm:w-10 rounded-full" src="../../images/avatar322.jpg" alt="User avatar">
                            </button>
                            <div id="user-menu"
                                class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black/5 focus:outline-none">
                                <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-t-md">Your Profile</a>
                                <a href="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                <a href="#" onclick="showLogoutAlert(event)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-b-md">
                                    Sign out
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/index" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Sign In</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden sm:hidden">
            <div class="space-y-1 px-2 pt-2 pb-3">
                <a href="/home" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Home</a>
                <a href="/categories" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Categories</a>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                    <a href="/stockAdjustments" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Stock Adjustments</a>
                    <a href="/reports" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Reports</a>
                <?php endif; ?>
                <a href="/about" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">About Us</a>
            </div>
        </div>

        <!-- Logout Confirmation Modal -->
        <div id="logoutModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full mx-4">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Confirm Logout</h2>
                <p class="text-gray-600 mb-6">Are you sure you want to sign out?</p>
                <div class="flex justify-end space-x-4">
                    <button onclick="closeLogoutModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                    <a href="/logout" class="px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg hover:bg-gray-700">
                        Sign out
                    </a>
                </div>
            </div>
        </div>
    </nav>


    <main class="flex-grow container mx-auto py-6 min-h-[calc(101.1vh-8rem)] flex items-center justify-center px-4">
        <div class="text-center max-w-4xl">
            <!-- Animated 404 Number -->
            <div class="animate-float mb-8">
                <span class="text-8xl font-bold bg-gradient-to-r from-indigo-600 to-purple-500 bg-clip-text text-transparent sm:text-9xl">
                    404
                </span>
            </div>

            <!-- Illustration -->
            <div class="mb-12 animate-fade-in-up">
                <svg class="mx-auto h-48 w-48 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <!-- Content -->
            <h1 class="text-balance text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                Lost in the Digital Void?
            </h1>
            <p class="mt-4 text-pretty text-lg text-gray-600 sm:text-xl/relaxed">
                The page you're seeking has either drifted into cyberspace or never existed. Let's get you back on track.
            </p>

            <!-- Action Buttons -->
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="/home"
                    class="w-full sm:w-auto transform transition-all hover:scale-105 active:scale-95
                      rounded-lg bg-gradient-to-br from-indigo-600 to-indigo-500 px-6 py-3.5
                      text-base font-semibold text-white shadow-lg shadow-indigo-500/20
                      hover:shadow-indigo-500/40 focus-visible:outline focus-visible:outline-2
                      focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    🏠 Return to Homebase
                </a>

                <a href="mailto:support@invenhammad.com"
                    class="group flex items-center gap-2 text-sm font-semibold text-gray-900
                      hover:text-indigo-600 transition-colors duration-200">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-600 transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Contact Space Support
                </a>
            </div>

        </div>
    </main>

    <footer class="bg-gray-900">
        <!-- Main Footer Content -->
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
                <!-- Company Info -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <img
                            src="../../images/logo.png"
                            alt="InvenHammad Logo"
                            class="h-12 w-auto max-w-[150px] object-contain rounded-lg transition-all hover:scale-105">
                        <h3 class="text-xl font-bold text-white h-8">InvenHammad</h3>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Your premier destination for quality products.<br>
                        We deliver excellence in every purchase.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors duration-300" aria-label="Facebook">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-300 transition-colors duration-300" aria-label="X (formerly Twitter)">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-pink-500 transition-colors duration-300" aria-label="Instagram">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-700 transition-colors duration-300" aria-label="LinkedIn">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Quick Links
                    </h3>
                    <ul class="space-y-3">
                        <li><a href="/about" class="flex items-center gap-2 text-gray-400 hover:text-white transition-colors duration-300 text-sm">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                About Us
                            </a></li>
                        <li><a href="/categories" class="flex items-center gap-2 text-gray-400 hover:text-white transition-colors duration-300 text-sm">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Our Products
                            </a></li>
                    </ul>
                </div>

                <!-- Customer Service -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                        Customer Service
                    </h3>
                    <ul class="space-y-3">
                        <li><a href="/contact" class="flex items-center gap-2 text-gray-400 hover:text-white transition-colors duration-300 text-sm">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Contact Us
                            </a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Stay Updated
                    </h3>
                    <p class="text-gray-400 text-sm">Subscribe for updates and exclusive offers</p>
                    <form class="space-y-3">
                        <div class="relative">
                            <input
                                type="email"
                                placeholder="Your email"
                                class="w-full px-4 py-3 bg-gray-800 text-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition-all duration-300">
                            <svg class="absolute right-3 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <button
                            type="submit"
                            class="w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-300 text-sm font-semibold flex items-center justify-center gap-2">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Subscribe Now
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Enhanced Payment Methods Section -->
        <div class="bg-gray-900 border-t border-gray-800">
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <div class="text-center mb-8">
                    <h3 class="text-xl font-semibold text-white mb-4 flex items-center justify-center gap-2">
                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                        </svg>
                        Payment Methods
                    </h3>
                    <p class="text-gray-400 text-sm max-w-2xl mx-auto">
                        Secure and flexible payment options for your convenience. We accept all major credit cards and digital wallets.
                    </p>
                </div>
                <div class="flex flex-wrap justify-center items-center gap-6">
                    <!-- Updated Payment Icons with Better Sizing -->
                    <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa" title="Visa"
                        class="h-10 w-auto opacity-90 hover:opacity-100 hover:scale-110 transition-all duration-300">
                    <img src="https://img.icons8.com/color/48/000000/mastercard.png" alt="Mastercard" title="Mastercard"
                        class="h-10 w-auto opacity-90 hover:opacity-100 hover:scale-110 transition-all duration-300">
                    <img src="https://img.icons8.com/color/48/000000/paypal.png" alt="PayPal" title="PayPal"
                        class="h-10 w-auto opacity-90 hover:opacity-100 hover:scale-110 transition-all duration-300">
                    <img src="https://img.icons8.com/color/48/000000/apple-pay.png" alt="Apple Pay" title="Apple Pay"
                        class="h-10 w-auto opacity-90 hover:opacity-100 hover:scale-110 transition-all duration-300">
                    <img src="https://img.icons8.com/color/48/000000/google-wallet.png" alt="Google Pay" title="Google Pay"
                        class="h-10 w-auto opacity-90 hover:opacity-100 hover:scale-110 transition-all duration-300">
                    <!-- Local Payment Methods with Better Contrast -->
                    <img src="https://cdn.brandfetch.io/idW_Kii4-n/w/158/h/51/theme/dark/logo.png?c=1dxbfHSJFAPEGdCLU4o5B" alt="Fawry"
                        title="Fawry" class="h-8 w-auto opacity-90 hover:opacity-100 hover:scale-110 transition-all duration-300">
                    <img src="https://cdn.brandfetch.io/id6HZwtapX/theme/dark/symbol.svg?c=1dxbfHSJFAPEGdCLU4o5B" alt="Vodafone Cash"
                        title="Vodafone Cash" class="h-10 w-auto opacity-90 hover:opacity-100 hover:scale-110 transition-all duration-300">
                </div>
            </div>
        </div>



        <!-- Bottom Bar -->
        <div class="border-t border-gray-800">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <p class="text-sm text-gray-400 text-center md:text-left">
                        © 2025 InvenHammad. All rights reserved.
                    </p>
                    <div class="flex items-center justify-center gap-6">
                        <a href="/settings/privacySettings" class="text-sm text-gray-400 hover:text-white transition-colors duration-300 flex items-center gap-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Privacy Policy
                        </a>
                        <a href="/settings/terms" class="text-sm text-gray-400 hover:text-white transition-colors duration-300 flex items-center gap-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Terms of Service
                        </a>
                    </div>
                </div>
            </div>
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

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }

        function showLogoutAlert(event) {
            event.preventDefault();
            document.getElementById('logoutModal').classList.remove('hidden');
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.add('hidden');
        }
    </script>
</body>

</html>