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
                Review your stock adjustments efficiently.
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
                        <th class="px-6 py-4 text-left font-semibold">Product Name</th>
                        <th class="px-6 py-4 text-left font-semibold">Change Type</th>
                        <th class="px-6 py-4 text-left font-semibold">Quantity Change</th>
                        <th class="px-6 py-4 text-left font-semibold">User ID</th>
                        <th class="px-6 py-4 text-left font-semibold">User Name</th>
                        <th class="px-6 py-4 text-left font-semibold">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (!empty($stockAdjustments)): ?>
                        <?php foreach ($stockAdjustments as $index => $adjustment): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-gray-800 font-medium"><?= htmlspecialchars($index + 1) ?></td>
                                <td class="px-6 py-4 text-gray-800 font-medium"><?= htmlspecialchars($adjustment->getProductId()) ?></td>
                                <td class="px-6 py-4 text-gray-800 font-medium"><?= htmlspecialchars($adjustment->getProductName()) ?></td>
                                <td class="px-6 py-4 font-medium 
                                    <?php if ($adjustment->getChangeType() === 'addition'): ?>
                                        text-green-800 font-light
                                    <?php elseif ($adjustment->getChangeType() === 'reduction'): ?>
                                        text-red-600 font-light
                                    <?php else: ?>
                                        text-blue-800 font-extrabold bg-blue-50
                                    <?php endif; ?>">
                                    <?= htmlspecialchars($adjustment->getChangeType() ?? 'N/A') ?>
                                </td>
                                <td class="px-6 py-4 text-gray-800 font-medium"><?= htmlspecialchars($adjustment->getQuantityChange() ?? '0') ?></td>
                                <td class="px-6 py-4 text-gray-800 font-medium"><?= htmlspecialchars($adjustment->getUserId() ?? 'N/A') ?></td>
                                <td class="px-6 py-4 text-gray-800 font-medium"><?= htmlspecialchars($adjustment->getUserName() ?? 'N/A') ?></td>
                                <td class="px-6 py-4 text-gray-800 font-medium"><?= htmlspecialchars($adjustment->getTimestamp() ?? 'N/A') ?></td>
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