<section class="min-h-[calc(101.1vh-8rem)] bg-gradient-to-br from-blue-100 via-white to-blue-50 min-h-screen flex items-center justify-center relative">
    <!-- Back Button -->
    <div class="absolute top-4 left-4 sm:top-6 sm:left-8 z-30">
        <a href="/home"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-800 rounded-lg shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500">
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <div class="relative my-12 z-20 mx-auto px-6 lg:px-8">
        <?php

        use inventory\lib\alertHandler;

        $alertHandler = alertHandler::getInstance();
        $alertHandler->handleAlert();
        ?>

        <!-- Form Container -->
        <div class="w-full max-w-3xl bg-white my-16 rounded-lg p-8 shadow-xl dark:border dark:border-gray-700 sm:max-w-xl xl:p-10 dark:bg-gray-900">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-8">Sign In</h2>
            <p class="text-center text-gray-600 dark:text-gray-400 mb-6">
                Join us and start managing your inventory effortlessly!
            </p>

            <!-- Social Media Login -->
            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-6">
                <!-- Google Login -->
                <button
                    id="googleSignIn"
                    class="w-full sm:w-auto flex items-center justify-center px-6 py-3 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 border border-gray-300 shadow-sm"
                    aria-label="Continue with Google">
                    <img
                        src="https://img.icons8.com/color/24/000000/google-logo.png"
                        alt="Google logo"
                        class="w-7 h-7 mr-2" />
                    Continue with Google
                </button>

                <!-- Facebook Login -->
                <a href="/facebook-auth/auth" class="w-full sm:w-auto flex items-center justify-center px-6 py-3 rounded-full text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200 shadow-sm">
                    <img src="https://img.icons8.com/color/24/000000/facebook-new.png" alt="Facebook logo" class="w-7 h-7 mr-2" />
                    Continue with Facebook
                </a>
            </div>

            <!-- Divider -->
            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
                </div>
                <div class="relative text-center">
                    <span class="bg-white dark:bg-gray-900 px-4 text-sm text-gray-500 dark:text-gray-400">Or sign in with your email</span>
                </div>
            </div>

            <!-- Login Form -->
            <form id="loginForm" class="space-y-6" action="/index/default" method="POST" novalidate>
                <!-- Email Field -->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your Email</label>
                    <input type="email" name="email" id="email" placeholder="you@example.com" required
                        class="w-full px-4 py-2 text-gray-900 bg-gray-50 border rounded-lg focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                        title="Please enter a valid email address">
                    <p class="text-sm text-red-500 mt-1 hidden" id="emailError">Please enter a valid email address</p>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" placeholder="••••••••" required
                            class="w-full px-4 py-2 text-gray-900 bg-gray-50 border rounded-lg focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            minlength="8">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center px-3">
                            <svg id="eyeIcon" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="text-sm text-red-500 mt-1 hidden" id="passwordError">Password must be at least 8 characters</p>
                </div>

                <!-- Remember Me and Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border rounded focus:ring-blue-500 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500">
                        <label for="remember" class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember Me</label>
                    </div>
                    <a href="/forgot-password" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">Forgot password?</a>
                </div>

                <!-- Sign In Button -->
                <button type="submit"
                    class="w-full px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                    Sign In
                </button>

                <!-- Sign Up Link -->
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
                    Don't have an account yet?
                    <a href="/index/registration" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Sign up</a>
                </p>
            </form>
        </div>
    </div>

    <!-- Google Sign-In Script -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>

    <!-- Client-side Form Validation and Password Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');
            const togglePasswordBtn = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');

            // Email validation
            emailInput.addEventListener('input', function() {
                const emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i;
                if (!emailPattern.test(emailInput.value)) {
                    emailError.classList.remove('hidden');
                    emailInput.classList.add('border-red-500');
                } else {
                    emailError.classList.add('hidden');
                    emailInput.classList.remove('border-red-500');
                }
            });

            // Password validation
            passwordInput.addEventListener('input', function() {
                if (passwordInput.value.length < 8) {
                    passwordError.classList.remove('hidden');
                    passwordInput.classList.add('border-red-500');
                } else {
                    passwordError.classList.add('hidden');
                    passwordInput.classList.remove('border-red-500');
                }
            });

            // Password visibility toggle
            togglePasswordBtn.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M11 14l-1-1m2 2l1 1m-2-2v3m-4.242-4.242a3 3 0 114.242-4.242"></path>
                `;
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
                }
            });

            // Form submission validation
            form.addEventListener('submit', function(event) {
                let isValid = true;

                // Email validation
                const emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i;
                if (!emailPattern.test(emailInput.value)) {
                    emailError.classList.remove('hidden');
                    emailInput.classList.add('border-red-500');
                    isValid = false;
                }

                // Password validation
                if (passwordInput.value.length < 8) {
                    passwordError.classList.remove('hidden');
                    passwordInput.classList.add('border-red-500');
                    isValid = false;
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });
        });


        // Google Sign-In Initialization
        window.onload = function() {
            google.accounts.id.initialize({
                client_id: '209547913831-sn0f0i11cvr6bk68vqmb9glhslgfs7kq.apps.googleusercontent.com',
                callback: handleGoogleAuth
            });

            google.accounts.id.renderButton(
                document.getElementById('googleSignIn'), {
                    theme: 'outline',
                    size: 'large',
                    width: '100%',
                    text: 'continue_with',
                    shape: 'pill'
                }
            );
        };

        async function handleGoogleAuth(response) {
            try {
                const res = await fetch('/google-auth/auth', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        credential: response.credential,
                        csrf_token: document.querySelector('meta[name="csrf-token"]')?.content
                    })
                });

                const data = await res.json();
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    // Show error using your alert system
                    if (typeof showAlert === 'function') {
                        showAlert(data.message || 'Authentication failed', 'error');
                    } else {
                        alert(data.message || 'Authentication failed');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                if (typeof showAlert === 'function') {
                    showAlert('An error occurred during authentication', 'error');
                } else {
                    alert('An error occurred during authentication');
                }
            }
        }
    </script>
</section>