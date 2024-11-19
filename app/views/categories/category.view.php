<section class="relative overflow-hidden bg-gradient-to-b from-blue-50 via-transparent to-transparent pb-12 pt-20 sm:pb-16 sm:pt-32 lg:pb-24 xl:pb-32 xl:pt-40">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-blue-50"></div>

    <div class="relative z-20 mx-auto max-w-7xl px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-800 sm:text-6xl">
                <?php echo htmlspecialchars($category->getName()); ?> Products
            </h1>
            <p class="mt-6 text-lg leading-8 text-gray-700">
                Explore products under the "<?php echo htmlspecialchars($category->getName()); ?>" category.
            </p>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            if (!empty($products)) {
                foreach ($products as $product) {
                    // Split the photo URLs into an array
                    $photoUrls = explode(',', $product['photo_urls']);

                    echo '
                    <div class="relative block rounded-2xl border border-gray-100 shadow-lg bg-white p-6 hover:bg-gray-100 transition-transform duration-300 h-[500px]">
                        <div class="relative group h-full">
                            <div class="relative overflow-hidden rounded-lg">
                                <img class="rounded-lg w-full h-[300px] object-cover transition-opacity duration-300 group-hover:opacity-0"
                                    src="' . htmlspecialchars($photoUrls[0]) . '"
                                    alt="' . htmlspecialchars($product['name']) . '">
                                
                                <div class="absolute inset-0 grid grid-cols-1 gap-1 transition-opacity duration-300 opacity-0 group-hover:opacity-100">';
                    foreach (array_slice($photoUrls, 1) as $url) {
                        echo '<img class="rounded-lg w-full h-[300px] object-cover"
                                        src="' . htmlspecialchars($url) . '" alt="' . htmlspecialchars($product['name']) . '">';
                    }
                    echo '</div>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 mt-4">' . htmlspecialchars($product['name']) . '</h3>
                            <p class="text-sm text-gray-600 mt-2">' . htmlspecialchars($product['description']) . '</p>
                            <span class="text-sm font-medium text-gray-700 mt-2">$' . number_format($product['unit_price'], 2) . '</span>
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