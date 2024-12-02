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
                    <!-- <img class="h-10 w-auto" src="images/logo.png" alt="Company Logo"> -->
                    <img class="h-10 w-auto" src="../../images/logo.png" alt="Company Logo">
                    <a href="/index" class="text-white font-semibold text-lg ml-2">InvenHammad</a>

                    <!-- Desktop Navigation -->
                    <div class="hidden sm:flex sm:ml-6 space-x-4 ml-10">
                        <a href="/index" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium ">Home</a>
                        <a href="/categories" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Categories</a>
                        <a href="/adjustments" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Stock Adjustments</a>
                        <a href="/reports" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Reports</a>
                        <a href="/about" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">About Us</a>
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
                        <!-- <img class="h-10 w-10 rounded-full" src="images/avatar322.jpg" alt="User avatar"> -->
                        <img class="h-10 w-10 rounded-full" src="../../images/avatar322.jpg" alt="User avatar">
                    </button>
                    <div id="user-menu"
                        class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black/5 focus:outline-none z-50">
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
                <a href="/index" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Home</a>
                <a href="/categories" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Categories</a>
                <a href="/adjustments" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Stock Adjustments</a>
                <a href="/reports" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Reports</a>
                <a href="/about" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">About Us</a>
            </div>
        </div>

    </nav>