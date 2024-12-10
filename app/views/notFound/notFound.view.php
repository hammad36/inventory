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
                    <!-- <img class="h-10 w-auto" src="images/logo.png" alt="Company Logo"> -->
                    <img class="h-10 w-auto" src="../../images/logo.png" alt="Company Logo">
                    <span class="text-white font-semibold text-lg ml-2">InvenHammad</span>

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

    <main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
        <div class="text-center">
            <p class="text-base font-semibold text-indigo-600">404</p>
            <h1 class="mt-4 text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Page not found</h1>
            <p class="mt-6 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">Sorry, we couldn’t find the page you’re looking for.</p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="/index" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Go back home</a>
                <a href="#" class="text-sm font-semibold text-gray-900">Contact support <span aria-hidden="true">&rarr;</span></a>
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
    </script>
</body>

</html>