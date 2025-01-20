<section class="min-h-[calc(101.1vh-8rem)] relative overflow-hidden bg-gradient-to-b from-blue-50 via-transparent to-transparent ">
    <?php
    // Check if the user is logged in and is an admin
    if (!isset($_SESSION['user'])) {
        // Redirect or show a message for non-logged-in users
        echo '
        <div class="relative z-20 mx-auto max-w-7xl py-40 px-6 lg:px-8">
            <div class="text-center my-10">
                <p class="mt-4 text-xl text-gray-600">
                    Please <a href="/index" class="text-blue-600 hover:text-blue-800">sign in</a> to access this page.
                </p>
            </div>
        </div>';
        return; // Stop further execution
    }

    if ($_SESSION['user']['role'] !== 'admin') {
        // Show a message for non-admin users
        echo '
        <div class="relative z-20 mx-auto max-w-7xl py-40 px-6 lg:px-8">
            <div class="text-center my-10">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-800 sm:text-6xl">Restricted to Administrators</h1>
            </div>
        </div>';
        return; // Stop further execution
    }
    ?>

    <!-- Background Gradient -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-blue-50"></div>

    <!-- Main Content -->
    <div class="relative z-20 mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Page Heading -->
        <div class="text-center my-10">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-800 sm:text-6xl">
                <span class="text-blue-600">Inventory</span> Reports
            </h1>
        </div>
        <!-- Filters Section -->
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <button
                class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 shadow-lg transition-all duration-300 transform hover:-translate-y-1"
                onclick="generateReport('daily')">
                Daily Report
            </button>
            <button
                class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 shadow-lg transition-all duration-300 transform hover:-translate-y-1"
                onclick="generateReport('weekly')">
                Weekly Report
            </button>
            <button
                class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 shadow-lg transition-all duration-300 transform hover:-translate-y-1"
                onclick="generateReport('monthly')">
                Monthly Report
            </button>
            <button
                class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 shadow-lg transition-all duration-300 transform hover:-translate-y-1"
                onclick="generateReport('yearly')">
                Yearly Report
            </button>
        </div>


        <!-- Report Section -->
        <div class="bg-white shadow-lg rounded-xl p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Generated Report</h2>
            <div id="report-meta" class="text-gray-600 mb-6 text-center">
                <p>Report Type: <span id="report-type" class="font-medium text-blue-600">None</span></p>
                <p>Date Generated: <span id="report-date" class="font-medium text-blue-600">-</span></p>
            </div>
            <div id="report-content" class="overflow-x-auto">
                <p class="text-gray-500 text-center">Select a date or range to generate the report.</p>
            </div>
            <div class="flex justify-center space-x-4 mt-8">
                <button
                    id="print-button"
                    class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 shadow-lg transition-all duration-300 transform hover:-translate-y-1 hidden"
                    onclick="printReport()">
                    Print Report
                </button>
                <button
                    id="export-button"
                    class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 shadow-lg transition-all duration-300 transform hover:-translate-y-1 hidden"
                    onclick="exportToCSV()">
                    Export CSV
                </button>
            </div>
        </div>
    </div>
</section>

<script>
    async function fetchReportData(type) {
        try {
            const response = await fetch(`/reports/filter?type=${type}`);
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
            }
            return await response.json();
        } catch (error) {
            console.error('Error fetching report:', error);
            const reportContent = document.getElementById('report-content');
            reportContent.innerHTML = `
            <div class="text-red-600 text-center">
                <p>Failed to generate report</p>
                <p>${error.message}</p>
            </div>
        `;
            return [];
        }
    }

    async function generateReport(type) {
        const reportContent = document.getElementById('report-content');
        const reportType = document.getElementById('report-type');
        const reportDate = document.getElementById('report-date');
        const printButton = document.getElementById('print-button');
        const exportButton = document.getElementById('export-button');

        reportContent.innerHTML = `
            <div class="flex justify-center items-center">
                <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-blue-600"></div>
                <p class="ml-4 text-blue-600 font-semibold">Loading...</p>
            </div>
        `;

        reportType.textContent = `${type.charAt(0).toUpperCase() + type.slice(1)} Report`;
        reportDate.textContent = new Date().toLocaleString();

        printButton.classList.add('hidden');
        exportButton.classList.add('hidden');

        const data = await fetchReportData(type);
        window.currentReportData = data; // Store data globally for export
        renderReport(data);

        printButton.classList.remove('hidden');
        exportButton.classList.remove('hidden');
    }

    function renderReport(data) {
        const reportContent = document.getElementById('report-content');

        if (data.length === 0) {
            reportContent.innerHTML = `<p class="text-gray-500 text-center">No data available for the selected period.</p>`;
            return;
        }

        let html = `
            <table class="w-full border border-gray-200 text-sm mt-4">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="p-3 border border-gray-200">#</th>
                        <th class="p-3 border border-gray-200">Product ID</th>
                        <th class="p-3 border border-gray-200">Product Name</th>
                        <th class="p-3 border border-gray-200">Change Type</th>
                        <th class="p-3 border border-gray-200">Quantity Change</th>
                        <th class="p-3 border border-gray-200">User ID</th>
                        <th class="p-3 border border-gray-200">User Name</th>
                        <th class="p-3 border border-gray-200">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
        `;

        data.forEach((entry, index) => {
            html += `
                <tr class="border-b hover:bg-blue-50">
                    <td class="px-6 py-4 text-gray-800 font-medium">${index + 1}</td>
                    <td class="px-6 py-4 text-gray-800 font-medium">${entry.product_id}</td>
                    <td class="px-6 py-4 text-gray-800 font-medium">${entry.product_name}</td>
                    <td class="px-6 py-4 text-gray-800 font-medium">${entry.change_type || 'N/A'}</td>
                    <td class="px-6 py-4 text-gray-800 font-medium">${entry.quantity_change || '0'}</td>
                    <td class="px-6 py-4 text-gray-800 font-medium">${entry.user_id || 'N/A'}</td>
                    <td class="px-6 py-4 text-gray-800 font-medium">${entry.user_name || 'N/A'}</td>
                    <td class="px-6 py-4 text-gray-800 font-medium">${entry.timestamp || 'N/A'}</td>
                </tr>
            `;
        });

        html += `
                </tbody>
            </table>
        `;

        reportContent.innerHTML = html;
    }

    // Function to handle printing the report
    function printReport() {
        const reportContent = document.getElementById('report-content').innerHTML;
        const reportType = document.getElementById('report-type').textContent;
        const reportDate = document.getElementById('report-date').textContent;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>${reportType} - ${reportDate}</title>
                <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
                <style>
                    @page {
                        size: A4 landscape;
                        margin: 10mm;
                    }
                    * {
                        box-sizing: border-box;
                        margin: 0;
                        padding: 0;
                    }
                    body { 
                        font-family: 'Inter', Arial, sans-serif; 
                        line-height: 1.4; 
                        color: #333;
                        width: 100%;
                        margin: 0;
                        padding: 5mm;
                        font-size: 10pt;
                    }
                    .report-header {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        border-bottom: 3px solid #1E40AF;
                        padding-bottom: 10px;
                        margin-bottom: 15px;
                    }
                    .report-header-left h1 { 
                        color: #1E40AF; 
                        font-size: 20pt;
                        font-weight: 700;
                    }
                    .report-header-right {
                        text-align: right;
                        color: #6B7280;
                        font-size: 10pt;
                    }
                    .report-meta {
                        background-color: #F3F4F6; 
                        padding: 8px;
                        margin-bottom: 15px;
                        border-radius: 5px;
                        display: flex;
                        justify-content: space-between;
                        font-size: 10pt;
                    }
                    table { 
                        width: 100%; 
                        border-collapse: collapse; 
                        margin-top: 10px; 
                        font-size: 10pt;
                    }
                    th { 
                        color: rgb(0, 0, 0); 
                        padding: 6px; 
                        text-align: left; 
                        font-weight: bold;
                        border: 4px solid #1E40AF; 
                    } 
                    td { 
                        border: 3px solid #1E40AF; 
                        padding: 5px; 
                        text-align: left;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        max-width: 200px;
                    }
                    tr:nth-child(even) { 
                        background-color: #F9FAFB; 
                    }
                    .report-footer {
                        margin-top: 10px;
                        padding-top: 5px;
                        border-top: 1px solid #E5E7EB;
                        text-align: center;
                        font-size: 10pt;
                        color: #1E40AF;
                    }
                    @media print {
                        body {
                            width: 100%;
                        }
                        table {
                            page-break-inside: auto;
                        }
                        tr {
                            page-break-inside: avoid;
                            page-break-after: auto;
                        }
                        thead {
                            display: table-header-group;
                            position: sticky;
                            top: 0;
                            background: white;
                        }
                    }
                    /* Responsive table scrolling for large datasets */
                    .table-container {
                        max-height: 85vh;
                        overflow-y: auto;
                    }
                </style>
            </head>
            <body>
                <div class="report-header">
                    <div class="report-header-left">
                        <h1>${reportType}</h1>
                    </div>
                    <div class="report-header-right">
                        <p>InvenHammad System</p>
                        <p>Report Generated: ${reportDate}</p>
                    </div>
                </div>

                <div class="report-meta">
                    <div>
                        <strong>Report Type:</strong> ${reportType}
                    </div>
                    <div>
                        <strong>Generated By:</strong> <?php echo htmlspecialchars($_SESSION['user']['name']); ?>
                    </div>
                </div>

                <div class="table-container">
                    ${reportContent}
                </div>

                <div class="report-footer">
                    <p>© ${new Date().getFullYear()} InvenHammad - Confidential Document</p>
                    <p>Page <span class="pageNumber"></span> of <span class="totalPages"></span></p>
                </div>

                <script>
                    function updatePageNumbers() {
                        const totalPages = window.print ? window.print.length : 1;
                        document.querySelectorAll('.totalPages').forEach(el => el.textContent = totalPages);
                        document.querySelectorAll('.pageNumber').forEach((el, index) => el.textContent = index + 1);
                    }
                    window.onload = updatePageNumbers;
                    window.onafterprint = updatePageNumbers;
                <\/script>
            </body>
        </html>
    `);
        printWindow.document.close();

        // Automatically trigger print dialog
        printWindow.addEventListener('load', () => {
            printWindow.print();
        });
    }

    function exportToCSV() {
        // Use the globally stored report data
        const data = window.currentReportData || [];

        if (data.length === 0) {
            alert("No data available to export.");
            return;
        }

        const headers = [
            'Product ID', 'Product Name', 'Change Type',
            'Quantity Change', 'User ID', 'User Name', 'Timestamp'
        ];

        // Map data into rows, handling undefined or null values
        const rows = data.map(entry => [
            entry.product_id || '',
            entry.product_name || '',
            entry.change_type || '',
            entry.quantity_change || 0,
            entry.user_id || '',
            entry.user_name || '',
            entry.timestamp || ''
        ]);

        // Join headers and rows into a CSV string
        const csvContent = [
            headers.join(','), // Header row
            ...rows.map(row => row.map(value => `"${value}"`).join(',')) // Data rows
        ].join('\n');

        // Create a Blob for the CSV content
        const blob = new Blob([csvContent], {
            type: 'text/csv;charset=utf-8;'
        });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', `inventory_report_${new Date().toISOString().split('T')[0]}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>