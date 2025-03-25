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

// Prepare filter options
$filterOptions = array_fill(0, count($headers), []);

foreach ($rows as $row) {
    foreach ($headers as $index => $header) {
        if (isset($row[$index])) {
            $value = trim($row[$index]);
            if ($value !== "" && !in_array($value, $filterOptions[$index])) {
                $filterOptions[$index][] = $value;
            }
        }
    }
}

// Sort filter options
foreach ($filterOptions as &$options) {
    sort($options);
}

// Store data in JSON format for JavaScript
$jsonData = json_encode([
    'headers' => $headers,
    'rows' => $rows,
    'filterOptions' => $filterOptions
]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Report | Optimized Viewer</title>
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
        }
        
        .card-header {
            background-color: var(--header-color);
            color: white;
            padding: 12px 20px;
            border-radius: 8px 8px 0 0 !important;
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
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Report</h5>
                <small class="text-light">Last updated: <?php echo date('d M Y H:i'); ?></small>
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
                    <p>Apply filters or search to view data</p>
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
                }
                
                $('#resultCount').text(countText);
            }
            
            // Initialize the application
            function init() {
                initTableHeaders();
                $('#initialLoading').hide();
                
                // Show empty state initially
                $('#emptyState').show();
            }
            
            // Event handlers
            $('#applyFilters').on('click', function() {
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
            
            // Allow Enter key to apply filters
            $('#globalSearch').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#applyFilters').click();
                }
            });
            
            // Initialize the app
            init();
        });
    </script>
</body>
</html>