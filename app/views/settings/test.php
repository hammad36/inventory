<main class="flex-grow container mx-auto py-6 min-h-[calc(100vh-8rem)]">
    <form
        action="/settings/edit"
        method="POST"
        class="max-w-4xl mx-auto p-8 bg-white rounded-lg shadow-2xl mt-10 space-y-6"
        id="settings-form"
        onsubmit="return validateForm()">
        <div class="flex flex-col">
            <!-- Header and Role -->
            <div class="flex items-center justify-between w-full mb-6">
                <h1 class="text-4xl font-extrabold text-blue-900">User settings</h1>
                <p class="text-sm font-medium text-gray-500">
                    Role: <span class="text-blue-700 font-bold"><?php echo htmlspecialchars($user->getRole()); ?></span>
                </p>
            </div>

            <?php

            use inventory\lib\alertHandler;

            alertHandler::getInstance()->handleAlert();
            ?>

            <!-- settings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div class="flex flex-col space-y-2">
                    <label for="first_name" class="block text-lg font-semibold text-blue-600">First Name</label>
                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        value="<?php echo htmlspecialchars($user->getFirstName()); ?>"
                        class="w-full border-b border-blue-300 focus:outline-none focus:border-blue-600 bg-transparent px-2 py-1 transition duration-300"
                        required
                        minlength="2"
                        aria-describedby="first-name-help">
                    <small id="first-name-help" class="text-xs text-gray-500 block">Minimum 2 characters</small>
                </div>

                <!-- Last Name -->
                <div class="flex flex-col space-y-2">
                    <label for="last_name" class="block text-lg font-semibold text-blue-600">Last Name</label>
                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        value="<?php echo htmlspecialchars($user->getLastName()); ?>"
                        class="w-full border-b border-blue-300 focus:outline-none focus:border-blue-600 bg-transparent px-2 py-1 transition duration-300"
                        required
                        minlength="2"
                        aria-describedby="last-name-help">
                    <small id="last-name-help" class="text-xs text-gray-500 block">Minimum 2 characters</small>
                </div>

                <!-- Email -->
                <div class="flex flex-col space-y-2">
                    <label for="email" class="block text-lg font-semibold text-blue-600">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo htmlspecialchars($user->getEmail()); ?>"
                        class="w-full border-b border-blue-300 focus:outline-none focus:border-blue-600 bg-transparent px-2 py-1 transition duration-300"
                        required
                        aria-describedby="email-help">
                    <small id="email-help" class="text-xs text-gray-500 block">Valid email required</small>
                </div>

                <!-- Date of Birth -->
                <div class="flex flex-col space-y-2">
                    <label for="date_of_birth" class="block text-lg font-semibold text-blue-600">Date of Birth</label>
                    <input
                        type="date"
                        id="date_of_birth"
                        name="date_of_birth"
                        value="<?php echo htmlspecialchars($user->getDateOfBirth()); ?>"
                        class="w-full border-b border-blue-300 focus:outline-none focus:border-blue-600 bg-transparent px-2 py-1 transition duration-300"
                        required
                        max="<?php echo date('Y-m-d', strtotime('-13 years')); ?>">
                </div>

                <!-- Gender -->
                <div class="flex flex-col space-y-2">
                    <label for="gender" class="block text-lg font-semibold text-blue-600">Gender</label>
                    <select
                        id="gender"
                        name="gender"
                        class="w-full border-b border-blue-300 focus:outline-none focus:border-blue-600 bg-transparent px-2 py-1 transition duration-300"
                        required>
                        <option value="">Select Gender</option>
                        <option value="Male" <?php echo $user->getGender() === 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo $user->getGender() === 'Female' ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>

                <!-- Password -->
                <div class="flex flex-col space-y-2">
                    <label for="password" class="block text-lg font-semibold text-blue-600">New Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full border-b border-blue-300 focus:outline-none focus:border-blue-600 bg-transparent px-2 py-1 transition duration-300"
                        minlength="8"
                        aria-describedby="password-help">
                    <small id="password-help" class="text-xs text-gray-500 block">Optional, minimum 8 characters</small>
                </div>

                <!-- Confirm Password -->
                <div class="flex flex-col space-y-2">
                    <label for="confirm_password" class="block text-lg font-semibold text-blue-600">Confirm New Password</label>
                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        class="w-full border-b border-blue-300 focus:outline-none focus:border-blue-600 bg-transparent px-2 py-1 transition duration-300"
                        minlength="8"
                        aria-describedby="confirm-password-help">
                    <small id="confirm-password-help" class="text-xs text-gray-500 block">Repeat new password</small>
                </div>

                <!-- Member Since -->
                <div class="col-span-1 md:col-span-2 bg-blue-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold text-blue-600 mb-2">Member Since</h2>
                    <p class="text-gray-700"><?php echo htmlspecialchars($user->getCreatedAt()); ?></p>
                </div>
            </div>
            setting
            <!-- Submit Button -->
            <div class="mt-8 flex justify-center">
                <button
                    type="submit"
                    class="flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition focus:outline-none focus:ring focus:ring-blue-300"
                    aria-label="Save Changes">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</main>

<script>
    function validateForm() {
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        const passwordHelp = document.getElementById('password-help');
        const confirmPasswordHelp = document.getElementById('confirm-password-help');

        // Reset previous error states
        password.classList.remove('border-red-500');
        confirmPassword.classList.remove('border-red-500');
        passwordHelp.classList.remove('text-red-500');
        confirmPasswordHelp.classList.remove('text-red-500');

        // Only validate if password is entered
        if (password.value) {
            if (password.value.length < 8) {
                password.classList.add('border-red-500');
                passwordHelp.classList.add('text-red-500');
                passwordHelp.textContent = 'Password must be at least 8 characters';
                return false;
            }

            if (password.value !== confirmPassword.value) {
                confirmPassword.classList.add('border-red-500');
                confirmPasswordHelp.classList.add('text-red-500');
                confirmPasswordHelp.textContent = 'Passwords do not match';
                return false;
            }
        }

        return true;
    }
</script>