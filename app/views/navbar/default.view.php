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
                    <a href="/index" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    <div class="relative">
                        <button id="category-button"
                            class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium focus:outline-none"
                            onclick="toggleDropdown('category-dropdown')">Categories</button>
                        <div id="category-dropdown"
                            class="hidden absolute left-0 mt-2 w-40 bg-white rounded-md shadow-lg ring-1 ring-black/5 z-50">
                            <?php
                            if (!empty($categories)) {
                                foreach ($categories as $category) {
                                    echo '<a href="/categories/' . strtolower($category['name']) . '" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">' . htmlspecialchars($category['name']) . '</a>';
                                }
                            } else {
                                echo '<p class="px-4 py-2 text-sm text-gray-500">No categories found</p>';
                            }
                            ?>
                        </div>

                    </div>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Stock Adjustments</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Reports</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Settings</a>
                </div>
            </div>

            <!-- Search -->
            <!-- (Same as your current code) -->

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
                    <?php
                    foreach ($categories as $category) {
                        echo '<a href="/categories/' . strtolower($category['name']) . '" class="block text-gray-300 hover:bg-gray-600 hover:text-white px-3 py-2 rounded-md text-base font-medium">' . htmlspecialchars($category['name']) . '</a>';
                    }
                    ?>
                </div>
            </div>
            <a href="#" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Stock Adjustments</a>
            <a href="#" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Reports</a>
            <a href="#" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Settings</a>
        </div>
    </div>
</nav>