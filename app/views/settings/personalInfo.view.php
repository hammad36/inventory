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
            <!-- Profile Picture Section -->
            <div class="flex items-center space-x-6">
                <div class="flex-shrink-0">
                    <img
                        src="<?php echo htmlspecialchars($user->getProfilePicture() ?: '/default-avatar.png'); ?>"
                        alt="Profile Picture"
                        class="h-20 w-20 rounded-full object-cover border-4 border-blue-500">
                </div>
                <div>
                    <label class="block">
                        <span class="sr-only">Choose profile photo</span>
                        <input
                            type="file"
                            name="profile_picture"
                            class="block w-full text-sm text-gray-500 
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100" />
                    </label>
                    <p class="text-xs text-gray-500 mt-2">JPG or PNG. Max size 5MB.</p>
                </div>
            </div>

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
                    <div>
                        <span class="text-gray-500">Last Updated:</span>
                        <p class="font-medium"><?php echo htmlspecialchars($user->getLastUpdated()); ?></p>
                    </div>
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