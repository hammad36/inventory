<section class="min-h-[calc(100vh-8rem)] relative overflow-hidden bg-gradient-to-b from-blue-50 via-transparent to-transparent pb-12 pt-20 sm:pb-16 sm:pt-32 lg:pb-24 xl:pb-32 xl:pt-22">
    <!-- Enhanced Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-blue-50 opacity-75"></div>

    <div class="relative z-20 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Checkout Header -->
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Complete Your Order</h1>
            <p class="mt-2 text-gray-600 text-lg">Please review your order and provide shipping details</p>
        </div>

        <!-- Checkout Content -->
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Shipping Information Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-6 space-y-6">
                    <!-- Personal Information -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Personal Information</h2>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-sm text-gray-600">Name</p>
                                <p class="text-lg font-semibold"><?= htmlspecialchars($_SESSION['user']['name']) ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="text-lg font-semibold"><?= htmlspecialchars($_SESSION['user']['email']) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address Form -->
                    <form action="/cart/saveAddress" method="POST" class="space-y-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Shipping Address</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Street Address -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Street Address</label>
                                <input type="text" name="street" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- City -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" name="city" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- State/Province Dropdown -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">State/Province</label>
                                <select name="state" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="Cairo">Cairo</option>
                                    <option value="Alexandria">Alexandria</option>
                                    <option value="Giza">Giza</option>
                                    <option value="Dakahlia">Dakahlia</option>
                                    <option value="Red Sea">Red Sea</option>
                                    <option value="Beheira">Beheira</option>
                                    <option value="Fayoum">Fayoum</option>
                                    <option value="Gharbia">Gharbia</option>
                                    <option value="Ismailia">Ismailia</option>
                                    <option value="Menofia">Menofia</option>
                                    <option value="Minya">Minya</option>
                                    <option value="Qaliubiya">Qaliubiya</option>
                                    <option value="New Valley">New Valley</option>
                                    <option value="Suez">Suez</option>
                                    <option value="Aswan">Aswan</option>
                                    <option value="Assiut">Assiut</option>
                                    <option value="Beni Suef">Beni Suef</option>
                                    <option value="Port Said">Port Said</option>
                                    <option value="Damietta">Damietta</option>
                                    <option value="Sharkia">Sharkia</option>
                                    <option value="South Sinai">South Sinai</option>
                                    <option value="Kafr El Sheikh">Kafr El Sheikh</option>
                                    <option value="Matruh">Matruh</option>
                                    <option value="Luxor">Luxor</option>
                                    <option value="Qena">Qena</option>
                                    <option value="North Sinai">North Sinai</option>
                                    <option value="Sohag">Sohag</option>
                                </select>
                            </div>

                        </div>

                        <!-- Special Instructions -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Delivery Instructions (Optional)</label>
                            <textarea name="instructions" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Order Summary</h2>
                    <!-- Order Items -->
                    <div class="space-y-4 mb-6">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="flex justify-between items-center text-sm">
                                <div>
                                    <p class="font-medium"><?= htmlspecialchars($item['name']) ?></p>
                                    <p class="text-gray-600">Qty: <?= htmlspecialchars($item['quantity']) ?></p>
                                </div>
                                <p class="font-semibold">$<?= number_format($item['quantity'] * $item['unit_price'], 2) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Cost Breakdown -->
                    <div class="space-y-4 border-t pt-4">
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
                        <form action="/cart/processPayment" method="POST">
                            <!-- Payment Method Selection -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                <select name="payment_method" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="4924047">Online Card</option>
                                    <option value="4929903">Mobile Wallet</option>
                                    <option value="4929849">Cash Collection</option>
                                </select>
                            </div>

                            <!-- Pay Now Button -->
                            <button type="submit"
                                class="w-full bg-blue-600 text-white py-4 px-8 rounded-lg hover:bg-blue-700 transition-colors duration-300 font-semibold mt-6 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Pay Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>