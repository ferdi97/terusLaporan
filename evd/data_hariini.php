<?php
// Fungsi untuk memeriksa apakah tanggal sama dengan hari ini
function isToday($date) {
    $today = date('Y-m-d');
    $inputDate = date('Y-m-d', strtotime($date));
    return $today == $inputDate;
}

// Baca data dari file JSON
$data_hariini = [];
$sto_groups = [];

if (file_exists('data_teknisi.json')) {
    $lines = file('data_teknisi.json', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        $data = json_decode($line, true);
        if (isToday($data['waktu'])) {
            $data_hariini[] = $data;
            
            // Kelompokkan berdasarkan STO
            $sto = $data['sto'];
            if (!isset($sto_groups[$sto])) {
                $sto_groups[$sto] = [];
            }
            $sto_groups[$sto][] = $data;
        }
    }
    
    // Urutkan STO berdasarkan abjad
    ksort($sto_groups);
}

// Fungsi untuk format waktu
function formatWaktu($waktu) {
    return date('H:i', strtotime($waktu));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Teknisi Hari Ini</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
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
            position: relative;
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
            font-size: 1rem;
            display: flex;
            align-items: center;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }
        
        .info-bar {
            background-color: white;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .total-count {
            font-size: 1.1rem;
            font-weight: 500;
        }
        
        .total-count span {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .date-info {
            font-size: 0.9rem;
            color: var(--gray-color);
        }
        
        .sto-section {
            margin-bottom: 2rem;
        }
        
        .sto-header {
            background-color: var(--secondary-color);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 8px 8px 0 0;
            font-size: 1.1rem;
            font-weight: 500;
            display: flex;
            justify-content: space-between;
        }
        
        .sto-count {
            background-color: white;
            color: var(--secondary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .teknisi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
            background-color: white;
            padding: 1rem;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .teknisi-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 1rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .teknisi-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .teknisi-photo {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 0.75rem;
            background-color: #f0f0f0;
        }
        
        .teknisi-info {
            margin-bottom: 0.5rem;
        }
        
        .info-label {
            font-size: 0.8rem;
            color: var(--gray-color);
        }
        
        .info-value {
            font-weight: 500;
            margin-top: 0.25rem;
        }
        
        .teknisi-time {
            font-size: 0.8rem;
            color: var(--gray-color);
            text-align: right;
        }
        
        .no-data {
            text-align: center;
            padding: 2rem;
            grid-column: 1 / -1;
            color: var(--gray-color);
        }
        
        .footer {
            text-align: center;
            padding: 1rem;
            font-size: 0.8rem;
            color: var(--gray-color);
            margin-top: 2rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .teknisi-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
            
            .info-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .teknisi-grid {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 1.3rem;
                padding: 0 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php" class="back-btn">← Kembali</a>
        <h1>Data Teknisi Hari Ini</h1>
    </div>
    
    <div class="container">
        <div class="info-bar">
            <div class="total-count">
                Total Data: <span><?php echo count($data_hariini); ?></span> Teknisi
            </div>
            <div class="date-info">
                <?php echo date('d F Y'); ?>
            </div>
        </div>
        
        <?php if (empty($sto_groups)): ?>
            <div class="no-data">
                <h3>Belum ada data teknisi hari ini</h3>
                <p>Data yang diinput hari ini akan muncul di halaman ini</p>
            </div>
        <?php else: ?>
            <?php foreach ($sto_groups as $sto => $teknisi_list): ?>
                <div class="sto-section">
                    <div class="sto-header">
                        <span><?php echo htmlspecialchars($sto); ?></span>
                        <span class="sto-count"><?php echo count($teknisi_list); ?></span>
                    </div>
                    <div class="teknisi-grid">
                        <?php foreach ($teknisi_list as $teknisi): ?>
                            <div class="teknisi-card">
                                <img src="uploads/<?php echo htmlspecialchars($teknisi['foto']); ?>" alt="Foto Teknisi" class="teknisi-photo">
                                
                                <div class="teknisi-info">
                                    <div class="info-label">NIK</div>
                                    <div class="info-value"><?php echo htmlspecialchars($teknisi['nik']); ?></div>
                                </div>
                                
                                <div class="teknisi-info">
                                    <div class="info-label">Nama Teknisi</div>
                                    <div class="info-value"><?php echo htmlspecialchars($teknisi['nama']); ?></div>
                                </div>
                                
                                <div class="teknisi-info">
                                    <div class="info-label">Lokasi</div>
                                    <div class="info-value">
                                        <?php echo round($teknisi['latitude'], 4); ?>, <?php echo round($teknisi['longitude'], 4); ?>
                                    </div>
                                </div>
                                
                                <div class="teknisi-time">
                                    <?php echo formatWaktu($teknisi['waktu']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <div class="footer">
        Aplikasi Teknisi Lapangan &copy; <?php echo date('Y'); ?>
    </div>
</body>
</html>