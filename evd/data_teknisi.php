<?php
// Baca data dari file JSON
$data_teknisi = [];
if (file_exists('data_teknisi.json')) {
    $lines = file('data_teknisi.json', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $data_teknisi[] = json_decode($line, true);
    }
    
    // Urutkan berdasarkan waktu terbaru
    usort($data_teknisi, function($a, $b) {
        return strtotime($b['waktu']) - strtotime($a['waktu']);
    });
}

// Fungsi untuk format waktu
function formatWaktu($waktu) {
    return date('d/m/Y H:i', strtotime($waktu));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Teknisi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: var(--dark-color);
            line-height: 1.6;
            padding: 0;
            margin: 0;
        }
        
        .header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header h1 {
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .back-btn {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }
        
        .card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 1.5rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-title {
            font-size: 1.1rem;
            font-weight: 500;
        }
        
        .card-time {
            font-size: 0.85rem;
            opacity: 0.9;
        }
        
        .card-body {
            padding: 1rem;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 1rem;
        }
        
        .teknisi-photo {
            width: 100%;
            border-radius: 8px;
            aspect-ratio: 3/4;
            object-fit: cover;
            background-color: #f0f0f0;
        }
        
        .teknisi-info {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .info-row {
            display: flex;
            gap: 0.5rem;
        }
        
        .info-label {
            font-weight: 500;
            min-width: 100px;
            color: var(--gray-color);
        }
        
        .info-value {
            flex: 1;
        }
        
        .map-mini {
            height: 200px;
            width: 100%;
            border-radius: 8px;
            margin-top: 0.5rem;
        }
        
        .no-data {
            text-align: center;
            padding: 2rem;
            color: var(--gray-color);
        }
        
        .search-container {
            margin-bottom: 1.5rem;
            display: flex;
            gap: 0.5rem;
        }
        
        .search-input {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.95rem;
        }
        
        .search-btn {
            padding: 0 1.5rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: inherit;
            font-weight: 500;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                grid-template-columns: 1fr;
            }
            
            .teknisi-photo {
                max-width: 250px;
                margin: 0 auto;
            }
            
            .info-row {
                flex-direction: column;
                gap: 0.25rem;
            }
            
            .info-label {
                min-width: auto;
            }
        }
        
        @media (max-width: 480px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }
            
            .card-time {
                font-size: 0.75rem;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .card {
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 0;
        }
        
        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.4s; }
        .card:nth-child(5) { animation-delay: 0.5s; }
        .card:nth-child(n+6) { animation-delay: 0.6s; }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php" class="back-btn">← Kembali</a>
        <h1>Data Teknisi Tersimpan</h1>
    </div>
    
    <div class="container">
        <div class="search-container">
            <input type="text" class="search-input" id="searchInput" placeholder="Cari berdasarkan NIK atau Nama...">
            <button class="search-btn" id="searchBtn">Cari</button>
        </div>
        
        <?php if (empty($data_teknisi)): ?>
            <div class="no-data">
                <h3>Belum ada data teknisi yang tersimpan</h3>
                <p>Silakan isi form di halaman utama untuk menambahkan data</p>
            </div>
        <?php else: ?>
            <div id="teknisiList">
                <?php foreach ($data_teknisi as $data): ?>
                    <div class="card" data-nik="<?php echo htmlspecialchars($data['nik']); ?>" data-nama="<?php echo htmlspecialchars($data['nama']); ?>">
                        <div class="card-header">
                            <div class="card-title"><?php echo htmlspecialchars($data['nama']); ?></div>
                            <div class="card-time"><?php echo formatWaktu($data['waktu']); ?></div>
                        </div>
                        <div class="card-body">
                            <div>
                                <img src="uploads/<?php echo htmlspecialchars($data['foto']); ?>" alt="Foto Teknisi" class="teknisi-photo">
                            </div>
                            <div class="teknisi-info">
                                <div class="info-row">
                                    <span class="info-label">NIK:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($data['nik']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Nama:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($data['nama']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">STO:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($data['sto']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Lokasi:</span>
                                    <span class="info-value">
                                        <?php echo htmlspecialchars($data['latitude']); ?>, <?php echo htmlspecialchars($data['longitude']); ?>
                                    </span>
                                </div>
                                <div class="info-row">
                                    <div id="map-<?php echo htmlspecialchars($data['nik']); ?>" class="map-mini"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi peta mini untuk setiap teknisi
            <?php foreach ($data_teknisi as $data): ?>
                const map<?php echo htmlspecialchars($data['nik']); ?> = L.map('map-<?php echo htmlspecialchars($data['nik']); ?>').setView([
                    <?php echo htmlspecialchars($data['latitude']); ?>, 
                    <?php echo htmlspecialchars($data['longitude']); ?>
                ], 15);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map<?php echo htmlspecialchars($data['nik']); ?>);
                
                L.marker([
                    <?php echo htmlspecialchars($data['latitude']); ?>, 
                    <?php echo htmlspecialchars($data['longitude']); ?>
                ]).addTo(map<?php echo htmlspecialchars($data['nik']); ?>);
            <?php endforeach; ?>
            
            // Fungsi pencarian
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');
            const teknisiCards = document.querySelectorAll('.card');
            
            function filterData() {
                const searchTerm = searchInput.value.toLowerCase();
                
                teknisiCards.forEach(card => {
                    const nik = card.getAttribute('data-nik').toLowerCase();
                    const nama = card.getAttribute('data-nama').toLowerCase();
                    
                    if (nik.includes(searchTerm) || nama.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }
            
            searchBtn.addEventListener('click', filterData);
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    filterData();
                }
            });
        });
    </script>
</body>
</html>