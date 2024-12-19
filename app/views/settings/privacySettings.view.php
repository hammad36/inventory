<main class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="bg-gradient-to-br from-blue-600 to-blue-800 shadow-2xl rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white p-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Privacy Settings</h1>
                <p class="text-blue-100">Your privacy is our priority</p>
            </div>
            <a href="/settings" class="text-white hover:text-blue-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>

        <!-- Content -->
        <section class="bg-white p-8 space-y-8">
            <!-- Data Protection -->
            <article class="group hover:scale-[1.02] transition-transform duration-300">
                <div class="p-6 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl shadow-sm">
                    <div class="flex items-center space-x-4 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-xl font-semibold text-gray-800">Data Protection</h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        We prioritize the security of your personal information. Your data is encrypted and stored securely,
                        and we never share it with third parties without your explicit consent.
                    </p>
                </div>
            </article>

            <!-- Activity Privacy -->
            <article class="group hover:scale-[1.02] transition-transform duration-300">
                <div class="p-6 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl shadow-sm">
                    <div class="flex items-center space-x-4 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m2-4h.01M12 1c6.627 0 12 5.373 12 12s-5.373 12-12 12S0 19.627 0 12 5.373 1 12 1z" />
                        </svg>
                        <h2 class="text-xl font-semibold text-gray-800">Activity Privacy</h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Your activity on our platform is private by default. We maintain minimal necessary logs
                        to ensure service quality and security.
                    </p>
                </div>
            </article>
            <!-- Account Deletion -->
            <article class="group hover:scale-[1.02] transition-transform duration-300">
                <div class="p-6 bg-gradient-to-r from-red-50 to-red-100 rounded-xl shadow-sm">
                    <div class="flex items-center space-x-4 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m2 6H7a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2z" />
                        </svg>
                        <h2 class="text-xl font-semibold text-red-700">Delete Account</h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Permanently delete your account and all associated data. This action cannot be undone.
                    </p>
                    <button
                        onclick="showModal()"
                        class="bg-red-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-red-700 transition-colors duration-300 font-medium">
                        Delete My Account
                    </button>
                </div>
            </article>
        </section>

        <!-- Modal -->
        <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden" aria-hidden="true" role="dialog">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Are you sure?</h2>
                <p class="text-gray-600 mb-6">
                    This action will permanently delete your account and cannot be undone. Do you wish to proceed?
                </p>
                <form method="POST" action="/settings/privacySettings">
                    <input type="hidden" name="delete_account" value="1">
                    <!-- Optional CSRF Token -->
                    <!-- <input type="hidden" name="csrf_token" value="your_csrf_token_here"> -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="hideModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    const showModal = () => document.getElementById('deleteModal').classList.remove('hidden');
    const hideModal = () => document.getElementById('deleteModal').classList.add('hidden');
</script>