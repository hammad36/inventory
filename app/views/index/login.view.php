<section class="bg-gradient-to-br from-blue-200 via-white to-blue-100 min-h-screen flex items-center justify-center relative">

    <!-- Back Button -->
    <div class="absolute top-4 left-4 sm:top-6 sm:left-8 z-30">
        <a href="/index"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-700 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            <!-- Back Icon -->
            <svg class="w-5 h-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <div class="relative z-20 mx-auto px-6 lg:px-8">

        <!-- Form Container with Increased Width -->
        <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg dark:border dark:border-gray-700 sm:max-w-xl xl:p-12 dark:bg-gray-800">
            <div class="p-8 space-y-6">
                <h1 class="text-3xl font-bold leading-tight text-gray-900 dark:text-white text-center">
                    Sign in to Your Account
                </h1>
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