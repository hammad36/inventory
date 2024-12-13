<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin'): ?>
    <div class="relative z-20 mx-auto max-w-7xl py-40 px-6 lg:px-8">
        <div class="text-center my-10">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-800 sm:text-6xl"> Restricted to Administrators </h1>
        </div>
    </div>
<?php
    exit;
endif
?>
<section class="min-h-[calc(101.1vh-8rem)] relative overflow-hidden bg-gradient-to-b from-blue-50 via-transparent to-transparent pb-12  sm:pb-16  lg:pb-24 xl:pb-28">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-blue-50"></div>

    <div class="relative z-20 mx-auto max-w-7xl px-6 lg:px-8">
        <div class="text-center my-10">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-800 sm:text-6xl">
                <span class="text-blue-600">Stock Adjustments </span>Overview
            </h1>
            <p class="mt-6 text-lg leading-8 text-gray-700">
                Review and manage your stock adjustments efficiently.
            </p>
        </div>

        <!-- Alert Handler -->
        <?php

        use inventory\lib\alertHandler;

        $alertHandler = alertHandler::getInstance();
        $alertHandler->handleAlert();
        ?>

        <!-- Adjustments Table -->
        <div class="mt-12 overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="min-w-full border-collapse divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">#</th>
                        <th class="px-6 py-4 text-left font-semibold">Product ID</th>
                        <th class="px-6 py-4 text-left font-semibold">Change Type</th>
                        <th class="px-6 py-4 text-left font-semibold">Quantity Change</th>
                        <th class="px-6 py-4 text-left font-semibold">User ID</th>
                        <th class="px-6 py-4 text-left font-semibold">Timestamp</th>
                        <th class="px-6 py-4 text-left font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (!empty($stockAdjustments)): ?>
                        <?php foreach ($stockAdjustments as $index => $adjustment): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-gray-800"><?= htmlspecialchars($index + 1) ?></td>
                                <td class="px-6 py-4 text-gray-800 font-medium"><?= htmlspecialchars($adjustment['product_id'] ?? 'N/A') ?></td>
                                <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($adjustment['change_type'] ?? 'N/A') ?></td>
                                <td class="px-6 py-4 text-gray-800"><?= htmlspecialchars($adjustment['quantity_change'] ?? '0') ?></td>
                                <td class="px-6 py-4 text-gray-800"><?= htmlspecialchars($adjustment['user_id'] ?? 'N/A') ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($adjustment['timestamp'] ?? 'N/A') ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-4">
                                        <a href="/stockAdjustments/edit?id=<?= htmlspecialchars($adjustment['adjustment_id']) ?>"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg shadow-sm hover:bg-green-700 focus:outline-none">
                                            Edit
                                        </a>

                                        <form method="POST" action="/stockAdjustments/delete?id=<?= htmlspecialchars($adjustment['adjustment_id']) ?>"
                                            onsubmit="return confirm('Are you sure you want to delete this adjustment?');">
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
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No stock adjustments found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>