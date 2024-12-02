<section class="bg-gradient-to-br from-blue-100 via-white to-blue-50 min-h-screen flex items-center justify-center relative">

    <!-- Back Button -->
    <div class="absolute top-4 left-4 sm:top-6 sm:left-8 z-30">
        <a href="/index"
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
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-8">Create Your Account</h2>
            <p class="text-center text-gray-600 dark:text-gray-400 mb-6">
                Join us and start managing your inventory effortlessly!
            </p>

            <!-- Social Media Login -->
            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-6">
                <!-- Google Login -->
                <a href="/auth/google"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm font-medium text-black bg-white hover:bg-white rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-white transition-transform transform hover:scale-105">
                    <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                        <path fill="#EA4335"
                            d="M24 9.5c3.59 0 6.84 1.32 9.35 3.49l7.02-7.03C36.58 2.05 30.69 0 24 0 14.49 0 6.33 5.55 2.77 13.5l8.49 6.59C13.31 14.3 18.32 9.5 24 9.5z" />
                        <path fill="#34A853"
                            d="M46.1 24.5c0-1.77-.18-3.49-.51-5.17H24v9.77h12.45c-1.08 3.68-4.02 6.67-7.65 7.81v6.5h12.38c7.23-6.63 11.37-16.39 11.37-27.41z" />
                        <path fill="#4A90E2"
                            d="M24 48c6.48 0 11.91-2.14 15.87-5.78l-12.38-6.5c-1.56 1.01-3.57 1.6-5.5 1.6-5.68 0-10.69-4.8-11.74-11.21l-8.51 6.58c3.57 7.95 11.73 13.5 21.26 13.5z" />
                        <path fill="#FBBC05"
                            d="M2.77 13.5c-1.45 3.01-2.27 6.39-2.27 9.99s.82 6.98 2.27 9.99l8.49-6.58c-.57-1.72-.89-3.58-.89-5.41s.32-3.69.89-5.41l-8.49-6.58z" />
                    </svg>
                    Continue with Google
                </a>

                <!-- Facebook Login -->
                <a href="/auth/facebook"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition-transform transform hover:scale-105">
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
                    <span class="bg-white dark:bg-gray-900 px-4 text-sm text-gray-500 dark:text-gray-400">Or sign in with your email</span>
                </div>
            </div>

            <form class="space-y-6" action="/login" method="POST">
                <!-- Email Field -->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your Email</label>
                    <input type="email" name="email" id="email" placeholder="you@example.com" required
                        class="w-full px-4 py-2 text-gray-900 bg-gray-50 border rounded-lg focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" required
                        class="w-full px-4 py-2 text-gray-900 bg-gray-50 border rounded-lg focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <!-- Remember Me and Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border rounded focus:ring-blue-500 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500">
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
                    Don’t have an account yet?
                    <a href="/index/registration" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Sign up</a>
                </p>
            </form>
        </div>
    </div>
    </div>
</section>
<script src="https://accounts.google.com/gsi/client" async></script>