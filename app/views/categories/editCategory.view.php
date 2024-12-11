<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin'): ?>
    <div class="relative z-20 mx-auto max-w-7xl py-40 px-6 lg:px-8">
        <div class="text-center my-10">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-800 sm:text-6xl"> Restricted to Administrators </h1>
        </div>
    </div>
<?php
    exit;
endif
?>
<section class="min-h-[calc(101.1vh-8rem)] bg-gradient-to-br from-blue-200 via-white to-blue-100 min-h-screen flex items-center justify-center relative">
    <!-- Back Button -->
    <div class="absolute top-4 left-4 sm:top-6 sm:left-6 z-30">
        <a href="/categories/manageCategories"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-700 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            <svg class="w-5 h-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <!-- Form Container -->
    <div class="relative z-20 mx-auto w-full max-w-lg bg-white rounded-lg shadow-xl px-8 py-12 transform transition hover:scale-105 duration-300">

        <?php

        use inventory\lib\alertHandler;

        // Display alert messages if any
        alertHandler::getInstance()->handleAlert();
        ?>


        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-gray-900">Edit Category</h2>
        <p class="text-sm text-center text-gray-600 mt-2">
            Modify the fields below to update the category details.
        </p>
        <form action="/categories/editCategory/<?php echo $category->getCategoryId(); ?>" method="POST" enctype="multipart/form-data" class="space-y-6 mt-6">
            <!-- Category Name -->
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($category->getName()); ?>" required
                    class="w-full px-4 py-2 mt-1 text-gray-900 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 transition duration-300">
            </div>
            <!-- Description -->
            <div>
                <label for="description" class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="3" required
                    class="w-full px-4 py-2 mt-1 text-gray-900 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 transition duration-300"><?php echo htmlspecialchars($category->getDescription()); ?></textarea>
            </div>
            <!-- Photo URL -->
            <div>
                <label for="photo_url" class="block mb-2 text-sm font-medium text-gray-700">Photo URL</label>
                <input type="text" id="photo_url" name="photo_url" value="<?php echo htmlspecialchars($category->getPhotoUrl()); ?>" required
                    class="w-full px-4 py-2 mt-1 text-gray-900 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 transition duration-300">
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit"
                    class="w-full px-5 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</section>