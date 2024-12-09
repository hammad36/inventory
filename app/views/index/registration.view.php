<section class="bg-gradient-to-br from-blue-100 via-white to-blue-50 min-h-screen flex items-center justify-center relative">

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
        <div class="w-full max-w-3xl bg-white my-16 p-8 rounded-lg shadow-xl dark:border dark:border-gray-700 sm:max-w-xl xl:p-10 dark:bg-gray-900">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-8">Create Your Account</h2>
            <p class="text-center text-gray-600 dark:text-gray-400 mb-6">
                Join us and start managing your inventory effortlessly!
            </p>

            <!-- Social Media Login -->
            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-6">

                <!-- Google Login -->
                <div id="g_id_onload"
                    data-client_id="281698038178-al3jc4eqjf8nie8buk55djra2bqk7841.apps.googleusercontent.com"
                    data-context="signin"
                    data-ux_mode="popup"
                    data-login_uri="loginCallback"
                    data-itp_support="true">
                </div>

                <div class="g_id_signin"
                    data-type="standard"
                    data-shape="pill"
                    data-theme="outline"
                    data-text="continue_with"
                    data-size="large"
                    data-locale="en-US"
                    data-logo_alignment="left">
                </div>

                <!-- Facebook Login -->
                <a href="/auth/facebook"
                    class="w-full sm:w-auto flex items-center justify-center px-4 rounded-full text-sm font-medium text-white bg-blue-600">
                    <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M22.676 0H1.324C.594 0 0 .594 0 1.324v21.352C0 23.406.594 24 1.324 24H12v-9.293H9.293V11.5H12V8.793c0-2.689 1.548-4.207 3.915-4.207 1.136 0 2.332.205 2.332.205v2.573h-1.311c-1.294 0-1.693.804-1.693 1.627V11.5h3.012l-.481 3.207h-2.531V24h4.953c.73 0 1.324-.594 1.324-1.324V1.324C24 .594 23.406 0 22.676 0z" />
                    </svg>
                    Continue with Facebook
                </a>
            </div>

            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
                </div>
                <div class="relative text-center">
                    <span class="bg-white dark:bg-gray-900 px-4 text-sm text-gray-500 dark:text-gray-400">Or sign up with your email</span>
                </div>
            </div>

            <form action="/index/registration" method="POST" class="space-y-6" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

                <!-- Name Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-900 dark:text-gray-300">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="first_name" name="first_name" required
                            class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white">
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-900 dark:text-gray-300">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="last_name" name="last_name" required
                            class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900 dark:text-gray-300">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" required placeholder="yourname@example.com"
                        class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white">
                </div>

                <!-- Password Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-900 dark:text-gray-300">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white">
                        <small class="text-gray-500 dark:text-gray-400">At least 8 characters, including letters and numbers</small>
                    </div>
                    <div>
                        <label for="confirm_password"
                            class="block text-sm font-medium text-gray-900 dark:text-gray-300">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="confirm_password" name="confirm_password" required
                            class="w-full px-4 py-2 mt-1 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white">
                    </div>
                </div>

                <!-- Gender Fields -->

                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-900 dark:text-gray-300 mb-2">
                        Gender <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-6">
                        <div class="flex items-center">
                            <input type="radio" id="male" name="gender" value="male"
                                class="w-4 h-4 text-blue-600 bg-gray-50 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="male" class="ml-2 text-sm text-gray-900 dark:text-gray-300">Male</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="female" name="gender" value="female"
                                class="w-4 h-4 text-blue-600 bg-gray-50 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="female" class="ml-2 text-sm text-gray-900 dark:text-gray-300">Female</label>
                        </div>
                    </div>
                </div>


                <!-- Date of birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-900 dark:text-gray-300">
                        Date of birth
                    </label>
                    <input type="date" id="date_of_birth" name="date_of_birth" required
                        class="mt-2 w-full px-4 py-2 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white">
                </div>

                <!-- Terms -->
                <div class="flex items-start mt-4">
                    <input type="checkbox" id="terms" name="terms" required
                        class="w-4 h-4 mt-1 text-blue-600 bg-gray-50 border rounded focus:ring-blue-500 focus:ring-2 dark:bg-gray-800 dark:border-gray-700">
                    <label for="terms" class="ml-3 text-sm text-gray-900 dark:text-gray-300">
                        I agree to the <a href="#" class="text-blue-600 hover:underline">Terms and Conditions</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="w-full px-5 py-3 mt-4 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                        Create Account
                    </button>
                </div>
            </form>

            <p class="mt-6 text-sm text-center text-gray-600 dark:text-gray-400">
                Already have an account? <a href="/index" class="text-blue-600 hover:underline font-medium">Login
                    here</a>
            </p>
        </div>
    </div>
</section>
<script src="https://accounts.google.com/gsi/client" async></script>
<script>
    function callback(response) {
        console.log(response);
    }
</script>