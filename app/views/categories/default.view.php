<section class="relative overflow-hidden bg-gradient-to-b from-blue-50 via-transparent to-transparent
    pb-12 pt-12 sm:pb-16 sm:pt-20 lg:pb-24 xl:pb-28">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-blue-50"></div>

    <!-- Settings Icon -->
    <div class="absolute top-4 right-4 sm:top-6 sm:right-6 z-30 flex space-x-4">
        <!-- Manage Products Button -->
        <a href="/categories/manageCategories"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-700 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            Manage Categories
        </a>



    </div>

    <div class="relative z-20 mx-auto max-w-7xl px-6 lg:px-8">

        <div class="text-center my-10">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-800 sm:text-6xl">
                Browse Categories
            </h1>
            <p class="mt-6 text-lg leading-8 text-gray-700">
                Explore a wide range of categories tailored for your needs.
            </p>
        </div>

        <!-- Categories Grid -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            if (!empty($categories)) {
                foreach ($categories as $category) {
                    echo '
                    <a href="/categories/category/' . $category->getCategoryId() . '" 
                        class="block rounded-2xl border border-gray-100 shadow-lg bg-white p-6 hover:scale-105 hover:bg-gray-100 transition-transform duration-300">
                        <img class="rounded-lg mb-4 w-full h-40 object-cover"
                            src="' . htmlspecialchars($category->getPhotoUrl()) . '" 
                            alt="' . htmlspecialchars($category->getName()) . '">
                        <h3 class="text-lg font-semibold text-gray-800">' . htmlspecialchars($category->getName()) . '</h3>
                        <p class="text-sm text-gray-600">' . htmlspecialchars($category->getDescription()) . '</p>
                    </a>';
                }
            } else {
                echo '<p class="col-span-3 text-center text-gray-500">No categories found.</p>';
            }
            ?>
        </div>
    </div>
</section>