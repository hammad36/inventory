<section class="relative overflow-hidden min-h-[calc(101.1vh-8rem)] bg-gradient-to-b from-blue-50 via-transparent to-transparent pb-12  sm:pb-16 lg:pb-24 xl:pb-28">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-blue-50"></div>

    <div class="absolute top-4 left-4 sm:top-6 sm:left-6 z-30 flex space-x-4">
        <!-- Back Button -->
        <a href="/categories" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-700 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            <!-- Back Icon -->
            <svg class="w-5 h-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        <div class="absolute top-2 right-2 sm:top-6 sm:right-6 z-30 flex space-x-4">
            <!-- Manage Products Button -->
            <a href="/products?category_id=<?php echo $category->getCategoryId(); ?>"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-700 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Manage Products
            </a>
        </div>
    <?php endif; ?>


    <div class="relative z-20 mx-auto max-w-7xl px-6 lg:px-8">
        <div class="text-center my-10">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-800 sm:text-6xl">
                <?php echo htmlspecialchars($category->getName()); ?> Products
            </h1>
            <p class="mt-6 text-lg leading-8 text-gray-700">
                Explore products under the "<?php echo htmlspecialchars($category->getName()); ?>" category.
            </p>
        </div>


        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            if (!empty($products)) {
                foreach ($products as $product) {
                    // Split the photo URLs into an array
                    $photoUrls = explode(',', $product['photo_urls']);

                    echo '
            <div class="relative block rounded-2xl border border-gray-200 shadow-lg bg-white p-6 hover:shadow-xl hover:scale-105 transition-transform duration-300 h-[600px]">
                <div class="relative group h-full flex flex-col">
                    <div class="relative overflow-hidden rounded-lg h-[300px]">
                        <img class="rounded-lg w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-0"
                            src="' . htmlspecialchars($photoUrls[0]) . '"
                            alt="' . htmlspecialchars($product['name']) . '">
                        
                        <div class="absolute inset-0 grid grid-cols-1 gap-1 transition-opacity duration-300 opacity-0 group-hover:opacity-100">';
                    foreach (array_slice($photoUrls, 1) as $url) {
                        echo '<img class="rounded-lg w-full h-full object-cover"
                                src="' . htmlspecialchars($url) . '" alt="' . htmlspecialchars($product['name']) . '">';
                    }
                    echo '</div>
                    </div>
                    <div class="mt-4 flex-1">
                        <h3 class="text-lg font-semibold text-gray-800">' . htmlspecialchars($product['name']) . '</h3>
                        <p class="text-sm text-gray-600 mt-2 line-clamp-3">' . htmlspecialchars($product['description']) . '</p>
                    </div>
                    <div class="mt-4">
                        <span class="block text-sm font-medium text-gray-700">Price: $' . number_format($product['unit_price'], 2) . '</span>
                        <span class="block text-sm font-medium text-green-600">Quantity: ' . htmlspecialchars($product['quantity']) . '</span>
                    </div>
                    <form action="/adjust-stock" method="POST" class="mt-4">
                        <input type="hidden" name="product_id" value="' . htmlspecialchars($product['product_id']) . '">
                        <div class="flex items-center space-x-4">
                            <!-- Add Option -->
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="adjustment_type" value="addition" required class="form-radio text-blue-600 peer">
                                <span class="ml-2 text-gray-600 peer-checked:text-blue-600 peer-checked:font-medium">Add</span>
                            </label>
                            <!-- Reduce Option -->
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="adjustment_type" value="reduction" required class="form-radio text-red-600 peer">
                                <span class="ml-2 text-gray-600 peer-checked:text-red-600 peer-checked:font-medium">Reduce</span>
                            </label>
                        </div>
                        <div class="mt-3">
                            <input type="number" name="quantity" placeholder="Enter quantity" required
                                class="w-full border border-gray-300 rounded-lg p-2 text-sm shadow-sm ">
                        </div>
                        <button type="submit" 
                            class="mt-4 inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Submit
                        </button>
                    </form>
                </div>
            </div>';
                }
            } else {
                echo '<p class="col-span-3 text-center text-gray-500">No products found in this category.</p>';
            }
            ?>
        </div>



    </div>
</section>