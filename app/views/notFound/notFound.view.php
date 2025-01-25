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


    <main class="flex-grow container mx-auto py-6 min-h-[calc(101.1vh-8rem)]">
        <div class="text-center">
            <p class="text-base font-semibold text-indigo-600">404</p>
            <h1 class="mt-4 text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Page not found</h1>
            <p class="mt-6 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">Sorry, we couldn’t find the page you’re looking for.</p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="/home" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Go back home</a>
                <a href="/about" class="text-sm font-semibold text-gray-900">Contact support <span aria-hidden="true">&rarr;</span></a>
            </div>
        </div>
    </main>


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