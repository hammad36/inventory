<main class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="bg-blue-600 text-white p-6">
            <h1 class="text-2xl font-bold">Account settings</h1>
            <p class="text-blue-100">Manage your profile and account preferences</p>
        </div>

        <div class="divide-y divide-gray-200">
            <!-- Personal Information -->
            <div class="p-6 hover:bg-gray-50 transition duration-200 flex items-center justify-between">
                <a href="/settings/personalInfo" class="text-blue-600 hover:text-blue-800 transition">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Personal Information</h2>
                        <p class="text-sm text-gray-500">Update your name, email, and profile details</p>
                    </div>
                    <a href="/settings/PersonalInfo" class="text-blue-600 hover:text-blue-800 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </a>
                </a>
            </div>

            <!-- Change Password -->
            <div class="p-6 hover:bg-gray-50 transition duration-200 flex items-center justify-between">
                <a href="/settings/changePassword" class="text-blue-600 hover:text-blue-800 transition">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Change Password</h2>
                        <p class="text-sm text-gray-500">Secure your account with a new password</p>
                    </div>
                    <a href="/settings/changePassword" class="text-blue-600 hover:text-blue-800 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </a>
                </a>
            </div>

            <!-- Privacy settings -->
            <div class="p-6 hover:bg-gray-50 transition duration-200 flex items-center justify-between">
                <a href="/settings/privacySettings" class="text-blue-600 hover:text-blue-800 transition">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Privacy settings</h2>
                        <p class="text-sm text-gray-500">Control your data and privacy preferences</p>
                    </div>
                    <a href="/settings/privacySettings" class="text-blue-600 hover:text-blue-800 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </a>
                </a>
            </div>

            <!-- Terms and Conditions -->
            <div class="p-6 hover:bg-gray-50 transition duration-200 flex items-center justify-between">
                <a href="/settings/terms" class="text-blue-600 hover:text-blue-800 transition">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Terms and Conditions</h2>
                        <p class="text-sm text-gray-500">Review our latest terms of service</p>
                    </div>
                    <a href="/settings/terms" class="text-blue-600 hover:text-blue-800 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </a>
                </a>
            </div>

            <!-- Logout -->
            <div class="p-6 hover:bg-gray-50 transition duration-200 flex items-center justify-between bg-red-50">
                <a href="/logout" class="text-red-600 hover:text-red-800 transition">
                    <div>
                        <h2 class="text-lg font-semibold text-red-700">Logout</h2>
                        <p class="text-sm text-red-500">End your current session</p>
                    </div>
                    <a href="/logout" class="text-red-600 hover:text-red-800 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </a>
                </a>
            </div>
        </div>
    </div>
</main>