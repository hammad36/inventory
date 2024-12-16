<section
    class="relative overflow-hidden min-h-[calc(101.1vh-8rem)] bg-gradient-to-b from-blue-100 via-blue-50 to-transparent pb-12  sm:pb-16  lg:pb-24 xl:pb-32 xl:">

    <div class="container mx-auto p-6 mt-20 sm:mt-28">
        <h1 class="text-5xl font-extrabold text-gray-800 mb-8 text-center">Inventory Reports</h1>

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
            </div>
        </div>
    </div>
</section>

<script>
    async function fetchReportData(type) {
        try {
            const response = await fetch(`/reports/filter?type=${type}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error('Error fetching report:', error);
            alert('Failed to fetch report. Please try again.');
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

        // Open a new window for printing
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>${reportType} - ${reportDate}</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                            margin: 20px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 20px;
                        }
                        th, td {
                            border: 1px solid #ddd;
                            padding: 8px;
                            text-align: left;
                        }
                        th {
                            background-color: #f4f4f4;
                            font-weight: bold;
                        }
                    </style>
                </head>
                <body>
                    <h1 style="text-align:center;">${reportType}</h1>
                    <p style="text-align:center;">Date Generated: ${reportDate}</p>
                    ${reportContent}

                    <h1 style="text-align:center;">this report was generated by ${user['name']}</h1>
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    }
</script>