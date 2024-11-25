<section class="relative overflow-hidden bg-gradient-to-b from-blue-50 via-transparent to-transparent pb-12 pt-12 sm:pb-16 sm:pt-20 lg:pb-24 xl:pb-28">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-blue-50"></div>

    <!-- Add Product Button -->
    <div class="absolute top-4 right-4 sm:top-6 sm:right-6 z-30 flex space-x-4">
        <a href="/products/add?category_id=<?= $category ? $category->getCategoryId() : ''; ?>"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none">
            Add Product
        </a>
    </div>

    <!-- Back Button -->
    <div class="absolute top-4 left-4 sm:top-6 sm:left-6 z-30 flex space-x-4">
        <a href="/categories/category?category_id=<?= $category->getCategoryId(); ?>"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-700 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            <svg class="w-5 h-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <div class="relative z-20 mx-auto max-w-7xl px-6 lg:px-8">
        <div class="text-center my-10">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-800 sm:text-6xl">
                Products Overview
            </h1>
            <p class="mt-6 text-lg leading-8 text-gray-700">
                Manage and explore your products with ease.
            </p>
        </div>

        <!-- Alert Handler -->
        <?php

        use inventory\lib\alertHandler;

        alertHandler::getInstance()->handleAlert();
        ?>

        <!-- Products Table -->
        <div class="mt-12 overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="min-w-full border-collapse divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">#</th>
                        <th class="px-6 py-4 text-left font-semibold">Name</th>
                        <th class="px-6 py-4 text-left font-semibold">SKU</th>
                        <th class="px-6 py-4 text-left font-semibold">Description</th>
                        <th class="px-6 py-4 text-left font-semibold">Quantity</th>
                        <th class="px-6 py-4 text-left font-semibold">Unit Price</th>
                        <th class="px-6 py-4 text-left font-semibold">Images</th>
                        <th class="px-6 py-4 text-left font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $index => $product): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-gray-800"><?= htmlspecialchars($index + 1) ?></td>
                                <td class="px-6 py-4 text-gray-800 font-medium"><?= htmlspecialchars($product['name'] ?? 'N/A') ?></td>
                                <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($product['sku'] ?? 'N/A') ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($product['description'] ?? 'N/A') ?></td>
                                <td class="px-6 py-4 text-gray-800"><?= htmlspecialchars($product['quantity'] ?? '0') ?></td>
                                <td class="px-6 py-4 text-gray-800">$<?= number_format($product['unit_price'] ?? 0, 2) ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <img src="<?= htmlspecialchars($product['photo_urls'][0] ?? 'default.jpg') ?>" alt="Image 1" class="w-16 h-16 object-cover rounded-lg">
                                        <img src="<?= htmlspecialchars($product['photo_urls'][1] ?? 'default.jpg') ?>" alt="Image 2" class="w-16 h-16 object-cover rounded-lg">
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-4">
                                        <a href="/products/edit?/<?= htmlspecialchars($product['product_id']) ?>"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg shadow-sm hover:bg-green-700 focus:outline-none">
                                            Edit
                                        </a>
                                        <form method="POST" action="/products/delete/<?= htmlspecialchars($product['product_id']) ?>"
                                            onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg shadow-sm hover:bg-red-700 focus:outline-none">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>