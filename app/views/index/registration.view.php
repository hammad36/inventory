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
        <!-- Form Container -->
        <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg dark:border dark:border-gray-700 sm:max-w-xl xl:p-12 dark:bg-gray-800">
            <div class="p-8 space-y-6">
                <h2 class="text-3xl font-bold leading-tight text-gray-900 dark:text-white text-center">
                    Create Your Account
                </h2>
                <form action="/register" method="POST" class="space-y-6">
                    <!-- Name Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="firstname" class="block text-sm font-medium text-gray-900 dark:text-gray-300">First Name</label>
                            <input type="text" id="firstname" name="firstname" required
                                class="w-full px-4 py-2 bg-gray-50 border rounded-lg focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div>
                            <label for="lastname" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Last Name</label>
                            <input type="text" id="lastname" name="lastname" required
                                class="w-full px-4 py-2 bg-gray-50 border rounded-lg focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Username</label>
                        <input type="text" id="username" name="username" required
                            class="w-full px-4 py-2 bg-gray-50 border rounded-lg focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Email</label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-2 bg-gray-50 border rounded-lg focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>

                    <!-- Password Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Password</label>
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-2 bg-gray-50 border rounded-lg focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" required
                                class="w-full px-4 py-2 bg-gray-50 border rounded-lg focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-center">
                        <input type="checkbox" id="terms" name="terms" required
                            class="w-4 h-4 text-blue-600 bg-gray-50 border rounded focus:ring-blue-500 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500">
                        <label for="terms" class="ml-2 text-sm text-gray-900 dark:text-gray-400">I accept the <a href="#" class="text-blue-600 hover:underline">Terms and Conditions</a></label>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit"
                            class="w-full px-5 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
                            Create Account
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <p class="mt-6 text-sm text-gray-600 dark:text-gray-400 text-center">
                    Already have an account? <a href="/index/login" class="text-blue-600 hover:underline font-medium">Login here</a>
                </p>
            </div>
        </div>
    </div>
</section>