<section class="relative overflow-hidden bg-gradient-to-b from-blue-50 via-transparent to-transparent pb-12 pt-20">
    <!-- Background Animation -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-blue-50 animate-gradient"></div>
    <div class="relative z-20 mx-auto max-w-7xl px-6 lg:px-8">

        <!-- Invoice Details -->
        <div class="mx-auto max-w-4xl mb-8 bg-white rounded-lg shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    Invoice Details
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Invoice ID</p>
                        <p class="font-semibold">
                            <?= htmlspecialchars($_SESSION['order_id'] ?? 'INV-' . uniqid()) ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Full Name</p>
                        <p class="font-semibold">
                            <?= htmlspecialchars($_SESSION['user']['name'] ?? 'N/A') ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-semibold">
                            <?= htmlspecialchars($_SESSION['user']['email'] ?? 'N/A') ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Date & Time</p>
                        <p class="font-semibold"><?= date('F d, Y h:i A') ?></p>
                    </div>

                </div>
            </div>
        </div>

        <!-- Cart Items -->
        <div class="mx-auto max-w-4xl mb-8 bg-white rounded-lg shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    Cart Items
                </h2>
                <div class="divide-y divide-gray-200">
                    <?php foreach ($_SESSION['cart']['items'] ?? [] as $item): ?>
                        <div class="py-4 flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold"><?= htmlspecialchars($item['name']) ?></p>
                                    <p class="text-sm text-gray-600">Quantity: <?= htmlspecialchars($item['quantity']) ?></p>
                                </div>
                            </div>
                            <p class="font-semibold">$<?= number_format($item['quantity'] * $item['price'], 2) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="mx-auto max-w-4xl bg-white rounded-lg shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                        <line x1="1" y1="10" x2="23" y2="10"></line>
                    </svg>
                    Payment Summary
                </h2>
                <div class="space-y-4">
                    <?php
                    $subtotal = array_reduce($_SESSION['cart']['items'] ?? [], function ($carry, $item) {
                        return $carry + ($item['quantity'] * $item['price']);
                    }, 0);
                    $tax = $subtotal * 0.1;
                    $total = $subtotal + $tax;
                    ?>
                    <div class="flex justify-between items-center">
                        <p class="text-gray-600">Subtotal</p>
                        <p class="font-semibold">$<?= number_format($subtotal, 2) ?></p>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-gray-600">Tax (10%)</p>
                        <p class="font-semibold">$<?= number_format($tax, 2) ?></p>
                    </div>
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <p class="text-lg font-bold">Total</p>
                            <p class="text-lg font-bold text-blue-600">$<?= number_format($total, 2) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>