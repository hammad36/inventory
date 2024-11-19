<section class="relative overflow-hidden bg-gradient-to-b from-blue-50 via-transparent to-transparent pb-12 pt-20 sm:pb-16 sm:pt-32 lg:pb-24 xl:pb-32 xl:pt-40">
    <!-- Background -->
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

        <!-- Products Grid -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (!empty($products)) : ?>
                <?php foreach ($products as $product): ?>
                    <a href="/products/<?php echo htmlspecialchars($product['product_id']); ?>"
                        class="block rounded-2xl border border-gray-100 shadow-lg bg-white p-6 hover:scale-105 hover:bg-gray-100 transition-transform duration-300">
                        <img class="rounded-lg mb-4 w-full  object-cover"
                            src="<?php echo htmlspecialchars($product['photo_url'] ?? 'default.jpg'); ?>"
                            alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </h3>
                        <p class="text-sm text-gray-600">
                            <?php echo htmlspecialchars($product['description']); ?>
                        </p>
                        <span class="text-sm font-medium text-gray-700">
                            $<?php echo number_format($product['unit_price'], 2); ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="col-span-3 text-center text-gray-500">No products found in this category.</p>
            <?php endif; ?>
        </div>


    </div>
</section>