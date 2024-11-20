<section class="bg-gradient-to-br from-blue-200 via-white to-blue-100 min-h-screen flex items-center justify-center">
    <div class="absolute top-4 left-4 sm:top-6 sm:left-6 z-30">
        <!-- Back Button -->
        <a href="/categories/manageCategories" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-700 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            <svg class="w-5 h-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <div class="relative z-20 mx-auto w-full max-w-lg bg-white rounded-lg shadow-lg px-8 py-12 dark:border dark:border-gray-700 dark:bg-gray-800">
        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white">Add New Category</h2>
        <form action="/categories/manageCategories/AddNewCategory" method="POST" enctype="multipart/form-data" class="space-y-6 mt-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Category Name</label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 bg-gray-50 border rounded-lg focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Description</label>
                <textarea id="description" name="description" rows="4" required
                    class="w-full px-4 py-2 bg-gray-50 border rounded-lg focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
            </div>
            <!-- Photo -->
            <div>
                <label for="photo_url" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Photo URL</label>
                <input type="text" id="photo_url" name="photo_url" required
                    class="w-full px-4 py-2 bg-gray-50 border rounded-lg focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit"
                    class="w-full px-5 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
                    Add Category
                </button>
            </div>
        </form>
    </div>
</section>