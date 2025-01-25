<!DOCTYPE html>
<html lang="en">
<section class="min-h-[calc(101.1vh-8rem)] bg-gradient-to-br from-blue-100 via-white to-blue-50 flex items-center justify-center relative">
    <!-- Back Button -->
    <div class="absolute top-4 left-4 sm:top-6 sm:left-8 z-30">
        <a href="/home"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-800 rounded-lg shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500">
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <div class="relative my-12 z-20 mx-auto px-6 lg:px-8">
        <!-- Form Container -->
        <div class="w-full max-w-3xl bg-white my-16 p-8 rounded-lg shadow-xl dark:border dark:border-gray-700 sm:max-w-xl xl:p-10 dark:bg-gray-900">
            <?php

            use inventory\lib\alertHandler;

            $alertHandler = alertHandler::getInstance();
            $alertHandler->handleAlert();
            ?>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-8">Create Your Account</h2>
            <p class="text-center text-gray-600 dark:text-gray-400 mb-6">
                Join us and start managing your inventory effortlessly!
            </p>

            <!-- Enhanced Form with Client-Side Validation -->
            <form id="registrationForm" action="/index/registration" method="POST" class="space-y-6" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">


                <!-- Name Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-900 dark:text-gray-300">First Name <span class="text-red-500">*</span></label>
                        <input type="text" id="first_name" name="first_name" required minlength="2" maxlength="50"
                            pattern="^[A-Za-z\s'-]+$"
                            class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white"
                            oninvalid="this.setCustomValidity('Please enter a valid first name (2-50 characters, letters only)')"
                            oninput="this.setCustomValidity('')">
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" id="last_name" name="last_name" required minlength="2" maxlength="50"
                            pattern="^[A-Za-z\s'-]+$"
                            class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white"
                            oninvalid="this.setCustomValidity('Please enter a valid last name (2-50 characters, letters only)')"
                            oninput="this.setCustomValidity('')">
                    </div>
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" required placeholder="yourname@example.com"
                        class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white"
                        oninvalid="this.setCustomValidity('Please enter a valid email address')"
                        oninput="this.setCustomValidity('')">
                </div>

                <!-- Password Fields with Strength Indicator -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Password <span class="text-red-500">*</span></label>
                        <input type="password" id="password" name="password" required
                            minlength="12" maxlength="64"
                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$"
                            class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white"
                            oninvalid="this.setCustomValidity('Password must be 12-64 characters with uppercase, lowercase, number, and special character')"
                            oninput="this.setCustomValidity('')">
                        <div id="password-strength" class="h-1 mt-1 rounded"></div>
                        <small class="text-gray-500 dark:text-gray-400">At least 12 characters, including uppercase, lowercase, number, and special character</small>
                    </div>
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" id="confirm_password" name="confirm_password" required
                            class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white"
                            oninvalid="this.setCustomValidity('Passwords must match')"
                            oninput="this.setCustomValidity('')">
                    </div>
                </div>

                <!-- Gender, Role, and Date of Birth -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Gender <span class="text-red-500">*</span></label>
                        <select id="gender" name="gender" required class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>

                        </select>
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Role <span class="text-red-500">*</span></label>
                        <select id="role" name="role" required class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white">
                            <option value="">Select Role</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-1 gap-6">
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Date of Birth <span class="text-red-500">*</span></label>
                        <input type="date" id="date_of_birth" name="date_of_birth" required
                            max="<?php echo date('Y-m-d', strtotime('-13 years')); ?>"
                            class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white">
                    </div>
                </div>

                <!-- Terms -->
                <div class="flex items-start mt-4">
                    <input type="checkbox" id="terms" name="terms" required
                        class="w-4 h-4 mt-1 text-blue-600 bg-gray-50 border rounded focus:ring-blue-500 focus:ring-2 dark:bg-gray-800 dark:border-gray-700"
                        oninvalid="this.setCustomValidity('You must agree to the terms and conditions')"
                        oninput="this.setCustomValidity('')">
                    <label for="terms" class="ml-3 text-sm text-gray-900 dark:text-gray-300">
                        I agree to the <a href="#" class="text-blue-600 hover:underline">Terms and Conditions</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="w-full px-5 py-3 mt-4 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Sign Up
                    </button>
                </div>
            </form>
            <p class="mt-6 text-sm text-center text-gray-600 dark:text-gray-400">
                Already have an account? <a href="/index" class="text-blue-600 hover:underline font-medium">Sign In</a>
            </p>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const passwordStrengthIndicator = document.getElementById('password-strength');
        const registrationForm = document.getElementById('registrationForm');

        // Password strength and match validation
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;

            // Check password strength
            if (password.length >= 12) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[@$!%*?&]/.test(password)) strength++;

            // Update strength indicator
            passwordStrengthIndicator.classList.remove('bg-red-500', 'bg-yellow-500', 'bg-green-500');

            if (strength <= 2) {
                passwordStrengthIndicator.classList.add('bg-red-500');
                passwordStrengthIndicator.style.width = '33%';
            } else if (strength <= 4) {
                passwordStrengthIndicator.classList.add('bg-yellow-500');
                passwordStrengthIndicator.style.width = '66%';
            } else {
                passwordStrengthIndicator.classList.add('bg-green-500');
                passwordStrengthIndicator.style.width = '100%';
            }
        });

        // Password match validation
        confirmPasswordInput.addEventListener('input', function() {
            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity('Passwords do not match');
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        });

        // Client-side form validation
        registrationForm.addEventListener('submit', function(event) {
            const requiredFields = registrationForm.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.checkValidity()) {
                    field.reportValidity();
                    isValid = false;
                }
            });

            if (!isValid) {
                event.preventDefault();
            }
        });
    });
</script>