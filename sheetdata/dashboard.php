<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tiket Professional</title>
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
        .clickable-ticket-count {
            cursor: pointer;
            color: var(--primary-color);
            font-weight: 500;
            transition: all 0.2s;
        }
        .clickable-ticket-count:hover {
            text-decoration: underline;
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
        <div class="sidebar-brand">ANALITIK TIKET</div>
        <nav class="nav flex-column">
            <a class="nav-link active" href="#"><i class="fas fa-chart-line me-2"></i>Dashboard</a>
            <a class="nav-link" href="#"><i class="fas fa-ticket-alt me-2"></i>Tiket</a>
            <a class="nav-link" href="#"><i class="fas fa-users me-2"></i>Pengguna</a>
            <a class="nav-link" href="#"><i class="fas fa-cogs me-2"></i>Pengaturan</a>
        </nav>
    </div>
    
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Dashboard Manajemen Tiket</h3>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-file-export me-2"></i>Ekspor</button>
                <button class="btn btn-sm btn-primary"><i class="fas fa-calendar-alt me-2"></i>Filter Tanggal</button>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Ringkasan Status Tiket</h5>
                        <div class="text-muted small">Data Real-time</div>
                    </div>
                    <div class="chart-container">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Distribusi Jenis Tiket</h5>
                        <div class="text-muted small">Berdasarkan Kategori</div>
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
                        <h5 class="mb-0">Statistik Tiket Detail</h5>
                        <div class="text-muted small">Diperbarui: Baru saja</div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="vertical-header">Sektor</th>
                                    <th rowspan="2" class="vertical-header">Status</th>
                                    <th colspan="3" class="text-center ticket-type-header">Jenis Tiket</th>
                                </tr>
                                <tr id="typeHeaders">
                                    <!-- Header jenis tiket akan diisi secara dinamis -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Isi tabel akan diisi secara dinamis -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Produktivitas Teknisi -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Detail Produktivitas Teknisi</h5>
                        <div class="text-muted small">Diperbarui: Baru saja</div>
                    </div>
                    
                    <!-- Kontrol Tabel -->
                    <div class="table-controls">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" id="technicianSearch" class="form-control" placeholder="Cari teknisi...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select id="sectorFilter" class="form-select">
                                    <option value="">Semua Sektor</option>
                                    <!-- Sektor akan diisi secara dinamis -->
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="statusFilter" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="high">Produktivitas Tinggi (>75%)</option>
                                    <option value="medium">Produktivitas Menengah (25-75%)</option>
                                    <option value="low">Produktivitas Rendah (<25%)</option>
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
                                <!-- Data teknisi akan diisi secara dinamis -->
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted small" id="technicianCount">Menampilkan 0 teknisi</div>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-primary" id="exportTechnicianData">
                                <i class="fas fa-file-export me-1"></i> Ekspor Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk detail tiket -->
    <div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ticketModalLabel">Detail Tiket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div><strong>Sektor:</strong> <span id="modalSector"></span></div>
                        <div><strong>Status:</strong> <span id="modalStatus"></span></div>
                        <div><strong>Tipe:</strong> <span id="modalType"></span></div>
                    </div>
                    <div class="modal-ticket-list" id="ticketList">
                        <!-- Item tiket akan dimasukkan di sini -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
            showError("Gagal mengambil data. Silakan cek koneksi Anda.");
        }
    }

    function processData(rows) {
        if (!rows || rows.length === 0) {
            showError("Tidak ada data yang tersedia dari sumber.");
            return;
        }

        const headers = rows[0];
        allTicketData = rows.slice(1).map(row => {
            return {
                id: row[0],
                ReportDate: row[1],
                BookingDate: row[2],
                HdCreate: row[5],
                teknisiAssign: row[4],  // Kolom 3 (indeks 4 berbasis 0)
                teknisiClose: row[20],  // Kolom 19 (indeks 20 berbasis 0)
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

        // Hitung semua tiket yang di-close oleh setiap teknisi
        allTicketData.forEach(ticket => {
            const { teknisiClose } = ticket;
            
            if (teknisiClose && teknisiClose.trim() !== '') {
                if (!processedData.technicians[teknisiClose]) {
                    processedData.technicians[teknisiClose] = {
                        nik: teknisiClose.split(' ')[0] || teknisiClose,
                        name: teknisiClose,
                        closedTickets: 0,
                        closedTicketTypes: new Set(),
                        closedTypeCounts: {}
                    };
                }
                processedData.technicians[teknisiClose].closedTickets++;
                processedData.technicians[teknisiClose].closedTicketTypes.add(ticket.type);
                
                if (!processedData.technicians[teknisiClose].closedTypeCounts[ticket.type]) {
                    processedData.technicians[teknisiClose].closedTypeCounts[ticket.type] = 0;
                }
                processedData.technicians[teknisiClose].closedTypeCounts[ticket.type]++;
            }
        });

        // Proses data tiket yang di-assign
        allTicketData.forEach(ticket => {
            const { sector, type, status, teknisiAssign } = ticket;

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
                        closedTickets: processedData.technicians[teknisiAssign]?.closedTickets || 0,
                        closedTicketTypes: processedData.technicians[teknisiAssign]?.closedTicketTypes || new Set(),
                        closedTypeCounts: processedData.technicians[teknisiAssign]?.closedTypeCounts || {}
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
        select.innerHTML = '<option value="">Semua Sektor</option>';
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
        
        document.getElementById('technicianCount').textContent = `Menampilkan ${visibleCount} teknisi`;
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
                        Tidak ada data teknisi yang tersedia
                    </td>
                </tr>
            `;
            document.getElementById('technicianCount').textContent = 'Menampilkan 0 teknisi';
            return;
        }

        technicianArray.forEach(tech => {
            const percentage = tech.totalTickets > 0 
                ? Math.round((tech.closedTickets / tech.totalTickets) * 100) 
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
            
            const closedTypeBadges = Object.entries(tech.closedTypeCounts)
                .map(([type, count]) => 
                    `<span class="badge badge-type clickable-ticket-count" 
                        data-technician="${tech.name}"
                        data-type="${type}"
                        data-status="CLOSE"
                        data-closeby="all">${type} (${count})</span>`)
                .join('');
            
            const row = document.createElement('tr');
            row.setAttribute('data-nik', tech.nik);
            row.setAttribute('data-name', tech.name);
            row.setAttribute('data-sector', tech.sector);
            row.setAttribute('data-total', tech.totalTickets);
            row.setAttribute('data-closed', tech.closedTickets);
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
                <td>
                    ${closedTypeBadges || '0'}
                    <span class="clickable-ticket-count" 
                        data-technician="${tech.name}"
                        data-status="CLOSE"
                        data-closeby="all">(${tech.closedTickets})</span>
                </td>
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
                const closeByAll = this.getAttribute('data-closeby') === 'all';
                
                if (type) {
                    showTechnicianTickets(technician, status, type, closeByAll);
                } else {
                    showTechnicianTickets(technician, status, null, closeByAll);
                }
            });
        });

        document.getElementById('technicianCount').textContent = `Menampilkan ${technicianArray.length} teknisi`;
    }

    function showTechnicianTickets(technician, status, type = null, closeByAll = false) {
        const filteredTickets = allTicketData.filter(ticket => {
            const matchesTechnician = closeByAll 
                ? (ticket.teknisiClose === technician)
                : (ticket.teknisiAssign === technician);
            const matchesStatus = status === 'all' || ticket.status === status;
            const matchesType = !type || ticket.type === type;
            
            return matchesTechnician && matchesStatus && matchesType;
        });

        document.getElementById('ticketModalLabel').textContent = `Detail Tiket - ${technician}`;
        document.getElementById('modalSector').textContent = filteredTickets[0]?.sector || 'N/A';
        document.getElementById('modalStatus').textContent = status === 'all' ? 'SEMUA' : status;
        document.getElementById('modalType').textContent = type || 'SEMUA';
        
        const ticketList = document.getElementById('ticketList');
        ticketList.innerHTML = '';
        
        if (filteredTickets.length === 0) {
            ticketList.innerHTML = '<div class="text-center text-muted py-4">Tidak ditemukan tiket</div>';
        } else {
            filteredTickets.forEach(ticket => {
                const ticketItem = document.createElement('div');
                ticketItem.className = 'ticket-item';
                ticketItem.innerHTML = `
                    <div class="d-flex justify-content-between">
                        <strong>${ticket.ReportDate || 'Tanggal Lapor Tidak Ada'}</strong>
                        <span class="badge bg-secondary">${ticket.id}</span>
                    </div>
                    <div class="text-muted small mb-2">Dibuat: ${ticket.HdCreate || 'Tidak Diketahui'}</div>
                    <div>${ticket.BookingDate || 'Tanggal Booking Tidak Ada'}</div>
                    <div class="mt-2">
                        <span class="badge bg-info">Teknisi Assign: ${ticket.teknisiAssign || 'Tidak Diketahui'}</span>
                        <span class="badge bg-success">Teknisi Close: ${ticket.teknisiClose || 'Tiket Masih Sisa'}</span>
                        <span class="badge ${ticket.status === 'SISA' ? 'bg-warning' : ticket.status === 'CLOSE' ? 'bg-success' : 'bg-primary'}">
                            Status: ${ticket.status}
                        </span>
                        <span class="badge bg-light text-dark ms-2">Tipe: ${ticket.type}</span>
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
                    label: 'Jumlah Tiket',
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
                        Tidak ada data yang valid (sektor kosong telah difilter)
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
            ticketList.innerHTML = '<div class="text-center text-muted py-4">Tidak ditemukan tiket</div>';
        } else {
            filteredTickets.forEach(ticket => {
                const ticketItem = document.createElement('div');
                ticketItem.className = 'ticket-item';
                ticketItem.innerHTML = `
                    <div class="d-flex justify-content-between">
                        <strong>${ticket.ReportDate || 'Tanggal Lapor Tidak Ada'}</strong>
                        <span class="badge bg-secondary">${ticket.id}</span>
                    </div>
                    <div class="text-muted small mb-2">Dibuat: ${ticket.HdCreate || 'Tidak Diketahui'}</div>
                    <div>${ticket.BookingDate || 'Tanggal Booking Tidak Ada'}</div>
                    <div class="mt-2">
                        <span class="badge bg-info">Teknisi Assign: ${ticket.teknisiAssign || 'Tidak Diketahui'}</span>
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