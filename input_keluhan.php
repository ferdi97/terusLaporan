<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['level'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'config.php';
    
    // Generate ticket number
    $kd_tiket = 'IND' . date('Ymd') . strtoupper(substr(uniqid(), -6));
    
    // Prepare data
    $no_internet = $_POST['no_internet'];
    $nama_pelapor = $_POST['nama_pelapor'];
    $no_hp_pelapor = $_POST['no_hp_pelapor'];
    $alamat_lengkap = $_POST['jalan'] . '|' . $_POST['rt_rw'] . '|' . $_POST['kelurahan'] . '|' . $_POST['kecamatan'] . '|' . $_POST['kota_kabupaten'];
    $keluhan = $_POST['keluhan'];
    $share_location = $_POST['share_location'];
    $tanggal_keluhan = date('Y-m-d H:i:s');
    
    // Insert to database
    $stmt = $conn->prepare("INSERT INTO keluhan (kd_tiket, no_internet, nama_pelapor, no_hp_pelapor, alamat_lengkap, keluhan, share_location, tanggal_keluhan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $kd_tiket, $no_internet, $nama_pelapor, $no_hp_pelapor, $alamat_lengkap, $keluhan, $share_location, $tanggal_keluhan);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Keluhan berhasil ditambahkan dengan nomor tiket: $kd_tiket";
        header("Location: keluhan.php");
        exit();
    } else {
        $error = "Gagal menambahkan keluhan: " . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Keluhan - Sistem Laporan Gangguan IndiHome</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
         :root {
            --primary: #E30613;
            --primary-dark: #C10511;
            --primary-light: #ffcdd2;
            --secondary: #2D3748;
            --accent: #F6AD55;
            --light: #F7FAFC;
            --dark: #1A202C;
            --gray: #E2E8F0;
            --gray-dark: #CBD5E0;
            --success: #48BB78;
            --warning: #ED8936;
            --error: #F56565;
            --border-radius: 12px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: var(--dark);
            line-height: 1.6;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 20px 0;
            transition: var(--transition);
        }

        .logo {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .logo img {
            height: 40px;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: var(--transition);
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #f5f7fa;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--gray);
        }

        .page-title h1 {
            font-size: 24px;
            color: var(--primary);
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        .user-dropdown {
            position: relative;
            cursor: pointer;
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 50px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            width: 200px;
            padding: 10px 0;
            z-index: 100;
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            padding: 10px 20px;
            color: var(--dark);
            text-decoration: none;
            display: block;
        }

        .dropdown-item:hover {
            background: var(--gray);
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--box-shadow);
            display: flex;
            align-items: center;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-size: 24px;
        }

        .stat-icon.total {
            background: rgba(72, 187, 120, 0.1);
            color: var(--success);
        }

        .stat-icon.today {
            background: rgba(237, 137, 54, 0.1);
            color: var(--warning);
        }

        .stat-icon.month {
            background: rgba(101, 163, 245, 0.1);
            color: #65a3f5;
        }

        .stat-info h3 {
            font-size: 14px;
            color: var(--secondary);
            margin-bottom: 5px;
        }

        .stat-info h2 {
            font-size: 24px;
            color: var(--dark);
        }

        /* Data Table */
        .data-table-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
            margin-top: 20px;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-title {
            font-size: 18px;
            color: var(--primary);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            font-size: 14px;
            text-decoration: none;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(227, 6, 19, 0.2);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: rgba(227, 6, 19, 0.05);
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                padding: 15px;
            }

            .nav-menu {
                display: flex;
                overflow-x: auto;
                padding-bottom: 10px;
            }

            .nav-item {
                margin-right: 10px;
                margin-bottom: 0;
                white-space: nowrap;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar (sama seperti dashboard.php) -->
        <?php include 'sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="page-title">
                    <h1>Input Keluhan Baru</h1>
                </div>
                
                <div class="user-info">
                    <div class="user-dropdown" id="userDropdown">
                        <div style="display: flex; align-items: center;">
                            <img src="img/user-avatar.png" alt="User Avatar">
                            <span><?php echo $_SESSION['username']; ?> (<?php echo ucfirst($_SESSION['level']); ?>)</span>
                            <i class="fas fa-chevron-down" style="margin-left: 10px;"></i>
                        </div>
                        
                        <div class="dropdown-menu" id="dropdownMenu">
                            <a href="profile.php" class="dropdown-item">
                                <i class="fas fa-user"></i> Profile
                            </a>
                            <a href="logout.php" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Input Keluhan -->
            <div class="form-container">
                <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>
                
                <form action="input_keluhan.php" method="POST">
                    <div class="form-section">
                        <h3 style="margin-bottom: 20px; color: var(--primary);">Informasi Pelanggan</h3>
                        
                        <div class="float-label">
                            <input type="text" id="no_internet" name="no_internet" placeholder=" " required pattern="^(05\d{7,8}|16\d{10,11})$" title="Nomor Internet harus diawali dengan 05 (9-10 digit) atau 16 (12-13 digit)">
                            <label for="no_internet">Nomor Internet</label>
                            <div class="error-message" id="no_internet-error">Format nomor internet tidak valid</div>
                        </div>

                        <div class="float-label">
                            <input type="text" id="nama_pelapor" name="nama_pelapor" placeholder=" " required minlength="3">
                            <label for="nama_pelapor">Nama Lengkap</label>
                            <div class="error-message" id="nama_pelapor-error">Nama harus minimal 3 karakter</div>
                        </div>

                        <div class="float-label">
                            <input type="tel" id="no_hp_pelapor" name="no_hp_pelapor" placeholder=" " required pattern="^[0-9]{10,13}$" title="Nomor HP harus 10-13 digit angka">
                            <label for="no_hp_pelapor">Nomor HP</label>
                            <div class="error-message" id="no_hp_pelapor-error">Nomor HP harus 10-13 digit angka</div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3 style="margin-bottom: 20px; color: var(--primary);">Alamat</h3>
                        
                        <div class="float-label">
                            <input type="text" id="jalan" name="jalan" placeholder=" " required>
                            <label for="jalan">Jalan</label>
                            <div class="error-message" id="jalan-error">Mohon isi nama jalan</div>
                        </div>

                        <div class="float-label">
                            <input type="text" id="rt_rw" name="rt_rw" placeholder=" " required pattern="^\d{1,3}/\d{1,3}$" title="Format RT/RW (contoh: 001/002)">
                            <label for="rt_rw">RT/RW</label>
                            <div class="error-message" id="rt_rw-error">Format RT/RW tidak valid (contoh: 001/002)</div>
                        </div>

                        <div class="float-label">
                            <input type="text" id="kelurahan" name="kelurahan" placeholder=" " required>
                            <label for="kelurahan">Kelurahan</label>
                            <div class="error-message" id="kelurahan-error">Mohon isi nama kelurahan</div>
                        </div>

                        <div class="float-label">
                            <input type="text" id="kecamatan" name="kecamatan" placeholder=" " required>
                            <label for="kecamatan">Kecamatan</label>
                            <div class="error-message" id="kecamatan-error">Mohon isi nama kecamatan</div>
                        </div>

                        <div class="float-label">
                            <input type="text" id="kota_kabupaten" name="kota_kabupaten" placeholder=" " required>
                            <label for="kota_kabupaten">Kota/Kabupaten</label>
                            <div class="error-message" id="kota_kabupaten-error">Mohon isi nama kota/kabupaten</div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3 style="margin-bottom: 20px; color: var(--primary);">Keluhan</h3>
                        
                        <div class="float-label">
                            <textarea id="keluhan" name="keluhan" placeholder=" " required minlength="3"></textarea>
                            <label for="keluhan">Deskripsi Keluhan</label>
                            <div class="error-message" id="keluhan-error">Deskripsi keluhan minimal 3 karakter</div>
                        </div>

                        <div class="form-group">
                            <button type="button" id="shareButton" class="btn btn-secondary">
                                <i class="fas fa-location-arrow"></i> Deteksi Lokasi
                            </button>
                            <input type="hidden" id="share_location" name="share_location" required>
                            <div class="error-message" id="location-error">Mohon tentukan lokasi Anda</div>
                            <div id="location-info" class="location-display" style="display: none;">
                                <p><strong>Koordinat:</strong> <span id="coordinates"></span></p>
                                <p><strong>Alamat:</strong> <span id="address"></span></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Simpan Keluhan
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Implementasi JavaScript untuk validasi dan deteksi lokasi
        // Mirip dengan yang ada di form laporan sebelumnya
    </script>
</body>
</html>