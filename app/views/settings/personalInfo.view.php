<?php
if (!isset($_SESSION['user'])) {
    echo '
        <div class="min-h-screen flex items-center justify-center">
            <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-xl shadow-2xl border border-gray-100 transform transition-all hover:scale-[1.01]">
                <div class="text-center">
                    <svg class="mx-auto h-16 w-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                        Authentication Required
                    </h2>
                    <p class="mt-4 text-lg text-gray-600">
                        You need to be signed in to view this content.
                    </p>
                    <div class="mt-8 space-y-4">
                        <a href="/index" 
                           class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Sign In Now
                        </a>
                        <p class="text-sm text-gray-500">
                            Don\'t have an account? 
                            <a href="/register" class="font-medium text-blue-600 hover:text-blue-500">
                                Create one here
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>';
    return;
}
?>
<main class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white p-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Personal Information</h1>
                <p class="text-blue-100">Manage and update your profile details</p>
            </div>
            <a href="/settings" class="text-white hover:text-blue-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>

        <!-- Profile Form -->
        <form action="/settings/personalInfo" method="POST" class="p-6 space-y-6">

            <?php

            use inventory\lib\alertHandler;

            $alertHandler = alertHandler::getInstance();
            $alertHandler->handleAlert();
            ?>
            <!-- Personal Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        value="<?php echo htmlspecialchars($user->getFirstName()); ?>"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        value="<?php echo htmlspecialchars($user->getLastName()); ?>"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Email -->
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo htmlspecialchars($user->getEmail()); ?>"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                    <input
                        type="date"
                        id="date_of_birth"
                        name="date_of_birth"
                        value="<?php echo htmlspecialchars($user->getDateOfBirth()); ?>"
                        required
                        max="<?php echo date('Y-m-d', strtotime('-13 years')); ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                    <select
                        id="gender"
                        name="gender"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Gender</option>
                        <option value="Male" <?php echo $user->getGender() === 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo $user->getGender() === 'Female' ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo $user->getGender() === 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="bg-gray-50 p-4 rounded-md">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Account Details</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Member Since:</span>
                        <p class="font-medium"><?php echo htmlspecialchars($user->getCreatedAt()); ?></p>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Save Changes
                    </button>
                </div>
        </form>
    </div>
</main>