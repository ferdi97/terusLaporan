<?php
// Konfigurasi pagination
$per_page = 50; // Jumlah item per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Pastikan tidak kurang dari 1

// Baca data dari file JSON dengan pagination
$data_teknisi = [];
$total_data = 0;

if (file_exists('data_teknisi.json')) {
    $lines = file('data_teknisi.json', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $total_data = count($lines);
    
    // Implementasi pencarian jika ada parameter search
    $search = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';
    
    if ($search !== '') {
        $filtered_lines = [];
        foreach ($lines as $line) {
            $data = json_decode($line, true);
            if (strpos(strtolower($data['nik']), $search) !== false || 
                strpos(strtolower($data['nama']), $search) !== false) {
                $filtered_lines[] = $line;
            }
        }
        $lines = $filtered_lines;
        $total_data = count($lines);
    }
    
    // Urutkan berdasarkan waktu terbaru
    usort($lines, function($a, $b) {
        $a_data = json_decode($a, true);
        $b_data = json_decode($b, true);
        return strtotime($b_data['waktu']) - strtotime($a_data['waktu']);
    });
    
    // Ambil data untuk halaman saat ini
    $offset = ($page - 1) * $per_page;
    $paginated_lines = array_slice($lines, $offset, $per_page);
    
    foreach ($paginated_lines as $line) {
        $data_teknisi[] = json_decode($line, true);
    }
}

// Fungsi untuk format waktu
function formatWaktu($waktu) {
    return date('d/m/Y H:i', strtotime($waktu));
}

// Hitung total halaman
$total_pages = ceil($total_data / $per_page);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Teknisi</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --gray-color: #95a5a6;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark-color);
            line-height: 1.6;
        }
        
        .header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header h1 {
            font-size: 1.5rem;
            font-weight: 500;
        }
        
        .back-btn {
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .back-btn:hover {
            background-color: rgba(255,255,255,0.1);
        }
        
        .container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            gap: 1rem;
        }
        
        .search-container {
            flex: 1;
            max-width: 400px;
            position: relative;
        }
        
        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
            font-size: 0.95rem;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="%2395a5a6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>');
            background-repeat: no-repeat;
            background-position: 0.75rem center;
            background-size: 1rem;
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        .data-info {
            font-size: 0.9rem;
            color: var(--gray-color);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-radius: 4px;
            overflow: hidden;
        }
        
        thead {
            background-color: var(--primary-color);
            color: white;
        }
        
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            font-weight: 500;
            position: sticky;
            top: 0;
        }
        
        tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .photo-cell {
            width: 100px;
        }
        
        .teknisi-photo {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
            background-color: #f0f0f0;
        }
        
        .map-link {
            color: var(--accent-color);
            text-decoration: none;
            cursor: pointer;
        }
        
        .map-link:hover {
            text-decoration: underline;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
            gap: 0.5rem;
        }
        
        .page-link {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: var(--dark-color);
            transition: all 0.3s;
        }
        
        .page-link:hover {
            background-color: #f8f9fa;
        }
        
        .page-link.active {
            background-color: var(--accent-color);
            color: white;
            border-color: var(--accent-color);
        }
        
        .page-link.disabled {
            color: var(--gray-color);
            pointer-events: none;
        }
        
        .action-btns {
            display: flex;
            gap: 0.5rem;
        }
        
        .action-btn {
            padding: 0.25rem 0.5rem;
            border: none;
            border-radius: 4px;
            background-color: #f0f0f0;
            color: var(--dark-color);
            cursor: pointer;
            font-size: 0.8rem;
            transition: background-color 0.3s;
        }
        
        .action-btn:hover {
            background-color: #e0e0e0;
        }
        
        .action-btn.view {
            background-color: var(--accent-color);
            color: white;
        }
        
        .action-btn.view:hover {
            background-color: #2980b9;
        }
        
        /* Modal untuk peta */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 8px;
            width: 80%;
            max-width: 800px;
            max-height: 80vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        .modal-header {
            padding: 1rem;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-title {
            font-size: 1.2rem;
            font-weight: 500;
        }
        
        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0 0.5rem;
        }
        
        .modal-body {
            padding: 1rem;
            flex: 1;
            overflow: auto;
        }
        
        #detailMap {
            height: 500px;
            width: 100%;
            border-radius: 4px;
        }
        
        /* Loading indicator */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(0,0,0,0.1);
            border-radius: 50%;
            border-top-color: var(--accent-color);
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Kembali
        </a>
        <h1>Data Teknisi Tersimpan</h1>
        <div style="width: 120px;"></div> <!-- Untuk balance layout -->
    </div>
    
    <div class="container">
        <div class="toolbar">
            <div class="search-container">
                <form method="GET" action="data_teknisi.php">
                    <input type="text" class="search-input" name="search" placeholder="Cari NIK atau Nama..." 
                           value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                </form>
            </div>
            <div class="data-info">
                Menampilkan <?php echo ($per_page * ($page - 1)) + 1; ?>-<?php echo min($per_page * $page, $total_data); ?> dari <?php echo number_format($total_data); ?> data
            </div>
        </div>
        
        <?php if (empty($data_teknisi)): ?>
            <div style="background-color: white; padding: 2rem; text-align: center; border-radius: 4px;">
                <h3 style="color: var(--gray-color); margin-bottom: 1rem;">Tidak ada data ditemukan</h3>
                <p style="color: var(--gray-color);">Silakan coba dengan kata kunci lain atau <a href="data_teknisi.php" style="color: var(--accent-color);">tampilkan semua data</a></p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>STO</th>
                        <th>Lokasi</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data_teknisi as $data): ?>
                        <tr>
                            <td class="photo-cell">
                                <img src="uploads/<?php echo htmlspecialchars($data['foto']); ?>" alt="Foto Teknisi" class="teknisi-photo">
                            </td>
                            <td><?php echo htmlspecialchars($data['nik']); ?></td>
                            <td><?php echo htmlspecialchars($data['nama']); ?></td>
                            <td><?php echo htmlspecialchars($data['sto']); ?></td>
                            <td>
                                <a href="#" class="map-link" 
                                   data-lat="<?php echo htmlspecialchars($data['latitude']); ?>" 
                                   data-lng="<?php echo htmlspecialchars($data['longitude']); ?>"
                                   data-nik="<?php echo htmlspecialchars($data['nik']); ?>">
                                    Lihat Peta
                                </a>
                            </td>
                            <td><?php echo formatWaktu($data['waktu']); ?></td>
                            <td>
                                <div class="action-btns">
                                    <button class="action-btn view" data-id="<?php echo htmlspecialchars($data['nik']); ?>">Detail</button>
                                    <button class="action-btn">Cetak</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>" class="page-link">Sebelumnya</a>
                <?php else: ?>
                    <span class="page-link disabled">Sebelumnya</span>
                <?php endif; ?>
                
                <?php 
                // Tampilkan pagination
                $start_page = max(1, $page - 2);
                $end_page = min($total_pages, $page + 2);
                
                if ($start_page > 1) {
                    echo '<a href="?page=1'.(isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '').'" class="page-link">1</a>';
                    if ($start_page > 2) {
                        echo '<span class="page-link disabled">...</span>';
                    }
                }
                
                for ($i = $start_page; $i <= $end_page; $i++) {
                    $active = $i == $page ? 'active' : '';
                    echo '<a href="?page='.$i.(isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '').'" class="page-link '.$active.'">'.$i.'</a>';
                }
                
                if ($end_page < $total_pages) {
                    if ($end_page < $total_pages - 1) {
                        echo '<span class="page-link disabled">...</span>';
                    }
                    echo '<a href="?page='.$total_pages.(isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '').'" class="page-link">'.$total_pages.'</a>';
                }
                ?>
                
                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>" class="page-link">Berikutnya</a>
                <?php else: ?>
                    <span class="page-link disabled">Berikutnya</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Modal untuk peta -->
    <div class="modal" id="mapModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Lokasi Teknisi - <span id="modalNik"></span></div>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div id="detailMap"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable dengan konfigurasi khusus
            $('table').DataTable({
                paging: false, // Nonaktifkan paging bawaan karena kita sudah buat custom
                searching: false, // Nonaktifkan search bawaan
                info: false, // Nonaktifkan info bawaan
                order: [[5, 'desc']], // Urutkan berdasarkan kolom waktu (desc)
                columnDefs: [
                    { orderable: false, targets: [0, 6] } // Kolom foto dan aksi tidak bisa diurutkan
                ],
                dom: 't', // Hanya tampilkan tabel saja
                language: {
                    emptyTable: "Tidak ada data tersedia"
                }
            });
            
            // Modal peta
            const mapModal = document.getElementById('mapModal');
            const modalClose = document.querySelector('.modal-close');
            let detailMap = null;
            let currentMarker = null;
            
            // Buka modal saat klik link peta
            document.querySelectorAll('.map-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const lat = parseFloat(this.getAttribute('data-lat'));
                    const lng = parseFloat(this.getAttribute('data-lng'));
                    const nik = this.getAttribute('data-nik');
                    
                    document.getElementById('modalNik').textContent = nik;
                    
                    // Inisialisasi peta jika belum ada
                    if (!detailMap) {
                        detailMap = L.map('detailMap').setView([lat, lng], 15);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(detailMap);
                    } else {
                        detailMap.setView([lat, lng], 15);
                    }
                    
                    // Hapus marker sebelumnya (jika ada)
                    if (currentMarker) {
                        detailMap.removeLayer(currentMarker);
                    }
                    
                    // Tambahkan marker baru
                    currentMarker = L.marker([lat, lng]).addTo(detailMap)
                        .bindPopup(`<b>Lokasi Teknisi</b><br>NIK: ${nik}<br>Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`)
                        .openPopup();
                    
                    // Tampilkan modal
                    mapModal.style.display = 'flex';
                });
            });
            
            // Tutup modal
            modalClose.addEventListener('click', function() {
                mapModal.style.display = 'none';
            });
            
            // Tutup modal saat klik di luar konten modal
            mapModal.addEventListener('click', function(e) {
                if (e.target === mapModal) {
                    mapModal.style.display = 'none';
                }
            });
            
            // Submit form search saat mengetik (dengan delay)
            let searchTimer;
            $('.search-input').on('keyup', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    $(this).closest('form').submit();
                }, 800);
            });
        });
    </script>
</body>
</html>