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
                <h1 class="text-2xl font-bold">Change Password</h1>
                <p class="text-blue-100">Secure your account with a new password</p>
            </div>
            <a href="/settings" class="text-white hover:text-blue-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>

        <!-- Password Change Form -->
        <form
            action="/settings/changePassword"
            method="POST"
            class="p-6 space-y-6"
            id="password-change-form"
            onsubmit="return validatePasswordForm()">
            <?php

            use inventory\lib\alertHandler;

            $alertHandler = alertHandler::getInstance();
            $alertHandler->handleAlert();
            ?>
            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                <div class="relative">
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        required
                        minlength="8"
                        class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <button
                        type="button"
                        onclick="togglePasswordVisibility('current_password')"
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- New Password -->
            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                <div class="relative">
                    <input
                        type="password"
                        id="new_password"
                        name="new_password"
                        required
                        minlength="8"
                        class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <button
                        type="button"
                        onclick="togglePasswordVisibility('new_password')"
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <div id="password-strength" class="mt-2 h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div id="password-strength-bar" class="h-full w-0 transition-all duration-300"></div>
                </div>
                <p id="password-strength-text" class="text-xs mt-1 text-gray-500">Password strength</p>
            </div>

            <!-- Confirm New Password -->
            <div>
                <label for="confirm_new_password" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                <div class="relative">
                    <input
                        type="password"
                        id="confirm_new_password"
                        name="confirm_new_password"
                        required
                        minlength="8"
                        class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <button
                        type="button"
                        onclick="togglePasswordVisibility('confirm_new_password')"
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Password Requirements -->
            <div class="bg-gray-50 p-4 rounded-md text-sm text-gray-600">
                <h3 class="font-semibold mb-2">Password Requirements:</h3>
                <ul class="list-disc list-inside space-y-1">
                    <li id="length-req">At least 8 characters long</li>
                    <li id="uppercase-req">Contains at least one uppercase letter</li>
                    <li id="lowercase-req">Contains at least one lowercase letter</li>
                    <li id="number-req">Contains at least one number</li>
                    <li id="special-req">Contains at least one special character</li>
                </ul>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Change Password
                </button>
            </div>
        </form>
    </div>
</main>

<script>
    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    function validatePasswordForm() {
        const currentPassword = document.getElementById('current_password');
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('confirm_new_password');

        // Check if new passwords match
        if (newPassword.value !== confirmPassword.value) {
            alert('New passwords do not match');
            return false;
        }

        // Prevent using the same password
        if (currentPassword.value === newPassword.value) {
            alert('New password must be different from current password');
            return false;
        }

        return true;
    }

    function checkPasswordStrength(password) {
        const strengthBar = document.getElementById('password-strength-bar');
        const strengthText = document.getElementById('password-strength-text');
        const lengthReq = document.getElementById('length-req');
        const uppercaseReq = document.getElementById('uppercase-req');
        const lowercaseReq = document.getElementById('lowercase-req');
        const numberReq = document.getElementById('number-req');
        const specialReq = document.getElementById('special-req');

        // Reset styles
        [lengthReq, uppercaseReq, lowercaseReq, numberReq, specialReq].forEach(el => {
            el.classList.remove('text-green-600', 'text-red-600');
        });

        // Strength criteria
        const hasLength = password.length >= 8;
        const hasUppercase = /[A-Z]/.test(password);
        const hasLowercase = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

        // Update requirement indicators
        lengthReq.classList.add(hasLength ? 'text-green-600' : 'text-red-600');
        uppercaseReq.classList.add(hasUppercase ? 'text-green-600' : 'text-red-600');
        lowercaseReq.classList.add(hasLowercase ? 'text-green-600' : 'text-red-600');
        numberReq.classList.add(hasNumber ? 'text-green-600' : 'text-red-600');
        specialReq.classList.add(hasSpecial ? 'text-green-600' : 'text-red-600');

        // Calculate strength
        const strength =
            (hasLength ? 1 : 0) +
            (hasUppercase ? 1 : 0) +
            (hasLowercase ? 1 : 0) +
            (hasNumber ? 1 : 0) +
            (hasSpecial ? 1 : 0);

        // Update strength bar
        strengthBar.style.width = `${strength * 20}%`;
        strengthBar.className = `h-full transition-all duration-300 ${
        strength <= 2 ? 'bg-red-500' : 
        strength <= 4 ? 'bg-yellow-500' : 
        'bg-green-500'
    }`;

        // Update strength text
        strengthText.textContent =
            strength <= 2 ? 'Weak Password' :
            strength <= 4 ? 'Medium Strength' :
            'Strong Password';
    }

    // Add event listener for password strength
    document.getElementById('new_password').addEventListener('input', function() {
        checkPasswordStrength(this.value);
    });
</script>