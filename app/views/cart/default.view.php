<section class="min-h-[calc(100vh-8rem)] relative overflow-hidden bg-gradient-to-b from-blue-50 via-transparent to-transparent pb-12 pt-20 sm:pb-16 sm:pt-32 lg:pb-24 xl:pb-32 xl:pt-22"
    x-data="{ showLoading: false }">
    <!-- Enhanced Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-blue-50 opacity-75"></div>

    <div class="relative z-20 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Cart Header -->
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Your Shopping Cart</h1>
            <p class="mt-2 text-gray-600 text-lg">Review your items and proceed to checkout</p>
        </div>

        <!-- Cart Content -->
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Items Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg divide-y divide-gray-200 transition-all duration-300 hover:shadow-xl">
                    <?php if (!empty($cart_items)): ?>
                        <?php foreach ($cart_items as $index => $item): ?>
                            <div class="p-6 flex flex-col sm:flex-row items-center gap-6 hover:bg-gray-50 transition duration-300">
                                <!-- Product Image -->
                                <div class="w-24 h-24 rounded-xl overflow-hidden shadow-md transition-transform duration-300">
                                    <img src="<?= htmlspecialchars($item['photo_url']) ?>"
                                        alt="<?= htmlspecialchars($item['name']) ?>"
                                        class="w-full h-full object-cover">
                                </div>

                                <!-- Product Details -->
                                <div class="flex-1 space-y-3">
                                    <h3 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($item['name']) ?></h3>

                                    <!-- Quantity Controls -->
                                    <!-- Quantity Controls -->
                                    <form action="/cart/updateQuantity" method="POST" class="flex items-center gap-3">
                                        <input type="hidden" name="cart_item_id" value="<?= htmlspecialchars($item['cart_item_id']) ?>">
                                        <input type="hidden" id="quantity-<?= htmlspecialchars($item['cart_item_id']) ?>" name="quantity" value="<?= htmlspecialchars($item['quantity']) ?>" onchange="this.form.submit()">

                                        <!-- Decrease Button -->
                                        <button type="button"
                                            class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors"
                                            onclick="updateQuantity(<?= htmlspecialchars($item['cart_item_id']) ?>, -1)">
                                            −
                                        </button>

                                        <!-- Display Quantity -->
                                        <span id="quantity-display-<?= htmlspecialchars($item['cart_item_id']) ?>" class="text-lg font-semibold">
                                            <?= htmlspecialchars($item['quantity']) ?>
                                        </span>

                                        <!-- Increase Button -->
                                        <button type="button"
                                            class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors"
                                            onclick="updateQuantity(<?= htmlspecialchars($item['cart_item_id']) ?>, 1)">
                                            +
                                        </button>
                                    </form>



                                </div>

                                <!-- Price -->
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-gray-800">
                                        $<?= number_format($item['quantity'] * $item['unit_price'], 2) ?>
                                    </p>

                                    <!-- Remove Button -->
                                    <form action="/cart/removeItem" method="POST" class="mt-3">
                                        <input type="hidden" name="cart_item_id" value="<?= $item['cart_item_id'] ?>">
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 transition-colors flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span>Remove</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Empty Cart State -->
                        <div class="p-12 text-center">
                            <div class="w-24 h-24 mx-auto mb-6 text-gray-400">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <?php if (!isset($_SESSION['user'])): ?>
                                <h3 class="text-2xl font-semibold text-gray-800 mb-3">Sign In to View Your Cart</h3>
                                <p class="text-gray-600 mb-6">Please <a href="/login" class="text-blue-600 hover:text-blue-800 underline">sign in</a> to add items to your cart.</p>
                            <?php else: ?>
                                <h3 class="text-2xl font-semibold text-gray-800 mb-3">Your cart is empty</h3>
                                <p class="text-gray-600 mb-6">Looks like you haven't added any items yet.</p>
                                <a href="/categories" class="inline-block bg-blue-600 text-white py-3 px-8 rounded-lg hover:bg-blue-700 transition-colors duration-300 font-semibold">
                                    Start Shopping
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Summary Section -->
            <?php if (isset($_SESSION['user'])): ?>
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg p-6 sticky top-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Order Summary</h2>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center text-lg">
                                <p class="text-gray-600">Subtotal</p>
                                <p class="text-gray-800 font-semibold">$<?= number_format($subtotal, 2) ?></p>
                            </div>
                            <div class="flex justify-between items-center text-lg">
                                <p class="text-gray-600">Tax (10%)</p>
                                <p class="text-gray-800 font-semibold">$<?= number_format($tax, 2) ?></p>
                            </div>
                            <div class="border-t pt-4 mt-4">
                                <div class="flex justify-between items-center text-xl font-bold">
                                    <p>Total</p>
                                    <p class="text-blue-600">$<?= number_format($total, 2) ?></p>
                                </div>
                            </div>
                            <a href="/categories" class="block text-center text-blue-600 hover:text-blue-700 hover:underline mt-4">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<script>
    function updateQuantity(cartItemId, change) {
        const quantityInput = document.getElementById(`quantity-${cartItemId}`);
        const quantityDisplay = document.getElementById(`quantity-display-${cartItemId}`);
        let currentQuantity = parseInt(quantityInput.value, 10);

        // Ensure the quantity does not go below 1
        currentQuantity = Math.max(1, currentQuantity + change);

        // Update the hidden input and display
        quantityInput.value = currentQuantity;
        quantityDisplay.textContent = currentQuantity;

        // Trigger the form submission
        quantityInput.dispatchEvent(new Event('change'));
    }
</script>