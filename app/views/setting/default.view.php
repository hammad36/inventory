<main class="flex-grow container mx-auto py-6 min-h-[calc(100vh-8rem)]">
    <form action="/settings/edit" method="POST" class="max-w-4xl mx-auto p-8 bg-white rounded-lg shadow-lg mt-10 transform transition hover:scale-105 duration-300">
        <div class="flex flex-col items-center">
            <!-- Header -->
            <div class="flex items-center justify-between w-full mb-6">
                <h1 class="text-3xl font-bold text-blue-900">Settings</h1>
            </div>

            <p class="text-sm font-medium text-gray-500 mb-8">
                Role: <span class="text-blue-700"><?php echo htmlspecialchars($_SESSION['user']['role']); ?></span>
            </p>

            <!-- Settings Form -->
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-6 w-full text-center sm:text-left">
                <!-- First Name -->
                <div class="bg-blue-50 p-6 rounded-lg shadow-sm transform transition hover:scale-105 duration-300">
                    <h2 class="text-lg font-semibold text-blue-600">First Name</h2>
                    <input
                        type="text"
                        name="first_name"
                        value="<?php echo htmlspecialchars($_SESSION['user']['first_name']); ?>"
                        class="w-full border-b border-blue-300 focus:outline-none focus:border-blue-600 bg-transparent"
                        required>
                </div>

                <!-- Last Name -->
                <div class="bg-blue-50 p-6 rounded-lg shadow-sm transform transition hover:scale-105 duration-300">
                    <h2 class="text-lg font-semibold text-blue-600">Last Name</h2>
                    <input
                        type="text"
                        name="last_name"
                        value="<?php echo htmlspecialchars($_SESSION['user']['last_name']); ?>"
                        class="w-full border-b border-blue-300 focus:outline-none focus:border-blue-600 bg-transparent"
                        required>
                </div>

                <!-- Email -->
                <div class="bg-blue-50 p-6 rounded-lg shadow-sm transform transition hover:scale-105 duration-300">
                    <h2 class="text-lg font-semibold text-blue-600">Email</h2>
                    <input
                        type="email"
                        name="email"
                        value="<?php echo htmlspecialchars($_SESSION['user']['email']); ?>"
                        class="w-full border-b border-blue-300 focus:outline-none focus:border-blue-600 bg-transparent"
                        required>
                </div>

                <!-- Date of Birth -->
                <div class="bg-blue-50 p-6 rounded-lg shadow-sm transform transition hover:scale-105 duration-300">
                    <h2 class="text-lg font-semibold text-blue-600">Date of Birth</h2>
                    <input
                        type="date"
                        name="date_of_birth"
                        value="<?php echo htmlspecialchars($_SESSION['user']['date_of_birth']); ?>"
                        class="w-full border-b border-blue-300 focus:outline-none focus:border-blue-600 bg-transparent"
                        required>
                </div>

                <!-- Gender -->
                <div class="bg-blue-50 p-6 rounded-lg shadow-sm transform transition hover:scale-105 duration-300">
                    <h2 class="text-lg font-semibold text-blue-600">Gender</h2>
                    <select name="gender" class="w-full border-b border-blue-300 focus:outline-none focus:border-blue-600 bg-transparent">
                        <option value="Male" <?php echo $_SESSION['user']['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo $_SESSION['user']['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo $_SESSION['user']['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>

                <!-- Member Since -->
                <div class="bg-blue-50 p-6 rounded-lg shadow-sm transform transition hover:scale-105 duration-300">
                    <h2 class="text-lg font-semibold text-blue-600">Member Since</h2>
                    <p class="text-gray-700"><?php echo htmlspecialchars($_SESSION['user']['created_at']); ?></p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex space-x-4 w-full justify-center">
                <button type="submit" class="flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</main>