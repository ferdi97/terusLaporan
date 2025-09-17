<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Nomor INET</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .card {
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
            border: none;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
        }
        
        .search-area {
            background-color: white;
            padding: 25px;
            border-radius: 12px;
        }
        
        .result-area {
            display: none;
            margin-top: 30px;
        }
        
        .stats-card {
            text-align: center;
            padding: 15px;
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--secondary);
        }
        
        .inet-card {
            border-left: 4px solid var(--secondary);
        }
        
        .status-resolved {
            border-left: 4px solid #28a745;
        }
        
        .status-pending {
            border-left: 4px solid #ffc107;
        }
        
        .status-closed {
            border-left: 4px solid #6c757d;
        }
        
        .btn-primary {
            background-color: var(--secondary);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: var(--primary);
            transform: translateY(-2px);
        }
        
        .search-icon {
            position: absolute;
            right: 15px;
            top: 12px;
            color: #6c757d;
        }
        
        .ticket-id {
            font-weight: bold;
            color: var(--dark);
        }
        
        .pagination {
            margin-top: 20px;
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 30px;
        }
        
        .spinner {
            width: 3rem;
            height: 3rem;
        }
        
        .highlight {
            background-color: #fff8e1;
            padding: 2px 5px;
            border-radius: 3px;
        }
        
        .api-config {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid var(--accent);
        }
        
        @media (max-width: 768px) {
            .stats-number {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-search me-3"></i>Pencarian Nomor INET</h1>
                    <p class="lead">Temukan detail tiket untuk nomor INET dengan mudah</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="badge bg-light text-dark">Data dari Google Sheets</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="api-config">
            <h5><i class="fas fa-key me-2"></i>Konfigurasi API</h5>
            <p class="text-muted">Masukkan API Key dan ID Spreadsheet Anda</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="apiKey" class="form-label">Google Sheets API Key</label>
                        <input type="password" class="form-control" id="apiKey" placeholder="Masukkan API Key">
                        <small class="form-text text-muted">Dapatkan dari Google Cloud Console</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="sheetId" class="form-label">Spreadsheet ID</label>
                        <input type="text" class="form-control" id="sheetId" value="1Iox7B43LcP_Am7XivUx9u-GJ6qT1BGoQpNGx1QDs28U">
                        <small class="form-text text-muted">ID dari URL Google Sheets</small>
                    </div>
                </div>
            </div>
            <button class="btn btn-outline-primary" id="saveConfig">
                <i class="fas fa-save me-2"></i>Simpan Konfigurasi
            </button>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card search-area">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-list-ol me-2"></i>Masukkan Nomor INET</h5>
                        <p class="text-muted">Anda dapat memasukkan hingga 1000 nomor INET, pisahkan dengan koma atau baris baru</p>
                        
                        <div class="form-group mb-3">
                            <textarea class="form-control" id="inetNumbers" rows="5" placeholder="Contoh: 123456789, 987654321, 112233445"></textarea>
                            <small class="form-text text-muted">Tekan Enter setelah setiap nomor atau pisahkan dengan koma</small>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button class="btn btn-primary" id="searchBtn">
                                    <i class="fas fa-search me-2"></i>Cari Nomor INET
                                </button>
                                <button class="btn btn-outline-secondary" id="clearBtn">
                                    <i class="fas fa-eraser me-2"></i>Bersihkan
                                </button>
                            </div>
                            <span class="badge bg-info" id="countBadge">0 nomor terdeteksi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="loading" id="loading">
            <div class="spinner-border text-primary spinner" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Sedang mencari data, harap tunggu...</p>
        </div>

        <div class="result-area" id="resultArea">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="mb-4">Hasil Pencarian</h3>
                </div>
            </div>
            
            <div class="row" id="statsRow">
                <div class="col-md-3">
                    <div class="card stats-card">
                        <h6>Total Nomor Dicari</h6>
                        <div class="stats-number" id="totalSearched">0</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card">
                        <h6>Nomor Ditemukan</h6>
                        <div class="stats-number" id="totalFound">0</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card">
                        <h6>Tiket Resolved</h6>
                        <div class="stats-number" id="totalResolved">0</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card">
                        <h6>Tiket Pending</h6>
                        <div class="stats-number" id="totalPending">0</div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Detail Tiket</h5>
                        <div class="d-flex">
                            <input type="text" class="form-control me-2" id="detailSearch" placeholder="Cari di hasil...">
                            <select class="form-select" id="statusFilter">
                                <option value="all">Semua Status</option>
                                <option value="resolved">Resolved</option>
                                <option value="pending">Pending</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="inetResults"></div>
                    
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center" id="pagination"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inetNumbers = document.getElementById('inetNumbers');
            const searchBtn = document.getElementById('searchBtn');
            const clearBtn = document.getElementById('clearBtn');
            const countBadge = document.getElementById('countBadge');
            const loading = document.getElementById('loading');
            const resultArea = document.getElementById('resultArea');
            const inetResults = document.getElementById('inetResults');
            const pagination = document.getElementById('pagination');
            const detailSearch = document.getElementById('detailSearch');
            const statusFilter = document.getElementById('statusFilter');
            const apiKeyInput = document.getElementById('apiKey');
            const sheetIdInput = document.getElementById('sheetId');
            const saveConfigBtn = document.getElementById('saveConfig');
            
            let allData = [];
            let currentPage = 1;
            const itemsPerPage = 5;
            let filteredData = [];
            let apiKey = '';
            let sheetId = '1Iox7B43LcP_Am7XivUx9u-GJ6qT1BGoQpNGx1QDs28U';
            
            // Load saved configuration
            if (localStorage.getItem('apiKey')) {
                apiKeyInput.value = localStorage.getItem('apiKey');
                apiKey = localStorage.getItem('apiKey');
            }
            
            if (localStorage.getItem('sheetId')) {
                sheetIdInput.value = localStorage.getItem('sheetId');
                sheetId = localStorage.getItem('sheetId');
            }
            
            // Save configuration
            saveConfigBtn.addEventListener('click', function() {
                apiKey = apiKeyInput.value;
                sheetId = sheetIdInput.value;
                
                localStorage.setItem('apiKey', apiKey);
                localStorage.setItem('sheetId', sheetId);
                
                alert('Konfigurasi berhasil disimpan!');
            });
            
            // Count numbers in textarea
            inetNumbers.addEventListener('input', function() {
                const numbers = parseInput(inetNumbers.value);
                countBadge.textContent = numbers.length + ' nomor terdeteksi';
            });
            
            // Clear button
            clearBtn.addEventListener('click', function() {
                inetNumbers.value = '';
                countBadge.textContent = '0 nomor terdeteksi';
                resultArea.style.display = 'none';
            });
            
            // Search button
            searchBtn.addEventListener('click', function() {
                const numbers = parseInput(inetNumbers.value);
                if (numbers.length === 0) {
                    alert('Masukkan minimal satu nomor INET');
                    return;
                }
                
                if (numbers.length > 1000) {
                    alert('Maksimal 1000 nomor yang dapat dicari sekaligus');
                    return;
                }
                
                if (!apiKey) {
                    alert('Silakan masukkan API Key terlebih dahulu');
                    return;
                }
                
                loading.style.display = 'block';
                resultArea.style.display = 'none';
                
                // Load data from Google Sheets and search
                loadDataFromSheets()
                    .then(() => {
                        searchInetNumbers(numbers);
                        loading.style.display = 'none';
                        resultArea.style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loading.style.display = 'none';
                        alert('Gagal memuat data dari Google Sheets. Pastikan API Key dan Sheet ID benar, serta sheet telah dibagikan secara publik.');
                    });
            });
            
            // Filter functionality
            detailSearch.addEventListener('input', filterResults);
            statusFilter.addEventListener('change', filterResults);
            
            function parseInput(input) {
                // Split by new lines or commas and trim each element
                return input.split(/[\n,]+/)
                    .map(num => num.trim())
                    .filter(num => num !== '');
            }
            
            async function loadDataFromSheets() {
                // If we've already loaded the data, don't load it again
                if (allData.length > 0) return;
                
                try {
                    // Fetch data from Google Sheets API
                    const response = await fetch(`https://sheets.googleapis.com/v4/spreadsheets/${sheetId}/values/Sheet1?key=${apiKey}`);
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    const rows = data.values;
                    
                    if (!rows || rows.length === 0) {
                        throw new Error('Tidak ada data yang ditemukan di sheet');
                    }
                    
                    // Skip header row and map to objects
                    allData = rows.slice(1).map((row, index) => {
                        return {
                            no: index + 1,
                            inet: row[22] || '',
                            ticket: row[1] || '',
                            status: row[2] || '',
                            date: row[3] || '',
                            description: row[4] || ''
                        };
                    });
                } catch (error) {
                    console.error('Error loading data from Sheets:', error);
                    throw error;
                }
            }
            
            function searchInetNumbers(numbers) {
                const results = [];
                numbers.forEach(num => {
                    const found = allData.find(item => item.inet === num);
                    if (found) {
                        results.push(found);
                    } else {
                        results.push({ 
                            inet: num, 
                            ticket: "Not Found", 
                            status: "not-found", 
                            date: "N/A", 
                            description: "Nomor INET tidak ditemukan dalam database" 
                        });
                    }
                });
                
                // Update stats
                document.getElementById('totalSearched').textContent = numbers.length;
                document.getElementById('totalFound').textContent = results.filter(r => r.ticket !== "Not Found").length;
                document.getElementById('totalResolved').textContent = results.filter(r => r.status === "resolved").length;
                document.getElementById('totalPending').textContent = results.filter(r => r.status === "pending").length;
                
                filteredData = [...results];
                currentPage = 1;
                renderResults();
                renderPagination();
            }
            
            function renderResults() {
                const startIndex = (currentPage - 1) * itemsPerPage;
                const endIndex = startIndex + itemsPerPage;
                const pageData = filteredData.slice(startIndex, endIndex);
                
                inetResults.innerHTML = '';
                
                if (pageData.length === 0) {
                    inetResults.innerHTML = `
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Tidak ada data yang sesuai dengan filter
                        </div>
                    `;
                    return;
                }
                
                pageData.forEach(item => {
                    let statusClass = '';
                    let statusText = '';
                    
                    switch(item.status.toLowerCase()) {
                        case 'resolved':
                            statusClass = 'status-resolved';
                            statusText = '<span class="badge bg-success">Resolved</span>';
                            break;
                        case 'pending':
                            statusClass = 'status-pending';
                            statusText = '<span class="badge bg-warning text-dark">Pending</span>';
                            break;
                        case 'closed':
                            statusClass = 'status-closed';
                            statusText = '<span class="badge bg-secondary">Closed</span>';
                            break;
                        default:
                            statusClass = '';
                            statusText = '<span class="badge bg-danger">Not Found</span>';
                    }
                    
                    inetResults.innerHTML += `
                        <div class="card mb-3 ${statusClass}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h6 class="card-title">Nomor INET</h6>
                                        <p class="ticket-id">${item.inet}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <h6 class="card-title">Tiket</h6>
                                        <p>${item.ticket}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <h6 class="card-title">Status</h6>
                                        <p>${statusText}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <h6 class="card-title">Tanggal</h6>
                                        <p>${item.date}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 class="card-title">Deskripsi</h6>
                                        <p>${item.description}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }
            
            function renderPagination() {
                const totalPages = Math.ceil(filteredData.length / itemsPerPage);
                
                pagination.innerHTML = '';
                
                if (totalPages <= 1) return;
                
                // Previous button
                pagination.innerHTML += `
                    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>
                    </li>
                `;
                
                // Page numbers
                for (let i = 1; i <= totalPages; i++) {
                    pagination.innerHTML += `
                        <li class="page-item ${currentPage === i ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `;
                }
                
                // Next button
                pagination.innerHTML += `
                    <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
                    </li>
                `;
                
                // Add event listeners to page links
                document.querySelectorAll('.page-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        currentPage = parseInt(this.getAttribute('data-page'));
                        renderResults();
                        renderPagination();
                    });
                });
            }
            
            function filterResults() {
                const searchTerm = detailSearch.value.toLowerCase();
                const statusValue = statusFilter.value;
                
                // Get the original search results (before any filtering)
                const numbers = parseInput(inetNumbers.value);
                const originalResults = [];
                numbers.forEach(num => {
                    const found = allData.find(item => item.inet === num);
                    if (found) {
                        originalResults.push(found);
                    } else {
                        originalResults.push({ 
                            inet: num, 
                            ticket: "Not Found", 
                            status: "not-found", 
                            date: "N/A", 
                            description: "Nomor INET tidak ditemukan dalam database" 
                        });
                    }
                });
                
                // Apply filters
                filteredData = originalResults.filter(item => {
                    const matchesSearch = item.inet.toLowerCase().includes(searchTerm) || 
                                         item.ticket.toLowerCase().includes(searchTerm) ||
                                         item.description.toLowerCase().includes(searchTerm);
                    
                    const matchesStatus = statusValue === 'all' || item.status.toLowerCase() === statusValue;
                    
                    return matchesSearch && matchesStatus;
                });
                
                currentPage = 1;
                renderResults();
                renderPagination();
            }
        });
    </script>
</body>
</html>