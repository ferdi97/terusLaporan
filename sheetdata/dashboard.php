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
        } /* Add this new style to existing styles */
        .clickable-ticket-count {
            cursor: pointer;
            color: var(--primary-color);
            font-weight: 500;
            transition: all 0.2s;
        }
        .clickable-ticket-count:hover {
            text-decoration: underline;
        }

        .clickable-count {
            cursor: pointer;
            transition: all 0.2s;
        }

        .clickable-count:hover {
            background-color: #f1f3ff;
            font-weight: bold;
        }

        .modal-ticket-list {
            max-height: 60vh;
            overflow-y: auto;
        }

        .ticket-item {
            border-bottom: 1px solid #eee;
            padding: 10px;
        }

        .ticket-item:last-child {
            border-bottom: none;
        }

        /* New styles for technician table */
        .technician-table th {
            white-space: nowrap;
            position: relative;
        }
        .technician-table td {
            vertical-align: middle;
        }
        .progress {
            height: 10px;
            border-radius: 5px;
        }
        .progress-bar {
            background-color: var(--primary-color);
        }
        .table-controls {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .sortable-header {
            cursor: pointer;
            transition: all 0.2s;
        }
        .sortable-header:hover {
            background-color: rgba(67, 97, 238, 0.1);
        }
        .sort-icon {
            margin-left: 5px;
            opacity: 0.5;
        }
        .active-sort {
            background-color: rgba(67, 97, 238, 0.1);
        }
        .active-sort .sort-icon {
            opacity: 1;
        }
        .filter-dropdown {
            min-width: 200px;
        }
        .badge-type {
            background-color: #e9ecef;
            color: #495057;
            margin-right: 4px;
            margin-bottom: 4px;
            display: inline-block;
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

        <div class="row g-4 mb-4">
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

        <!-- New Technician Productivity Table -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Detail Produktivitas Teknisi</h5>
                        <div class="text-muted small">Updated: Just now</div>
                    </div>
                    
                    <!-- Table Controls -->
                    <div class="table-controls">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" id="technicianSearch" class="form-control" placeholder="Search technicians...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select id="sectorFilter" class="form-select">
                                    <option value="">All Sectors</option>
                                    <!-- Sectors will be populated dynamically -->
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="statusFilter" class="form-select">
                                    <option value="">All Statuses</option>
                                    <option value="high">High Productivity (>75%)</option>
                                    <option value="medium">Medium Productivity (25-75%)</option>
                                    <option value="low">Low Productivity (<25%)</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button id="resetFilters" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-undo me-1"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table technician-table">
                            <thead>
                                <tr>
                                    <th class="sortable-header" data-sort="nik">NIK <i class="fas fa-sort sort-icon"></i></th>
                                    <th class="sortable-header" data-sort="name">Nama Teknisi <i class="fas fa-sort sort-icon"></i></th>
                                    <th class="sortable-header" data-sort="sector">Sektor <i class="fas fa-sort sort-icon"></i></th>
                                    <th class="sortable-header" data-sort="total">Total Tiket <i class="fas fa-sort sort-icon"></i></th>
                                    <th>Jenis Tiket</th>
                                    <th>Saldo Tiket</th>
                                    <th class="sortable-header" data-sort="closed">Tiket Selesai <i class="fas fa-sort sort-icon"></i></th>
                                    <th class="sortable-header" data-sort="percentage">Persentase <i class="fas fa-sort sort-icon"></i></th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody id="technicianTableBody">
                                <!-- Dynamic technician data will be inserted here -->
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted small" id="technicianCount">Showing 0 technicians</div>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-primary" id="exportTechnicianData">
                                <i class="fas fa-file-export me-1"></i> Export Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for showing ticket details -->
    <div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ticketModalLabel">Ticket Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div><strong>Sektor:</strong> <span id="modalSector"></span></div>
                        <div><strong>Status:</strong> <span id="modalStatus"></span></div>
                        <div><strong>Tipe:</strong> <span id="modalType"></span></div>
                    </div>
                    <div class="modal-ticket-list" id="ticketList">
                        <!-- Ticket items will be inserted here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<script>
    const API_KEY = "AIzaSyDFdaSruBmI5mqA48IdCDeJvlnUppiJ5jA";
const SPREADSHEET_ID = "1cNEzrgnhuijPC-qCR8UKG-NzRFVcpUF9i3gOG3anoU4";
const RANGE = "MASTER_DATA!A1:V";
let allTicketData = [];

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
    allTicketData = rows.slice(1).map(row => {
        return {
            id: row[0],
            ReportDate: row[1],
            BookingDate: row[2],
            HdCreate: row[5],
            teknisiAssign: row[4],  // Column 3 (0-based index 4)
            teknisiClose: row[20],   // Column 19 (0-based index 20)
            type: row[6] || 'Unknown',
            flag: row[8],
            sector: row[9] || '',
            status: row[16] || 'Unknown',
        };
    });
    
    const processedData = {
        sectors: {},
        types: new Set(),
        statusCounts: { SISA: 0, PENDING: 0, CLOSE: 0 },
        detailed: {},
        technicians: {},
        allSectors: new Set()
    };

    allTicketData.forEach(ticket => {
        const { sector, type, status, teknisiAssign, teknisiClose } = ticket;

        if (sector.trim() !== '') {
            processedData.allSectors.add(sector);
        }

        if (sector.trim() === '') {
            return;
        }

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

        // Process technician data
        if (teknisiAssign) {
            if (!processedData.technicians[teknisiAssign]) {
                processedData.technicians[teknisiAssign] = {
                    nik: teknisiAssign.split(' ')[0] || teknisiAssign,
                    name: teknisiAssign,
                    sector: sector,
                    totalTickets: 0,
                    ticketTypes: new Set(),
                    typeCounts: {},
                    sisaTickets: 0,
                    sisaTypeCounts: {},
                    closedTickets: 0,
                    closedBySelf: 0
                };
            }
            
            processedData.technicians[teknisiAssign].totalTickets++;
            processedData.technicians[teknisiAssign].ticketTypes.add(type);
            
            if (!processedData.technicians[teknisiAssign].typeCounts[type]) {
                processedData.technicians[teknisiAssign].typeCounts[type] = 0;
            }
            processedData.technicians[teknisiAssign].typeCounts[type]++;
            
            if (status === 'SISA') {
                processedData.technicians[teknisiAssign].sisaTickets++;
                if (!processedData.technicians[teknisiAssign].sisaTypeCounts[type]) {
                    processedData.technicians[teknisiAssign].sisaTypeCounts[type] = 0;
                }
                processedData.technicians[teknisiAssign].sisaTypeCounts[type]++;
            }
            
            if (status === 'CLOSE') {
                processedData.technicians[teknisiAssign].closedTickets++;
                // Only count if closed by the same technician
                if (teknisiClose && teknisiClose.trim() === teknisiAssign.trim()) {
                    processedData.technicians[teknisiAssign].closedBySelf++;
                }
            }
        }
    });

    renderCharts(processedData);
    populateTable(processedData);
    populateTechnicianTable(processedData.technicians);
    populateSectorFilter(Array.from(processedData.allSectors).sort());
    setupTableControls();
}

function populateSectorFilter(sectors) {
    const select = document.getElementById('sectorFilter');
    sectors.forEach(sector => {
        const option = document.createElement('option');
        option.value = sector;
        option.textContent = sector;
        select.appendChild(option);
    });
}

function setupTableControls() {
    document.getElementById('technicianSearch').addEventListener('input', filterTechnicianTable);
    document.getElementById('sectorFilter').addEventListener('change', filterTechnicianTable);
    document.getElementById('statusFilter').addEventListener('change', filterTechnicianTable);
    document.getElementById('resetFilters').addEventListener('click', function() {
        document.getElementById('technicianSearch').value = '';
        document.getElementById('sectorFilter').value = '';
        document.getElementById('statusFilter').value = '';
        filterTechnicianTable();
    });

    document.querySelectorAll('.sortable-header').forEach(header => {
        header.addEventListener('click', function() {
            const sortBy = this.getAttribute('data-sort');
            const currentOrder = this.getAttribute('data-order') || 'none';
            let newOrder = 'asc';
            
            if (currentOrder === 'asc') {
                newOrder = 'desc';
            } else if (currentOrder === 'desc') {
                newOrder = 'none';
            } else {
                newOrder = 'asc';
            }
            
            document.querySelectorAll('.sortable-header').forEach(h => {
                h.classList.remove('active-sort');
                h.setAttribute('data-order', 'none');
                h.querySelector('.sort-icon').className = 'fas fa-sort sort-icon';
            });
            
            if (newOrder !== 'none') {
                this.classList.add('active-sort');
                this.setAttribute('data-order', newOrder);
                
                const icon = this.querySelector('.sort-icon');
                icon.className = newOrder === 'asc' 
                    ? 'fas fa-sort-up sort-icon' 
                    : 'fas fa-sort-down sort-icon';
                
                sortTechnicianTable(sortBy, newOrder);
            } else {
                sortTechnicianTable('total', 'desc');
            }
        });
    });

    document.getElementById('exportTechnicianData').addEventListener('click', exportTechnicianData);
    sortTechnicianTable('total', 'desc');
}

function filterTechnicianTable() {
    const searchTerm = document.getElementById('technicianSearch').value.toLowerCase();
    const sectorFilter = document.getElementById('sectorFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    
    const rows = document.querySelectorAll('#technicianTableBody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const name = row.getAttribute('data-name').toLowerCase();
        const sector = row.getAttribute('data-sector');
        const percentage = parseFloat(row.getAttribute('data-percentage'));
        
        const matchesSearch = name.includes(searchTerm) || 
                            row.getAttribute('data-nik').toLowerCase().includes(searchTerm);
        const matchesSector = !sectorFilter || sector === sectorFilter;
        let matchesStatus = true;
        
        if (statusFilter === 'high') {
            matchesStatus = percentage > 75;
        } else if (statusFilter === 'medium') {
            matchesStatus = percentage >= 25 && percentage <= 75;
        } else if (statusFilter === 'low') {
            matchesStatus = percentage < 25;
        }
        
        if (matchesSearch && matchesSector && matchesStatus) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    document.getElementById('technicianCount').textContent = `Showing ${visibleCount} technicians`;
}

function sortTechnicianTable(sortBy, order) {
    if (order === 'none') return;
    
    const tbody = document.getElementById('technicianTableBody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        let aValue, bValue;
        
        switch (sortBy) {
            case 'nik':
                aValue = a.getAttribute('data-nik');
                bValue = b.getAttribute('data-nik');
                return order === 'asc' ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
            case 'name':
                aValue = a.getAttribute('data-name');
                bValue = b.getAttribute('data-name');
                return order === 'asc' ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
            case 'sector':
                aValue = a.getAttribute('data-sector');
                bValue = b.getAttribute('data-sector');
                return order === 'asc' ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
            case 'total':
                aValue = parseInt(a.getAttribute('data-total'));
                bValue = parseInt(b.getAttribute('data-total'));
                return order === 'asc' ? aValue - bValue : bValue - aValue;
            case 'closed':
                aValue = parseInt(a.getAttribute('data-closed'));
                bValue = parseInt(b.getAttribute('data-closed'));
                return order === 'asc' ? aValue - bValue : bValue - aValue;
            case 'percentage':
                aValue = parseFloat(a.getAttribute('data-percentage'));
                bValue = parseFloat(b.getAttribute('data-percentage'));
                return order === 'asc' ? aValue - bValue : bValue - aValue;
            default:
                return 0;
        }
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

function populateTechnicianTable(technicians) {
    const tbody = document.getElementById('technicianTableBody');
    tbody.innerHTML = '';

    const technicianArray = Object.values(technicians);

    if (technicianArray.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="9" class="text-center text-muted py-4">
                    No technician data available
                </td>
            </tr>
        `;
        document.getElementById('technicianCount').textContent = 'Showing 0 technicians';
        return;
    }

    technicianArray.forEach(tech => {
        const percentage = tech.totalTickets > 0 
            ? Math.round((tech.closedBySelf / tech.totalTickets) * 100) 
            : 0;
        
        const typeBadges = Object.entries(tech.typeCounts)
            .map(([type, count]) => 
                `<span class="badge badge-type clickable-ticket-count" 
                    data-technician="${tech.name}"
                    data-type="${type}"
                    data-status="all">${type} (${count})</span>`)
            .join('');
        
        const sisaTypeCount = Object.keys(tech.sisaTypeCounts).length;
        const sisaBadges = Object.entries(tech.sisaTypeCounts)
            .map(([type, count]) => 
                `<span class="badge badge-type clickable-ticket-count" 
                    data-technician="${tech.name}"
                    data-type="${type}"
                    data-status="SISA">${type} (${count})</span>`)
            .join('');
        
        const row = document.createElement('tr');
        row.setAttribute('data-nik', tech.nik);
        row.setAttribute('data-name', tech.name);
        row.setAttribute('data-sector', tech.sector);
        row.setAttribute('data-total', tech.totalTickets);
        row.setAttribute('data-closed', tech.closedBySelf);
        row.setAttribute('data-percentage', percentage);
        
        row.innerHTML = `
            <td>${tech.nik || 'N/A'}</td>
            <td>${tech.name || 'N/A'}</td>
            <td>${tech.sector || 'N/A'}</td>
            <td class="clickable-ticket-count" 
                data-technician="${tech.name}"
                data-status="all">${tech.totalTickets}</td>
            <td>${typeBadges}</td>
            <td>
                ${sisaBadges || '0'}
                <span class="clickable-ticket-count" 
                    data-technician="${tech.name}"
                    data-status="SISA">(${tech.sisaTickets})</span>
            </td>
            <td class="clickable-ticket-count" 
                data-technician="${tech.name}"
                data-status="CLOSE"
                data-closeby="self">${tech.closedBySelf}</td>
            <td>${percentage}%</td>
            <td>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: ${percentage}%" 
                        aria-valuenow="${percentage}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });

    document.querySelectorAll('.clickable-ticket-count').forEach(element => {
        element.addEventListener('click', function() {
            const technician = this.getAttribute('data-technician');
            const type = this.getAttribute('data-type');
            const status = this.getAttribute('data-status');
            const closeBySelf = this.getAttribute('data-closeby') === 'self';
            
            if (type) {
                showTechnicianTickets(technician, status, type, closeBySelf);
            } else {
                showTechnicianTickets(technician, status, null, closeBySelf);
            }
        });
    });

    document.getElementById('technicianCount').textContent = `Showing ${technicianArray.length} technicians`;
}

function showTechnicianTickets(technician, status, type = null, closeBySelf = false) {
    const filteredTickets = allTicketData.filter(ticket => {
        const matchesTechnician = ticket.teknisiAssign === technician;
        const matchesStatus = status === 'all' || ticket.status === status;
        const matchesType = !type || ticket.type === type;
        const matchesCloseBy = !closeBySelf || 
                             (ticket.teknisiClose && ticket.teknisiClose.trim() === technician.trim());
        
        return matchesTechnician && matchesStatus && matchesType && matchesCloseBy;
    });

    document.getElementById('ticketModalLabel').textContent = `Ticket Details - ${technician}`;
    document.getElementById('modalSector').textContent = filteredTickets[0]?.sector || 'N/A';
    document.getElementById('modalStatus').textContent = status === 'all' ? 'ALL' : status;
    document.getElementById('modalType').textContent = type || 'ALL';
    
    const ticketList = document.getElementById('ticketList');
    ticketList.innerHTML = '';
    
    if (filteredTickets.length === 0) {
        ticketList.innerHTML = '<div class="text-center text-muted py-4">No tickets found</div>';
    } else {
        filteredTickets.forEach(ticket => {
            const ticketItem = document.createElement('div');
            ticketItem.className = 'ticket-item';
            ticketItem.innerHTML = `
                <div class="d-flex justify-content-between">
                    <strong>${ticket.ReportDate || 'No Report Date'}</strong>
                    <span class="badge bg-secondary">${ticket.id}</span>
                </div>
                <div class="text-muted small mb-2">Created: ${ticket.HdCreate || 'Unknown'}</div>
                <div>${ticket.BookingDate || 'No Booking Date'}</div>
                <div class="mt-2">
                    <span class="badge bg-info">Teknisi Assign: ${ticket.teknisiAssign || 'Unknown'}</span>
                    <span class="badge bg-success">Teknisi Close: ${ticket.teknisiClose || 'Tiket Masih Sisa'}</span>
                    <span class="badge ${ticket.status === 'SISA' ? 'bg-warning' : ticket.status === 'CLOSE' ? 'bg-success' : 'bg-primary'}">
                        Status: ${ticket.status}
                    </span>
                    <span class="badge bg-light text-dark ms-2">Type: ${ticket.type}</span>
                    <span class="badge bg-light text-dark ms-2">Flag: ${ticket.flag || 'None'}</span>
                </div>
            `;
            ticketList.appendChild(ticketItem);
        });
    }
    
    const modal = new bootstrap.Modal(document.getElementById('ticketModal'));
    modal.show();
}

function exportTechnicianData() {
    let csv = 'NIK,Nama Teknisi,Sektor,Total Tiket,Jenis Tiket,Saldo Tiket,Tiket Selesai,Persentase\n';
    
    document.querySelectorAll('#technicianTableBody tr').forEach(row => {
        if (row.style.display !== 'none') {
            const cells = row.querySelectorAll('td');
            const rowData = [
                cells[0].textContent,
                cells[1].textContent,
                cells[2].textContent,
                cells[3].textContent,
                cells[4].textContent.replace(/\n/g, ' ').trim(),
                cells[5].textContent,
                cells[6].textContent,
                cells[7].textContent
            ];
            csv += rowData.map(d => `"${d.replace(/"/g, '""')}"`).join(',') + '\n';
        }
    });
    
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'produktivitas_teknisi.csv');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
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
                data: [statusCounts.SISA, statusCounts.PENDING, statusCounts.CLOSE],
                backgroundColor: ['#ff6b35', '#3a86ff', '#2a9d8f'],
                borderColor: ['#ff6b35', '#3a86ff', '#2a9d8f'],
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
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
                    grid: { color: '#f8f9fa' },
                    ticks: { stepSize: 1 }
                },
                x: { grid: { display: false } }
            }
        }
    });
}

function renderTypeChart(data) {
    const ctx = document.getElementById('typeChart').getContext('2d');
    const typeCounts = {};
    
    Array.from(data.types).forEach(type => {
        typeCounts[type] = 0;
    });

    Object.values(data.sectors).forEach(sector => {
        Object.values(sector).forEach(status => {
            Object.entries(status).forEach(([type, count]) => {
                typeCounts[type] += count;
            });
        });
    });

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
                    '#4361ee', '#3f37c9', '#4cc9f0', '#4895ef', 
                    '#3a0ca3', '#7209b7', '#f72585'
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
                        font: { size: 12 }
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

    Array.from(data.types)
        .sort()
        .forEach(type => {
            const th = document.createElement('th');
            th.className = 'ticket-type-header';
            th.textContent = type;
            typeHeaders.appendChild(th);
        });

    Object.entries(data.sectors)
        .filter(([sector]) => sector.trim() !== '')
        .sort(([sectorA], [sectorB]) => sectorA.localeCompare(sectorB))
        .forEach(([sector, statusData]) => {
            Object.entries(statusData)
                .sort(([statusA], [statusB]) => statusA.localeCompare(statusB))
                .forEach(([status, typeData]) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${sector}</td>
                        <td><span class="status-badge bg-${status.toLowerCase()}">${status}</span></td>
                    `;

                    Array.from(data.types)
                        .sort()
                        .forEach(type => {
                            const count = typeData[type] || 0;
                            if (count > 0) {
                                row.innerHTML += `<td class="clickable-count" 
                                    data-sector="${sector}" 
                                    data-status="${status}" 
                                    data-type="${type}">${count}</td>`;
                            } else {
                                row.innerHTML += `<td>0</td>`;
                            }
                        });

                    tbody.appendChild(row);
                });
        });

    document.querySelectorAll('.clickable-count').forEach(cell => {
        cell.addEventListener('click', function() {
            showTicketDetails(
                this.getAttribute('data-sector'),
                this.getAttribute('data-status'),
                this.getAttribute('data-type')
            );
        });
    });

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

function showTicketDetails(sector, status, type) {
    const filteredTickets = allTicketData.filter(ticket => {
        return ticket.sector === sector && 
               ticket.status === status && 
               ticket.type === type;
    });

    document.getElementById('modalSector').textContent = sector;
    document.getElementById('modalStatus').textContent = status;
    document.getElementById('modalType').textContent = type;
    
    const ticketList = document.getElementById('ticketList');
    ticketList.innerHTML = '';
    
    if (filteredTickets.length === 0) {
        ticketList.innerHTML = '<div class="text-center text-muted py-4">No tickets found</div>';
    } else {
        filteredTickets.forEach(ticket => {
            const ticketItem = document.createElement('div');
            ticketItem.className = 'ticket-item';
            ticketItem.innerHTML = `
                <div class="d-flex justify-content-between">
                    <strong>${ticket.ReportDate || 'No Report Date'}</strong>
                    <span class="badge bg-secondary">${ticket.id}</span>
                </div>
                <div class="text-muted small mb-2">Created: ${ticket.HdCreate || 'Unknown'}</div>
                <div>${ticket.BookingDate || 'No Booking Date'}</div>
                <div class="mt-2">
                    <span class="badge bg-info">Teknisi Assign: ${ticket.teknisiAssign || 'Unknown'}</span>
                    <span class="badge bg-success">Teknisi Close: ${ticket.teknisiClose || 'Tiket Masih Sisa'}</span>
                    <span class="badge bg-light text-dark ms-2">Flag: ${ticket.flag || 'None'}</span>
                </div>
            `;
            ticketList.appendChild(ticketItem);
        });
    }
    
    const modal = new bootstrap.Modal(document.getElementById('ticketModal'));
    modal.show();
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