<main class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white p-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Privacy Settings</h1>
                <p class="text-blue-100">Control your data and privacy preferences</p>
            </div>
            <a href="/settings" class="text-white hover:text-blue-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
            <!-- Data Sharing -->
            <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800">Data Sharing</h2>
                <p class="text-sm text-gray-500">Manage how your data is shared with third-party services.</p>
                <div class="mt-4 flex items-center">
                    <label for="data-sharing" class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="data-sharing" class="sr-only">
                        <div class="w-10 h-5 bg-gray-200 rounded-full shadow-inner toggle-bg"></div>
                        <div class="toggle-dot absolute w-4 h-4 bg-white rounded-full shadow inset-y-0 left-0"></div>
                    </label>
                    <span class="ml-3 text-sm text-gray-600">Allow data sharing</span>
                </div>
            </div>

            <!-- Activity Tracking -->
            <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800">Activity Tracking</h2>
                <p class="text-sm text-gray-500">Enable or disable tracking of your activity on our platform.</p>
                <div class="mt-4 flex items-center">
                    <label for="activity-tracking" class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="activity-tracking" class="sr-only">
                        <div class="w-10 h-5 bg-gray-200 rounded-full shadow-inner toggle-bg"></div>
                        <div class="toggle-dot absolute w-4 h-4 bg-white rounded-full shadow inset-y-0 left-0"></div>
                    </label>
                    <span class="ml-3 text-sm text-gray-600">Enable activity tracking</span>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold text-red-700">Delete Account</h2>
                <p class="text-sm text-gray-500">Permanently delete your account and all associated data.</p>
                <button class="mt-4 bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition">
                    Delete My Account
                </button>
            </div>
        </div>
    </div>
</main>