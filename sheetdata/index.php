<?php
// Configuration
$spreadsheetId = "1cNEzrgnhuijPC-qCR8UKG-NzRFVcpUF9i3gOG3anoU4";
$range = "MASTER_DATA!A1:V";
$apiKey = "AIzaSyDFdaSruBmI5mqA48IdCDeJvlnUppiJ5jA";

// Fetch data from Google Sheets
$url = "https://sheets.googleapis.com/v4/spreadsheets/$spreadsheetId/values/$range?key=$apiKey";
$response = @file_get_contents($url);

if ($response === false) {
    die("Error fetching data from Google Sheets. Please check your configuration.");
}

$data = json_decode($response, true);
$headers = $data['values'][0] ?? [];
$rows = array_slice($data['values'], 1);

// Prepare filter options and statistics
$filterOptions = array_fill(0, count($headers), []);
$statistics = [
    'status' => [],
    'priority' => [],
    'type' => []
];

// Determine column indices for statistics
$statusCol = array_search('STATUS', $headers);
$priorityCol = array_search('PRIORITY', $headers);
$typeCol = array_search('TICKET_TYPE', $headers);

// Find the internet number column
$inetCol = array_search('NOMOR INET', $headers);

foreach ($rows as $row) {
    // Prepare filter options
    foreach ($headers as $index => $header) {
        if (isset($row[$index])) {
            $value = trim($row[$index]);
            if ($value !== "" && !in_array($value, $filterOptions[$index])) {
                $filterOptions[$index][] = $value;
            }
        }
    }
    
    // Collect statistics
    if ($statusCol !== false && isset($row[$statusCol])) {
        $status = $row[$statusCol];
        $statistics['status'][$status] = ($statistics['status'][$status] ?? 0) + 1;
    }
    
    if ($priorityCol !== false && isset($row[$priorityCol])) {
        $priority = $row[$priorityCol];
        $statistics['priority'][$priority] = ($statistics['priority'][$priority] ?? 0) + 1;
    }
    
    if ($typeCol !== false && isset($row[$typeCol])) {
        $type = $row[$typeCol];
        $statistics['type'][$type] = ($statistics['type'][$type] ?? 0) + 1;
    }
}

// Sort filter options and statistics
foreach ($filterOptions as &$options) {
    sort($options);
}

foreach ($statistics as &$stats) {
    arsort($stats);
}

// Store data in JSON format for JavaScript
$jsonData = json_encode([
    'headers' => $headers,
    'rows' => $rows,
    'filterOptions' => $filterOptions,
    'statistics' => $statistics,
    'columnMap' => [
        'status' => $statusCol,
        'priority' => $priorityCol,
        'type' => $typeCol,
        'inet' => $inetCol
    ]
]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket System | Interactive Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #f8f9fa;
            --header-color: #2c3e50;
        }
        
        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            background-color: var(--secondary-color);
            color: #333;
            line-height: 1.6;
        }
        
        .container-fluid {
            padding: 20px;
            max-width: 99%;
        }
        
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: var(--header-color);
            color: white;
            padding: 12px 20px;
            border-radius: 8px 8px 0 0 !important;
        }
        
        .stat-card {
            transition: all 0.3s ease;
            cursor: pointer;
            border-left: 4px solid var(--primary-color);
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card.active {
            background-color: #e3f2fd;
            border-left: 4px solid #1565c0;
        }
        
        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #666;
        }
        
        .search-container {
            background-color: white;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .table-responsive {
            max-height: 75vh;
            overflow-y: auto;
        }
        
        .table {
            font-size: 0.85rem;
            margin-bottom: 0;
        }
        
        .table th {
            position: sticky;
            top: 0;
            background-color: var(--header-color);
            color: white;
            font-weight: 500;
            padding: 8px 12px;
        }
        
        .table td {
            padding: 6px 12px;
            vertical-align: middle;
        }
        
        .filter-select {
            font-size: 0.8rem;
            width: 100%;
            margin-top: 5px;
            padding: 3px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        
        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
            flex-direction: column;
        }
        
        .search-input {
            position: relative;
        }
        
        .search-input i {
            position: absolute;
            left: 10px;
            top: 10px;
            color: #aaa;
        }
        
        .search-input input {
            padding-left: 35px;
            border-radius: 20px;
        }
        
        .result-count {
            color: #666;
            font-size: 0.9rem;
            margin-left: 10px;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #666;
        }
        
        .empty-state i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #ccc;
        }
        
        .stats-row {
            margin-bottom: 15px;
        }
        
        .badge-filter {
            cursor: pointer;
            margin-left: 5px;
        }
        
        .inet-checker {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .inet-results {
            margin-top: 20px;
        }
        
        .ticket-item {
            background-color: #fff;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .ticket-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .ticket-badge {
            font-size: 0.8rem;
            margin-right: 5px;
        }
        
        .ticket-details {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
        }
        
        .detail-item {
            margin-bottom: 8px;
        }
        
        .detail-label {
            font-weight: 600;
            color: #555;
            font-size: 0.85rem;
        }
        
        .detail-value {
            font-size: 0.9rem;
        }
        
        .not-found-item {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 5px;
            font-family: monospace;
        }
        
        .copy-btn {
            cursor: pointer;
            padding: 5px 10px;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 0.8rem;
        }
        
        .copy-btn:hover {
            background-color: #5a6268;
        }
        
        .not-found-container {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin-top: 15px;
        }
        
        @media (max-width: 768px) {
            .container-fluid {
                padding: 10px;
            }
            
            .table {
                font-size: 0.75rem;
            }
            
            .search-container {
                padding: 10px;
            }
            
            .stat-card {
                margin-bottom: 10px;
            }
            
            .ticket-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Ticket Statistics</h5>
                <small class="text-light">Last updated: <?php date_default_timezone_set('Asia/Makassar'); echo date('d M Y H:i'); ?></small>
            </div>
            <div class="card-body">
                <div class="row stats-row">
                    <div class="col-md-12">
                        <h6><i class="bi bi-check-circle"></i> By Status</h6>
                        <div class="row" id="statusStats">
                            <!-- Status statistics will be inserted by JavaScript -->
                        </div>
                    </div>
                </div>
                
                <div class="row stats-row">
                    <div class="col-md-12">
                        <h6><i class="bi bi-exclamation-triangle"></i> By Priority</h6>
                        <div class="row" id="priorityStats">
                            <!-- Priority statistics will be inserted by JavaScript -->
                        </div>
                    </div>
                </div>
                
                <div class="row stats-row">
                    <div class="col-md-12">
                        <h6><i class="bi bi-tag"></i> By Type</h6>
                        <div class="row" id="typeStats">
                            <!-- Type statistics will be inserted by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Ticket Data</h5>
                <div id="activeFilters">
                    <!-- Active filters will be shown here -->
                </div>
            </div>
            <div class="search-container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="search-input">
                            <i class="bi bi-search"></i>
                            <input type="text" id="globalSearch" class="form-control" placeholder="Search across all columns...">
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <button id="applyFilters" class="btn btn-primary btn-sm me-2">
                            <i class="bi bi-funnel"></i> Apply Filters
                        </button>
                        <button id="resetFilters" class="btn btn-outline-secondary btn-sm me-2">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </button>
                        <span id="resultCount" class="result-count">No filters applied</span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="loading-spinner" id="initialLoading">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">Preparing data...</p>
                </div>
                
                <div class="empty-state" id="emptyState">
                    <i class="bi bi-database"></i>
                    <h5>No data displayed</h5>
                    <p>Click on statistics or apply filters to view data</p>
                </div>
                
                <div class="table-responsive d-none" id="tableContainer">
                    <table class="table table-hover table-striped mb-0" id="dataTable">
                        <thead>
                            <tr id="tableHeaders">
                                <!-- Headers will be inserted by JavaScript -->
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <!-- Data will be inserted by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Form Pengecekan Detail Tiket Berdasarkan Nomor Internet -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-search"></i> Cek Detail Tiket Berdasarkan Nomor Internet</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="inetNumbers" class="form-label">Masukkan nomor internet (satu nomor per baris):</label>
                            <textarea class="form-control" id="inetNumbers" rows="8" placeholder="Contoh:&#10;1234567890&#10;0987654321&#10;..."></textarea>
                            <div class="form-text">Anda dapat memasukkan hingga 1000 nomor internet sekaligus.</div>
                        </div>
                        <button id="checkInetNumbers" class="btn btn-primary">
                            <i class="bi bi-search"></i> Cari Tiket
                        </button>
                        <button id="clearInput" class="btn btn-outline-secondary ms-2">
                            <i class="bi bi-trash"></i> Bersihkan
                        </button>
                    </div>
                </div>

                <div id="inetResults" class="mt-4 d-none">
                    <h5>Hasil Pencarian</h5>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> 
                        <span id="summaryText"></span>
                    </div>
                    
                    <div class="accordion" id="resultsAccordion">
                        <!-- Hasil pencarian akan ditampilkan di sini -->
                    </div>
                    
                    <div id="notFoundContainer" class="not-found-container mt-4 d-none">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Nomor Internet Tidak Ditemukan</h6>
                            <button class="copy-btn" id="copyNotFound">
                                <i class="bi bi-clipboard"></i> Salin
                            </button>
                        </div>
                        <div id="notFoundList" class="not-found-list">
                            <!-- Daftar nomor yang tidak ditemukan akan ditampilkan di sini -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Store all data in memory
            const appData = <?php echo $jsonData; ?>;
            let filteredData = [];
            let currentFilters = {};
            let currentSearch = '';
            let activeStatFilter = null;
            let notFoundNumbers = [];
            
            // Initialize the table headers
            function initTableHeaders() {
                let headersHtml = '';
                appData.headers.forEach((header, index) => {
                    headersHtml += `
                        <th>
                            <div>${header}</div>
                            <select class="filter-select" data-index="${index}">
                                <option value="">All</option>
                                ${appData.filterOptions[index].map(option => 
                                    `<option value="${escapeHtml(option)}">${escapeHtml(option)}</option>`
                                ).join('')}
                            </select>
                        </th>
                    `;
                });
                $('#tableHeaders').html(headersHtml);
            }
            
            // Initialize statistics cards
            function initStatistics() {
                renderStatCards('status', appData.statistics.status);
                renderStatCards('priority', appData.statistics.priority);
                renderStatCards('type', appData.statistics.type);
            }
            
            // Render statistic cards
            function renderStatCards(type, stats) {
                const container = $(`#${type}Stats`);
                container.empty();
                
                for (const [name, count] of Object.entries(stats)) {
                    container.append(`
                        <div class="col-md-3 col-sm-6 mb-3 stat-card" 
                             data-type="${type}" 
                             data-value="${escapeHtml(name)}"
                             title="Click to filter ${type}: ${escapeHtml(name)}">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="stat-value">${count}</div>
                                    <div class="stat-label">${escapeHtml(name)}</div>
                                </div>
                            </div>
                        </div>
                    `);
                }
                
                // Add click handlers
                $(`.stat-card[data-type="${type}"]`).on('click', function() {
                    const filterType = $(this).data('type');
                    const filterValue = $(this).data('value');
                    
                    // Set as active filter
                    setStatFilter(filterType, filterValue);
                });
            }
            
            // Set statistic filter
            function setStatFilter(type, value) {
                // Clear other stat filters
                $('.stat-card').removeClass('active');
                $(`.stat-card[data-type="${type}"][data-value="${value}"]`).addClass('active');
                
                // Set the filter
                const colIndex = appData.columnMap[type];
                if (colIndex !== undefined && colIndex !== false) {
                    activeStatFilter = { type, index: colIndex, value: value };
                    
                    // Reset other filters
                    currentFilters = {};
                    $('.filter-select').val('');
                    $('#globalSearch').val('');
                    currentSearch = '';
                    
                    // Set the stat filter
                    currentFilters[colIndex] = value.toLowerCase();
                    filterData();
                    
                    // Update active filters display
                    updateActiveFilters();
                }
            }
            
            // Update active filters display
            function updateActiveFilters() {
                const activeFiltersContainer = $('#activeFilters');
                activeFiltersContainer.empty();
                
                if (activeStatFilter) {
                    const filterName = appData.headers[activeStatFilter.index];
                    activeFiltersContainer.append(`
                        <div class="d-flex align-items-center">
                            <span class="me-2">Active filter:</span>
                            <span class="badge bg-primary">
                                ${filterName}: ${activeStatFilter.value}
                                <i class="bi bi-x-circle ms-2" onclick="clearStatFilter()"></i>
                            </span>
                        </div>
                    `);
                }
            }
            
            // Clear statistic filter
            window.clearStatFilter = function() {
                activeStatFilter = null;
                $('.stat-card').removeClass('active');
                currentFilters = {};
                filterData();
                updateActiveFilters();
                $('#resultCount').text('No filters applied');
            };
            
            // Render table rows
            function renderTableRows(rows) {
                let rowsHtml = '';
                rows.forEach(row => {
                    rowsHtml += '<tr>';
                    row.forEach(cell => {
                        rowsHtml += `<td>${escapeHtml(cell)}</td>`;
                    });
                    rowsHtml += '</tr>';
                });
                $('#tableBody').html(rowsHtml);
            }
            
            // Escape HTML for safety
            function escapeHtml(unsafe) {
                return unsafe?.toString()
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;") || '';
            }
            
            // Filter data based on current filters and search
            function filterData() {
                $('#initialLoading').show();
                $('#emptyState').hide();
                $('#tableContainer').addClass('d-none');
                
                setTimeout(() => {
                    filteredData = appData.rows.filter(row => {
                        // Apply column filters
                        for (const index in currentFilters) {
                            const filterValue = currentFilters[index].toLowerCase();
                            const cellValue = row[index]?.toLowerCase() || '';
                            if (!cellValue.includes(filterValue)) {
                                return false;
                            }
                        }
                        
                        // Apply global search if specified
                        if (currentSearch) {
                            let found = false;
                            for (let i = 0; i < row.length; i++) {
                                const cellValue = row[i]?.toLowerCase() || '';
                                if (cellValue.includes(currentSearch)) {
                                    found = true;
                                    break;
                                }
                            }
                            if (!found) return false;
                        }
                        
                        return true;
                    });
                    
                    updateResultCount();
                    
                    if (filteredData.length > 0) {
                        renderTableRows(filteredData);
                        $('#tableContainer').removeClass('d-none');
                        $('#emptyState').hide();
                    } else {
                        $('#tableContainer').addClass('d-none');
                        $('#emptyState').show();
                    }
                    
                    $('#initialLoading').hide();
                }, 100);
            }
            
            // Update result count display
            function updateResultCount() {
                const totalRecords = appData.rows.length;
                const shownRecords = filteredData.length;
                
                let countText;
                if (Object.keys(currentFilters).length === 0 && !currentSearch) {
                    countText = 'No filters applied';
                } else if (shownRecords === totalRecords) {
                    countText = `Showing all ${totalRecords} records`;
                } else {
                    countText = `Showing ${shownRecords} of ${totalRecords} records`;
                    
                    // Add filter info if from stat click
                    if (activeStatFilter) {
                        const filterName = appData.headers[activeStatFilter.index];
                        countText += ` (Filtered by ${filterName}: ${activeStatFilter.value})`;
                    }
                }
                
                $('#resultCount').text(countText);
            }
            
            // Initialize the application
            function init() {
                initTableHeaders();
                initStatistics();
                $('#initialLoading').hide();
                
                // Show empty state initially
                $('#emptyState').show();
            }
            
            // Event handlers
            $('#applyFilters').on('click', function() {
                activeStatFilter = null;
                $('.stat-card').removeClass('active');
                updateActiveFilters();
                
                currentFilters = {};
                $('.filter-select').each(function() {
                    const index = $(this).data('index');
                    const value = $(this).val()?.toLowerCase() || '';
                    if (value) {
                        currentFilters[index] = value;
                    }
                });
                
                currentSearch = $('#globalSearch').val().toLowerCase();
                filterData();
            });
            
            $('#resetFilters').on('click', function() {
                clearStatFilter();
                $('.filter-select').val('');
                $('#globalSearch').val('');
                currentSearch = '';
                filterData();
            });
            
            // Allow Enter key to apply filters
            $('#globalSearch').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#applyFilters').click();
                }
            });
            
            // Initialize the app
            init();
            
            // Function untuk mencari tiket berdasarkan nomor internet
            $('#checkInetNumbers').on('click', function() {
                const inetNumbersText = $('#inetNumbers').val().trim();
                
                if (!inetNumbersText) {
                    alert('Masukkan nomor internet terlebih dahulu!');
                    return;
                }
                
                // Split input menjadi array dan bersihkan spasi
                const inetNumbers = inetNumbersText.split('\n')
                    .map(num => num.trim())
                    .filter(num => num !== '');
                
                if (inetNumbers.length === 0) {
                    alert('Tidak ada nomor internet yang valid!');
                    return;
                }
                
                // Cari tiket berdasarkan nomor internet
                const inetColIndex = appData.columnMap.inet;
                if (inetColIndex === undefined || inetColIndex === false) {
                    alert('Kolom NOMOR_INET tidak ditemukan dalam data!');
                    return;
                }
                
                // Cari semua tiket yang sesuai
                const foundTickets = {};
                notFoundNumbers = [];
                
                inetNumbers.forEach(num => {
                    const tickets = appData.rows.filter(row => 
                        row[inetColIndex] && row[inetColIndex].toString().trim() === num
                    );
                    
                    if (tickets.length > 0) {
                        foundTickets[num] = tickets;
                    } else {
                        notFoundNumbers.push(num);
                    }
                });
                
                // Tampilkan hasil
                displayInetResults(foundTickets, notFoundNumbers, inetNumbers.length);
            });
            
            // Function untuk menampilkan hasil pencarian
            function displayInetResults(foundTickets, notFoundNumbers, totalInput) {
                const accordion = $('#resultsAccordion');
                accordion.empty();
                
                // Hitung statistik
                const foundCount = Object.keys(foundTickets).length;
                const notFoundCount = notFoundNumbers.length;
                const totalTickets = Object.values(foundTickets).reduce((total, tickets) => total + tickets.length, 0);
                
                // Update summary text
                $('#summaryText').html(`
                    Dari <strong>${totalInput}</strong> nomor yang diperiksa:
                    <strong>${foundCount}</strong> nomor ditemukan dengan <strong>${totalTickets}</strong> tiket,
                    <strong>${notFoundCount}</strong> nomor tidak ditemukan.
                `);
                
                // Tampilkan tiket yang ditemukan
                let accordionIndex = 0;
                
                for (const [inetNum, tickets] of Object.entries(foundTickets)) {
                    const accordionId = `collapse${accordionIndex}`;
                    const headingId = `heading${accordionIndex}`;
                    
                    // Buat header accordion
                    accordion.append(`
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="${headingId}">
                                <button class="accordion-button ${accordionIndex > 0 ? 'collapsed' : ''}" type="button" data-bs-toggle="collapse" data-bs-target="#${accordionId}" aria-expanded="${accordionIndex === 0 ? 'true' : 'false'}" aria-controls="${accordionId}">
                                    <span class="badge bg-success me-2">${tickets.length} tiket</span> 
                                    ${inetNum}
                                </button>
                            </h2>
                            <div id="${accordionId}" class="accordion-collapse collapse ${accordionIndex === 0 ? 'show' : ''}" aria-labelledby="${headingId}" data-bs-parent="#resultsAccordion">
                                <div class="accordion-body">
                                    ${renderTickets(tickets)}
                                </div>
                            </div>
                        </div>
                    `);
                    
                    accordionIndex++;
                }
                
                // Tampilkan nomor yang tidak ditemukan
                if (notFoundNumbers.length > 0) {
                    $('#notFoundContainer').removeClass('d-none');
                    $('#notFoundList').html(
                        notFoundNumbers.map(num => 
                            `<div class="not-found-item">${num}</div>`
                        ).join('')
                    );
                } else {
                    $('#notFoundContainer').addClass('d-none');
                }
                
                // Tampilkan hasil
                $('#inetResults').removeClass('d-none');
                
                // Scroll ke hasil
                $('html, body').animate({
                    scrollTop: $('#inetResults').offset().top - 20
                }, 500);
            }
            
            // Function untuk merender tiket
            function renderTickets(tickets) {
                let ticketsHtml = '';
                
                tickets.forEach((ticket, index) => {
                    ticketsHtml += `
                        <div class="ticket-item mb-3">
                            <div class="ticket-header">
                                <h6 class="mb-0">Tiket #${index + 1}</h6>
                                <div>
                                    ${ticket[appData.columnMap.status] ? `<span class="badge bg-secondary ticket-badge">${ticket[appData.columnMap.status]}</span>` : ''}
                                    ${ticket[appData.columnMap.priority] ? `<span class="badge bg-warning ticket-badge">${ticket[appData.columnMap.priority]}</span>` : ''}
                                    ${ticket[appData.columnMap.type] ? `<span class="badge bg-info ticket-badge">${ticket[appData.columnMap.type]}</span>` : ''}
                                </div>
                            </div>
                            <div class="ticket-details">
                                ${appData.headers.map((header, colIndex) => {
                                    if (ticket[colIndex] && ticket[colIndex].toString().trim() !== '') {
                                        return `
                                            <div class="detail-item">
                                                <div class="detail-label">${header}</div>
                                                <div class="detail-value">${escapeHtml(ticket[colIndex])}</div>
                                            </div>
                                        `;
                                    }
                                    return '';
                                }).join('')}
                            </div>
                        </div>
                    `;
                });
                
                return ticketsHtml;
            }
            
            // Clear input button
            $('#clearInput').on('click', function() {
                $('#inetNumbers').val('');
                $('#inetResults').addClass('d-none');
                $('#notFoundContainer').addClass('d-none');
            });
            
            // Copy not found numbers to clipboard
            $('#copyNotFound').on('click', function() {
                if (notFoundNumbers.length > 0) {
                    const textToCopy = notFoundNumbers.join('\n');
                    navigator.clipboard.writeText(textToCopy).then(function() {
                        // Ubah teks tombol sementara
                        const originalText = $('#copyNotFound').html();
                        $('#copyNotFound').html('<i class="bi bi-check"></i> Tersalin!');
                        
                        setTimeout(function() {
                            $('#copyNotFound').html(originalText);
                        }, 2000);
                    }).catch(function(err) {
                        console.error('Could not copy text: ', err);
                        alert('Gagal menyalin teks ke clipboard');
                    });
                }
            });
        });
    </script>
</body>
</html>