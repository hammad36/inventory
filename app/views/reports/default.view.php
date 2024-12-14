<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Inventory Reports</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Stock Levels Section -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Current Stock Levels</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-3">Category</th>
                            <th class="p-3">Product</th>
                            <th class="p-3">Current Stock</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stockLevels as $item): ?>
                            <tr class="border-b">
                                <td class="p-3"><?= htmlspecialchars($item['category']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($item['product']) ?></td>
                                <td class="p-3"><?= $item['current_stock'] ?></td>
                                <td class="p-3">
                                    <span class="<?= $item['current_stock'] < $item['low_threshold'] ? 'text-red-500' : 'text-green-500' ?>">
                                        <?= $item['current_stock'] < $item['low_threshold'] ? 'Low Stock' : 'Sufficient' ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <canvas id="stockLevelsChart" class="mt-4"></canvas>
        </div>

        <!-- Inventory Value Section -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Inventory Valuation</h2>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-blue-100 p-4 rounded">
                    <p class="text-sm text-gray-600">Total Inventory Value</p>
                    <p class="text-2xl font-bold text-blue-600">$<?= number_format($totalInventoryValue, 2) ?></p>
                </div>
                <div class="bg-green-100 p-4 rounded">
                    <p class="text-sm text-gray-600">Average Product Value</p>
                    <p class="text-2xl font-bold text-green-600">$<?= number_format($averageProductValue, 2) ?></p>
                </div>
            </div>
            <canvas id="inventoryValueChart" class="mt-4"></canvas>
        </div>

        <!-- Stock Adjustment History -->
        <div class="bg-white shadow-md rounded-lg p-6 md:col-span-2">
            <h2 class="text-xl font-semibold mb-4">Stock Adjustment History</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-3">Date</th>
                            <th class="p-3">Product</th>
                            <th class="p-3">Adjustment Type</th>
                            <th class="p-3">Quantity</th>
                            <th class="p-3">User</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stockAdjustments as $adjustment): ?>
                            <tr class="border-b">
                                <td class="p-3"><?= htmlspecialchars($adjustment['timestamp']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($adjustment['product_name']) ?></td>
                                <td class="p-3">
                                    <span class="<?= $adjustment['change_type'] == 'addition' ? 'text-green-500' : 'text-red-500' ?>">
                                        <?= htmlspecialchars(ucfirst($adjustment['change_type'])) ?>
                                    </span>
                                </td>
                                <td class="p-3"><?= $adjustment['quantity_change'] ?></td>
                                <td class="p-3"><?= htmlspecialchars($adjustment['user_name']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Stock Levels Chart
    var stockLevelsCtx = document.getElementById('stockLevelsChart').getContext('2d');
    var stockLevelsChart = new Chart(stockLevelsCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($stockLevels, 'product')) ?>,
            datasets: [{
                label: 'Current Stock Levels',
                data: <?= json_encode(array_column($stockLevels, 'current_stock')) ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Stock Quantity'
                    }
                }
            }
        }
    });

    // Inventory Value Chart
    var inventoryValueCtx = document.getElementById('inventoryValueChart').getContext('2d');
    var inventoryValueChart = new Chart(inventoryValueCtx, {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_column($inventoryValueBreakdown, 'category')) ?>,
            datasets: [{
                data: <?= json_encode(array_column($inventoryValueBreakdown, 'total_value')) ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Inventory Value by Category'
                }
            }
        }
    });
</script>