<section class="bg-gradient-to-br from-blue-200 via-white to-blue-100 min-h-screen flex items-center justify-center relative">
    <!-- Back Button -->
    <div class="absolute top-4 left-4 sm:top-6 sm:left-6 z-30">
        <a href="/products?category_id=<?= htmlspecialchars($currentCategoryId) ?>" class=" inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-700 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            <svg class="w-5 h-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <!-- Form Container -->
    <div class="relative z-20 mx-auto w-full max-w-lg bg-white rounded-lg shadow-xl my-16 px-8 py-12 transform transition hover:scale-105 duration-300">
        <!-- Alert Handler -->
        <?php

        use inventory\lib\alertHandler;

        alertHandler::getInstance()->handleAlert();
        ?>

        <h2 class="text-3xl font-bold text-center text-gray-800">Edit Product</h2>
        <p class="text-sm text-center text-gray-600 mt-2">Update the product details below.</p>

        <form action="/products/edit?id=<?= htmlspecialchars($product->getProductID() ?? '') ?>&category_id=<?= htmlspecialchars($currentCategoryId) ?>" method="POST" class="space-y-6 mt-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($product->getName() ?? 'N/A')  ?>" required
                    class="w-full px-4 py-2 mt-1 text-gray-900 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 transition duration-300">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <input type="text" name="description" id="description" value="<?= htmlspecialchars($product->getDescription() ?? 'N/A')  ?>" required
                    class="w-full px-4 py-2 mt-1 text-gray-900 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 transition duration-300">
            </div>

            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="<?= htmlspecialchars($product->getQuantity() ?? '0') ?>" min="0" required
                    class="w-full px-4 py-2 mt-1 text-gray-900 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 transition duration-300">
            </div>

            <div>
                <label for="unit_price" class="block text-sm font-medium text-gray-700">Unit Price</label>
                <input type="number" name="unit_price" id="unit_price" value="<?= htmlspecialchars($product->getUnitPrice() ?? '0.00') ?>" step="0.01" required
                    class="w-full px-4 py-2 mt-1 text-gray-900 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 transition duration-300">
            </div>

            <div>
                <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
                <input type="text" name="sku" id="sku" value="<?= htmlspecialchars($product->getSku() ?? '') ?>" required
                    class="w-full px-4 py-2 mt-1 text-gray-900 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 transition duration-300">
            </div>

            <div>
                <label for="photo_url1" class="block text-sm font-medium text-gray-700">Photo URL 1</label>
                <input type="url" name="photo_url1" id="photo_url1" value="<?= htmlspecialchars($photos[0] ?? '') ?>"
                    class="w-full px-4 py-2 mt-1 text-gray-900 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 transition duration-300">
            </div>

            <div>
                <label for="photo_url2" class="block text-sm font-medium text-gray-700">Photo URL 2</label>
                <input type="url" name="photo_url2" id="photo_url2" value="<?= htmlspecialchars($photos[1] ?? '') ?>"
                    class="w-full px-4 py-2 mt-1 text-gray-900 bg-gray-50 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 transition duration-300">
            </div>


            <div class="text-center">
                <button type="submit"
                    class="w-full px-5 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
                    Update Product
                </button>
            </div>
        </form>

    </div>
</section>