<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: keluhan.php");
    exit();
}

require 'config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM keluhan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: keluhan.php");
    exit();
}

$keluhan = $result->fetch_assoc();
$stmt->close();

// Pisahkan alamat lengkap
$alamat = explode('|', $keluhan['alamat_lengkap']);
$jalan = $alamat[0] ?? '';
$rt_rw = $alamat[1] ?? '';
$kelurahan = $alamat[2] ?? '';
$kecamatan = $alamat[3] ?? '';
$kota_kabupaten = $alamat[4] ?? '';

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Keluhan - Sistem Laporan Gangguan IndiHome</title>
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
                    <h1>Detail Keluhan</h1>
                    <p>No. Tiket: <?php echo $keluhan['kd_tiket']; ?></p>
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

            <!-- Detail Keluhan -->
            <div class="detail-container" style="background: white; padding: 20px; border-radius: var(--border-radius); box-shadow: var(--box-shadow);">
                <div class="detail-row">
                    <div class="detail-label">No. Tiket</div>
                    <div class="detail-value"><?php echo $keluhan['kd_tiket']; ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">No. Internet</div>
                    <div class="detail-value"><?php echo $keluhan['nomor_internet']; ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Nama Pelapor</div>
                    <div class="detail-value"><?php echo $keluhan['nama_pelapor']; ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">No. HP Pelapor</div>
                    <div class="detail-value"><?php echo $keluhan['no_hp_pelapor']; ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Alamat</div>
                    <div class="detail-value">
                        <?php echo $jalan; ?>, RT/RW <?php echo $rt_rw; ?>, 
                        Kel. <?php echo $kelurahan; ?>, Kec. <?php echo $kecamatan; ?>, 
                        <?php echo $kota_kabupaten; ?>
                    </div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Keluhan</div>
                    <div class="detail-value"><?php echo nl2br($keluhan['keluhan']); ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Lokasi</div>
                    <div class="detail-value"><?php echo $keluhan['share_location']; ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Tanggal Keluhan</div>
                    <div class="detail-value"><?php echo date('d/m/Y H:i', strtotime($keluhan['tanggal_keluhan'])); ?></div>
                </div>
                
                <div class="detail-actions" style="margin-top: 30px;">
                    <a href="keluhan.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    
                    <?php if ($_SESSION['level'] == 'admin'): ?>
                    <a href="edit_keluhan.php?id=<?php echo $keluhan['id']; ?>" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Implementasi JavaScript untuk dropdown user
    </script>
</body>
</html>