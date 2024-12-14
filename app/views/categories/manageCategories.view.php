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

<section class="min-h-[calc(101.1vh-8rem)] relative overflow-hidden bg-gradient-to-b from-blue-50 via-transparent to-transparent pb-12  sm:pb-16 lg:pb-24 xl:pb-28">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-blue-50"></div>

    <!-- Settings Icon -->
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        <div class="absolute top-2 right-2 sm:top-6 sm:right-6 z-30 flex space-x-4">
            <!-- Manage Products Button -->
            <a href="/categories/addNewCategory" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <!-- Manage Icon -->
                <svg class="w-5 h-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Add New Category
            </a>
        </div>
    <?php endif ?>

    <div class="absolute top-2 left-2 sm:top-6 sm:left-6 z-30 flex space-x-4">
        <!-- Back Button -->
        <a href="/categories" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-700 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            <!-- Back Icon -->
            <svg class="w-5 h-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>

    </div>

    <div class="relative z-20 mx-auto max-w-7xl px-6 lg:px-8">
        <div class="text-center my-10">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-800 sm:text-6xl">
                <span class="text-blue-600">
                    Categories </span> Overview
            </h1>
            <p class="mt-6 text-lg leading-8 text-gray-700">
                Manage and explore your categories with ease.
            </p>
        </div>

        <?php

        use inventory\lib\alertHandler;

        alertHandler::getInstance()->handleAlert();
        ?>

        <!-- Categories Table -->
        <div class="mt-12 overflow-x-auto bg-white rounded-lg shadow-lg">

            <table class="min-w-full border-collapse divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">#</th>
                        <th class="px-6 py-4 text-left font-semibold">Image</th>
                        <th class="px-6 py-4 text-left font-semibold">Name</th>
                        <th class="px-6 py-4 text-left font-semibold">Description</th>
                        <th class="px-6 py-4 text-left font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php
                    if (!empty($categories)) {
                        $index = 1;
                        foreach ($categories as $category) {
                            echo '
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-gray-800">' . $index++ . '</td>
                                <td class="px-6 py-4">
                                    <img src="' . htmlspecialchars($category->getPhotoUrl()) . '" 
                                        alt="' . htmlspecialchars($category->getName()) . '" 
                                        class="w-16 h-16 object-cover rounded-lg">
                                </td>
                                <td class="px-6 py-4 text-gray-800 font-medium">' . htmlspecialchars($category->getName()) . '</td>
                                <td class="px-6 py-4 text-gray-600">' . htmlspecialchars($category->getDescription()) . '</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-4">
                                        <a href="/categories/editCategory/' . $category->getCategoryId() . '" 
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg shadow-sm hover:bg-green-700 focus:outline-none">
                                            Edit
                                        </a>
                                        <form method="POST" action="/categories/delete/' . $category->getCategoryId() . '" onsubmit="return confirm(\'Are you sure you want to delete this category?\');">
                                            <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg shadow-sm hover:bg-red-700 focus:outline-none">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>';
                        }
                    } else {
                        echo '
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No categories found.
                            </td>
                        </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>