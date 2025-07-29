<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
if ($_SESSION['level_user'] !== 'admin') {
    header('Location: unauthorized.php'); // ganti dengan halaman yang sesuai
    exit;
}
$level_user = $_SESSION['level_user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Keluhan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.3.1/css/rowGroup.dataTables.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background: #f4f6f9;
            color: #333;
        }
        .container {
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            width: 250px;
            background: #111827;
            color: #fff;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
        }
        .sidebar-header h2 {
            margin-bottom: 1rem;
        }
        .sidebar nav ul {
            list-style: none;
            padding: 0;
        }
        .sidebar nav ul li {
            margin: 0.5rem 0;
        }
        .sidebar nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s ease;
        }
        .sidebar nav ul li a:hover,
        .sidebar nav ul li a.active {
            background: #1f2937;
        }
        .content {
            flex-grow: 1;
            padding: 2rem;
            animation: fadeIn 0.6s ease;
        }
        header h3 {
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .table-container {
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            animation: slideUp 0.5s ease;
        }
        #keluhanTable {
            width: 100%;
            border-collapse: collapse;
        }
        .download-container {
            margin-top: 1rem;
            text-align: right;
        }
        .download-btn {
            padding: 0.6rem 1.2rem;
            background: #10b981;
            border: none;
            color: white;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .download-btn:hover {
            background: #059669;
        }
        .loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        .loader::after {
            content: "";
            width: 48px;
            height: 48px;
            border: 6px solid #10b981;
            border-top: 6px solid transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>

<body>
    <div class="container">
        <div id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <h2>Menu</h2>
            </div>
            <nav>
                <ul>
                    <li><a href="today.php"><i class="fas fa-calendar-day"></i> Keluhan Hari Ini</a></li>
                    <?php if ($level_user == 'admin') : ?>
                        <li><a href="index.php" class="active"><i class="fas fa-bug"></i> Data Keluhan</a></li>
                        <li><a href="data_user.php"><i class="fas fa-user"></i> Data User</a></li>
                    <?php endif; ?>
                    <li><a id="logout" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </div>
        <div class="content">
            <header>
                <h3>Data Keluhan</h3>
            </header>
            <div class="table-container">
                <table id="keluhanTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Tiket</th>
                            <th>Nomor Internet</th>
                            <th>Nama Pelapor</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Keluhan</th>
                            <th>Lokasi</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
                <div class="download-container">
                    <a href="download_xlsx.php">
                        <button id="download-xlsx" class="download-btn"><i class="fas fa-download"></i> Download XLSX</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="loader" class="loader"></div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.3.1/js/dataTables.rowGroup.min.js"></script>
    <script src="scripts.js"></script>
</body>
</html>
