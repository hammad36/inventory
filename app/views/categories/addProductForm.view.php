<div class="min-h-[calc(101.1vh-8rem)] max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Product</h2>
    <form method="POST" action="/categories/addProduct" enctype="multipart/form-data">
        <!-- Product Name -->
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
            <input
                type="text"
                id="name"
                name="name"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Enter product name"
                required />
        </div>

        <!-- Product Description -->
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea
                id="description"
                name="description"
                rows="4"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Enter product description"
                required></textarea>
        </div>

        <!-- Price -->
        <div class="mb-6">
            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Unit Price</label>
            <input
                type="number"
                id="price"
                name="price"
                step="0.01"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Enter product price"
                required />
        </div>

        <!-- Quantity -->
        <div class="mb-6">
            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
            <input
                type="number"
                id="quantity"
                name="quantity"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Enter quantity"
                required />
        </div>

        <!-- Product Photos -->
        <div class="mb-6">
            <label for="photos" class="block text-sm font-medium text-gray-700 mb-2">Upload Photos</label>
            <input
                type="file"
                id="photos"
                name="photos[]"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                multiple />
            <p class="mt-2 text-sm text-gray-500">You can upload multiple photos (optional).</p>
        </div>

        <!-- Category -->
        <div class="mb-6">
            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
            <select
                id="category"
                name="category"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category->getCategoryId()); ?>">
                        <?php echo htmlspecialchars($category->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button
                type="submit"
                class="w-full sm:w-auto px-6 py-2 text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                Add Product
            </button>
        </div>
    </form>
</div>