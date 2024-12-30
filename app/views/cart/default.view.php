<section class="min-h-[calc(101.1vh-8rem)] relative overflow-hidden  bg-gradient-to-b from-blue-50 via-transparent to-transparent pb-12 pt-20 sm:pb-16 sm:pt-32 lg:pb-24 xl:pb-32 xl:pt-22">
    <!-- Page Container -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-blue-50 animate-gradient"></div>
    <div class="relative z-20 mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Cart Header -->
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Your Shopping Cart</h1>
            <p class="mt-2 text-gray-600">Review your items and proceed to checkout.</p>
        </div>

        <!-- Cart Content -->
        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Items Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md divide-y divide-gray-200">
                    <!-- Cart Items -->
                    <?php if (!empty($cartItems)): ?>
                        <?php foreach ($cartItems as $item): ?>
                            <div class="flex items-center justify-between px-6 py-4">
                                <img src="<?= htmlspecialchars($item['photo_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-16 h-16">
                                <div>
                                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                                    <p>Quantity: <?= htmlspecialchars($item['quantity']) ?></p>
                                </div>
                                <p>$<?= number_format($item['quantity'] * $item['unit_price'], 2) ?></p>
                            </div>
                        <?php endforeach; ?>

                    <?php elseif (!isset($_SESSION['user']['role'])): ?>

                        <!-- Empty Cart State -->
                        <div class="relative z-20 mx-auto max-w-7xl py-28 px-6 lg:px-8">
                            <div class="text-center my-10">
                                <p class="mt-4 text-xl text-gray-600">
                                    Please <a href="/index" class="text-blue-600 hover:text-blue-800">sign in</a> as a client to select cart items.
                                </p>
                            </div>
                        </div>
                    <?php else: ?>

                        <!-- Empty Cart State -->
                        <div
                            x-show="items.length === 0"
                            class="bg-white rounded-xl shadow-lg p-12 text-center transition duration-300 ease-in">
                            <svg class="w-20 h-20 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <h3 class="mt-4 text-xl font-semibold text-gray-800">Your cart is empty</h3>
                            <p class="mt-2 text-gray-600">Looks like you haven't added any items yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Summary Section -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h2>
                    <div class="space-y-4">
                        <?php
                        $subtotal = array_reduce($_SESSION['cart']['items'] ?? [], function ($carry, $item) {
                            return $carry + ($item['quantity'] * $item['price']);
                        }, 0);
                        $tax = $subtotal * 0.1;
                        $total = $subtotal + $tax;
                        ?>
                        <!-- Subtotal -->
                        <div class="flex justify-between items-center">
                            <p class="text-gray-600">Subtotal</p>
                            <p class="text-gray-800 font-semibold">$<?= number_format($subtotal, 2) ?></p>
                        </div>
                        <!-- Tax -->
                        <div class="flex justify-between items-center">
                            <p class="text-gray-600">Tax (10%)</p>
                            <p class="text-gray-800 font-semibold">$<?= number_format($tax, 2) ?></p>
                        </div>
                        <!-- Total -->
                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center text-lg font-bold">
                                <p>Total</p>
                                <p class="text-blue-600">$<?= number_format($total, 2) ?></p>
                            </div>
                        </div>
                        <!-- Checkout Button -->
                        <a href="/cart/checkout" class="w-full bg-blue-600 text-white py-3 mt-6 rounded-lg hover:bg-blue-700 transition font-semibold text-center block">
                            Proceed to Checkout
                        </a>

                        <!-- Continue Shopping -->
                        <a href="/categories" class="block text-center text-blue-600 hover:underline mt-4">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>