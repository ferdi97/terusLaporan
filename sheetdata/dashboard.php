<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Ticket Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --background-color: #f8f9fa;
            --text-dark: #2b2d42;
            --text-light: #8d99ae;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-color);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        .sidebar {
            background: white;
            padding: 20px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            box-shadow: 0 0 30px rgba(0,0,0,0.02);
            border-right: 1px solid #e9ecef;
            z-index: 1000;
        }

        .sidebar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 2rem;
            padding: 0 1rem;
        }

        .nav-link {
            color: var(--text-light);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background: #f1f3ff;
            color: var(--primary-color);
        }

        .nav-link.active {
            background: var(--primary-color);
            color: white !important;
        }

        .content {
            margin-left: 260px;
            padding: 2rem;
            transition: margin 0.3s ease;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.03);
            transition: transform 0.3s ease;
            background: white;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 0;
        }

        .table thead {
            background: var(--primary-color);
            color: white;
        }

        .table th {
            font-weight: 600;
            padding: 1rem;
            border-bottom: 2px solid var(--secondary-color);
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid #eceef1;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-block;
        }

        .bg-sisa { background: #fff0e6; color: #ff6b35; }
        .bg-pending { background: #e6f3ff; color: #3a86ff; }
        .bg-close { background: #e6f6ec; color: #2a9d8f; }

        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }

        .ticket-type-header {
            background: #f8f9fa !important;
            color: var(--primary-color) !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .vertical-header {
            background: var(--primary-color);
            color: white;
            writing-mode: vertical-lr;
            transform: rotate(180deg);
            text-align: center;
            padding: 1rem 0.5rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 260px;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">TICKET ANALYTICS</div>
        <nav class="nav flex-column">
            <a class="nav-link active" href="#"><i class="fas fa-chart-line me-2"></i>Dashboard</a>
            <a class="nav-link" href="#"><i class="fas fa-ticket-alt me-2"></i>Tickets</a>
            <a class="nav-link" href="#"><i class="fas fa-users me-2"></i>Users</a>
            <a class="nav-link" href="#"><i class="fas fa-cogs me-2"></i>Settings</a>
        </nav>
    </div>
    
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Ticket Management Dashboard</h3>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-file-export me-2"></i>Export</button>
                <button class="btn btn-sm btn-primary"><i class="fas fa-calendar-alt me-2"></i>Date Filter</button>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Ticket Status Overview</h5>
                        <div class="text-muted small">Real-time Data</div>
                    </div>
                    <div class="chart-container">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Ticket Type Distribution</h5>
                        <div class="text-muted small">By Category</div>
                    </div>
                    <div class="chart-container">
                        <canvas id="typeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Detailed Ticket Statistics</h5>
                        <div class="text-muted small">Updated: Just now</div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="vertical-header">Sektor</th>
                                    <th rowspan="2" class="vertical-header">Status</th>
                                    <th colspan="3" class="text-center ticket-type-header">Tipe Tiket</th>
                                </tr>
                                <tr id="typeHeaders">
                                    <!-- Dynamic ticket type headers -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dynamic table content -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    const API_KEY = "AIzaSyDFdaSruBmI5mqA48IdCDeJvlnUppiJ5jA";
    const SPREADSHEET_ID = "1cNEzrgnhuijPC-qCR8UKG-NzRFVcpUF9i3gOG3anoU4";
    const RANGE = "MASTER_DATA!A1:V";

    async function fetchData() {
        try {
            const response = await fetch(
                `https://sheets.googleapis.com/v4/spreadsheets/${SPREADSHEET_ID}/values/${RANGE}?key=${API_KEY}`
            );
            const data = await response.json();
            processData(data.values);
        } catch (error) {
            console.error("Error fetching data:", error);
            showError("Failed to fetch data. Please check your connection.");
        }
    }

    function processData(rows) {
        if (!rows || rows.length === 0) {
            showError("No data available from the source.");
            return;
        }

        const headers = rows[0];
        const data = rows.slice(1);
        
        const processedData = {
            sectors: {},
            types: new Set(),
            statusCounts: { SISA: 0, PENDING: 0, CLOSE: 0 },
            detailed: {}
        };

        data.forEach(row => {
            const sector = row[9] || '';
            const type = row[6] || 'Unknown';
            const status = row[16] || 'Unknown';

            // Skip empty sector data
            if (sector.trim() === '') {
                return;
            }

            // Count statuses
            if (status === 'SISA' || status === 'PENDING' || status === 'CLOSE') {
                processedData.statusCounts[status]++;
            }

            processedData.types.add(type);

            if (!processedData.sectors[sector]) {
                processedData.sectors[sector] = {};
            }
            
            if (!processedData.sectors[sector][status]) {
                processedData.sectors[sector][status] = {};
            }

            if (!processedData.sectors[sector][status][type]) {
                processedData.sectors[sector][status][type] = 0;
            }
            
            processedData.sectors[sector][status][type]++;
        });

        renderCharts(processedData);
        populateTable(processedData);
    }

    function renderCharts(data) {
        renderStatusChart(data.statusCounts);
        renderTypeChart(data);
    }

    function renderStatusChart(statusCounts) {
        const ctx = document.getElementById('statusChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['SISA', 'PENDING', 'CLOSE'],
                datasets: [{
                    label: 'Ticket Count',
                    data: [
                        statusCounts.SISA,
                        statusCounts.PENDING,
                        statusCounts.CLOSE
                    ],
                    backgroundColor: [
                        '#ff6b35',
                        '#3a86ff',
                        '#2a9d8f'
                    ],
                    borderColor: [
                        '#ff6b35',
                        '#3a86ff',
                        '#2a9d8f'
                    ],
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f8f9fa'
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    function renderTypeChart(data) {
        const ctx = document.getElementById('typeChart').getContext('2d');
        const typeCounts = {};
        
        // Initialize all types with 0 count
        Array.from(data.types).forEach(type => {
            typeCounts[type] = 0;
        });

        // Calculate total counts for each type
        Object.values(data.sectors).forEach(sector => {
            Object.values(sector).forEach(status => {
                Object.entries(status).forEach(([type, count]) => {
                    typeCounts[type] += count;
                });
            });
        });

        // Filter out types with 0 count
        const filteredTypes = Object.entries(typeCounts)
            .filter(([_, count]) => count > 0)
            .sort((a, b) => b[1] - a[1]);

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: filteredTypes.map(([type]) => type),
                datasets: [{
                    data: filteredTypes.map(([_, count]) => count),
                    backgroundColor: [
                        '#4361ee',
                        '#3f37c9',
                        '#4cc9f0',
                        '#4895ef',
                        '#3a0ca3',
                        '#7209b7',
                        '#f72585'
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });
    }

    function populateTable(data) {
        const tbody = document.querySelector('#dataTable tbody');
        const typeHeaders = document.querySelector('#typeHeaders');
        tbody.innerHTML = '';
        typeHeaders.innerHTML = '';

        // Generate headers for ticket types
        Array.from(data.types)
            .sort()
            .forEach(type => {
                const th = document.createElement('th');
                th.className = 'ticket-type-header';
                th.textContent = type;
                typeHeaders.appendChild(th);
            });

        // Generate table rows, filtering out empty sectors
        Object.entries(data.sectors)
            .filter(([sector]) => sector.trim() !== '')
            .sort(([sectorA], [sectorB]) => sectorA.localeCompare(sectorB))
            .forEach(([sector, statusData]) => {
                Object.entries(statusData)
                    .sort(([statusA], [statusB]) => statusA.localeCompare(statusB))
                    .forEach(([status, typeData]) => {
                        const row = document.createElement('tr');
                        
                        // Sector and Status columns
                        row.innerHTML = `
                            <td>${sector}</td>
                            <td><span class="status-badge bg-${status.toLowerCase()}">${status}</span></td>
                        `;

                        // Ticket type columns
                        Array.from(data.types)
                            .sort()
                            .forEach(type => {
                                const count = typeData[type] || 0;
                                row.innerHTML += `<td>${count}</td>`;
                            });

                        tbody.appendChild(row);
                    });
            });

        // Show message if no valid data
        if (tbody.innerHTML === '') {
            tbody.innerHTML = `
                <tr>
                    <td colspan="${Array.from(data.types).length + 2}" class="text-center text-muted py-4">
                        No valid data available (empty sectors have been filtered out)
                    </td>
                </tr>
            `;
        }
    }

    function showError(message) {
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger alert-dismissible fade show';
        alert.role = 'alert';
        alert.innerHTML = `
            <i class="fas fa-exclamation-circle me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.querySelector('.content').prepend(alert);
    }

    document.addEventListener('DOMContentLoaded', fetchData);
</script>

</body>
</html>