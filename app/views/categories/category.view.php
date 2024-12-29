<?php
if (!isset($_SESSION['user'])): ?>
    <div class="relative z-20 mx-auto max-w-7xl py-40 px-6 lg:px-8">
        <div class="text-center my-10">
            <p class="mt-4 text-xl text-gray-600">
                Please <a href="/index" class="text-blue-600 hover:text-blue-800">sign in</a> to access this page
            </p>
        </div>
    </div>
<?php
    exit;
endif
?>
<section class="relative overflow-hidden min-h-[calc(101.1vh-8rem)] bg-gradient-to-b from-blue-50 via-transparent to-transparent pb-12 sm:pb-16 lg:pb-24 xl:pb-28">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-blue-50"></div>

    <!-- Back Button -->
    <div class="absolute top-4 left-4 sm:top-6 sm:left-6 z-30 flex space-x-4">
        <a href="/categories" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-700 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            <svg class="w-5 h-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        <!-- Manage Products Button -->
        <div class="absolute top-2 right-2 sm:top-6 sm:right-6 z-30 flex space-x-4">
            <a href="/products?category_id=<?php echo htmlspecialchars($category->getCategoryId()); ?>"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-700 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Manage Products
            </a>
        </div>
    <?php endif; ?>

    <div class="relative z-20 mt-20 mx-auto max-w-7xl px-6 lg:px-8">
        <div class="text-center my-10">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-800 sm:text-6xl">
                <span class="text-blue-600"><?php echo htmlspecialchars($category->getName()); ?></span> Products
            </h1>
            <p class="mt-6 text-lg leading-8 text-gray-700">
                Explore products under the "<?php echo htmlspecialchars($category->getName()); ?>" category.
            </p>
        </div>

        <?php

        use inventory\lib\alertHandler;

        $alertHandler = alertHandler::getInstance();
        $alertHandler->handleAlert();
        ?>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product):
                    $photoUrls = explode(',', $product['photo_urls']); ?>
                    <div class="relative block rounded-3xl border border-gray-100 shadow-md bg-white overflow-hidden transition-all duration-300 hover:shadow-2xl hover:scale-102 group h-[650px]">
                        <!-- Badge for stock status -->
                        <div class="absolute top-4 right-4 z-10">
                            <?php if ($product['quantity'] > 10): ?>
                                <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full">In Stock</span>
                            <?php elseif ($product['quantity'] > 0): ?>
                                <span class="px-3 py-1 text-sm font-medium bg-yellow-100 text-yellow-800 rounded-full">Low Stock</span>
                            <?php else: ?>
                                <span class="px-3 py-1 text-sm font-medium bg-red-100 text-red-800 rounded-full">Out of Stock</span>
                            <?php endif; ?>
                        </div>

                        <!-- Image Gallery with Hover Effect -->
                        <div class="relative overflow-hidden h-[320px]">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent z-10"></div>
                            <img class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110"
                                src="<?php echo htmlspecialchars($photoUrls[0]); ?>"
                                alt="<?php echo htmlspecialchars($product['product_name']); ?>">

                            <?php if (count($photoUrls) > 1): ?>
                                <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-20">
                                    <?php foreach ($photoUrls as $index => $url): ?>
                                        <button class="w-2 h-2 rounded-full bg-white/50 hover:bg-white transition-colors duration-200"></button>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="p-6">
                            <!-- Product Details -->
                            <div class="mb-4">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors duration-200">
                                    <?php echo htmlspecialchars($product['product_name']); ?>
                                </h3>
                                <p class="text-sm leading-relaxed text-gray-600 line-clamp-2">
                                    <?php echo htmlspecialchars($product['description']); ?>
                                </p>
                            </div>

                            <!-- Price and Stock Info -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex flex-col">
                                    <span class="text-2xl font-bold text-gray-900">
                                        <?php echo number_format($product['unit_price'], 2); ?> EGP
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        <?php echo htmlspecialchars($product['quantity']); ?> units available
                                    </span>
                                </div>
                            </div>

                            <!-- Admin Controls -->
                            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                                <form action="/categories/category/<?php echo htmlspecialchars($category->getCategoryId()); ?>" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                                    <div class="flex items-center gap-4 mb-4">
                                        <label class="flex items-center cursor-pointer bg-blue-50 rounded-lg px-4 py-2 flex-1 transition-colors duration-200 hover:bg-blue-100">
                                            <input type="radio" name="adjustment_type" value="addition" required class="form-radio text-blue-600">
                                            <span class="ml-2 text-blue-700 font-medium">Add</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer bg-red-50 rounded-lg px-4 py-2 flex-1 transition-colors duration-200 hover:bg-red-100">
                                            <input type="radio" name="adjustment_type" value="reduction" required class="form-radio text-red-600">
                                            <span class="ml-2 text-red-700 font-medium">Reduce</span>
                                        </label>
                                    </div>
                                    <div class="relative">
                                        <input type="number"
                                            name="quantity"
                                            placeholder="Enter quantity"
                                            required
                                            class="w-full border border-gray-200 rounded-lg p-3 text-sm shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow duration-200">
                                    </div>
                                    <button type="submit"
                                        class="mt-4 w-full inline-flex items-center justify-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                                        Update Stock
                                    </button>
                                </form>

                                <!-- Client Controls -->
                            <?php elseif ($_SESSION['user']['role'] === 'user'): ?>
                                <form action="/basket/add" method="POST" class="space-y-4">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                                    <div class="relative">
                                        <input type="number"
                                            name="quantity"
                                            min="1"
                                            max="<?php echo htmlspecialchars($product['quantity']); ?>"
                                            placeholder="Quantity"
                                            required
                                            class="w-full border border-gray-200 rounded-lg p-3 pl-12 text-sm shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow duration-200">
                                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-sm hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 group">
                                        <span>Add to Basket</span>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 transform group-hover:translate-x-1 transition-transform duration-200"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="col-span-3 text-center text-lg text-gray-500 py-12">No products found in this category.</p>
            <?php endif; ?>
        </div>
    </div>
</section>