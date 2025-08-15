<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require 'config.php';

// Pagination
$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk total data
$total_query = "SELECT COUNT(*) as total FROM keluhan";
$total_result = $conn->query($total_query);
$total_data = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_data / $limit);

// Query data dengan pagination
$query = "SELECT * FROM keluhan ORDER BY tanggal_keluhan DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Keluhan - Sistem Laporan Gangguan IndiHome</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
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
                    <h1>Data Keluhan</h1>
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

            <!-- Data Table -->
            <div class="data-table-container">
                <div class="table-header">
                    <h2 class="table-title">Daftar Keluhan</h2>
                    
                    <?php if ($_SESSION['level'] == 'admin'): ?>
                    <a href="input_keluhan.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Keluhan
                    </a>
                    <?php endif; ?>
                </div>
                
                <table id="keluhanTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>No. Tiket</th>
                            <th>Nama Pelapor</th>
                            <th>No. Internet</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['kd_tiket']; ?></td>
                            <td><?php echo $row['nama_pelapor']; ?></td>
                            <td><?php echo $row['nomor_internet']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($row['tanggal_keluhan'])); ?></td>
                            <td><span class="badge badge-primary">Baru</span></td>
                            <td>
                                <a href="detail_keluhan.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Detail</a>
                                <?php if ($_SESSION['level'] == 'admin'): ?>
                                <a href="edit_keluhan.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
                                <a href="delete_keluhan.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus keluhan ini?')">Hapus</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                
                <!-- Pagination -->
                <div class="pagination" style="margin-top: 20px; display: flex; justify-content: center;">
                    <?php if ($page > 1): ?>
                    <a href="keluhan.php?page=<?php echo $page - 1; ?>" class="btn btn-secondary" style="margin-right: 10px;">
                        <i class="fas fa-chevron-left"></i> Sebelumnya
                    </a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="keluhan.php?page=<?php echo $i; ?>" class="btn <?php echo $i == $page ? 'btn-primary' : 'btn-secondary'; ?>" style="margin: 0 5px;">
                        <?php echo $i; ?>
                    </a>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                    <a href="keluhan.php?page=<?php echo $page + 1; ?>" class="btn btn-secondary" style="margin-left: 10px;">
                        Selanjutnya <i class="fas fa-chevron-right"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#keluhanTable').DataTable({
                responsive: true,
                searching: true,
                paging: false, // Kita menggunakan pagination manual
                info: false
            });

            // User dropdown
            $('#userDropdown').click(function() {
                $('#dropdownMenu').toggleClass('show');
            });

            // Close dropdown when clicking outside
            $(document).click(function(e) {
                if (!$(e.target).closest('#userDropdown').length) {
                    $('#dropdownMenu').removeClass('show');
                }
            });
        });
    </script>
</body>
</html>