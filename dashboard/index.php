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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <div id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <h2>Menu</h2>
                <!-- <button id="toggle-btn"><i class="fas fa-bars"></i></button> -->
            </div>
            <nav>
                <ul>
                    <li><a href="today.php"><i class="fas fa-calendar-day"></i> Keluhan Hari Ini</a></li>
                    <?php if ($level_user == 'admin') : ?>
                        <li><a href="index.php" class="active"><i class="fas fa-bug"></i> Data Keluhan</a></li>
                        <li><a href="data_user.php"><i class="fas fa-user"></i> Data User</a></li>
                    <?php endif; ?>
                    <!-- <li><a id="setting" href="#"><i class="fas fa-cog"></i> Setting</a></li> -->
                    <li><a id="logout" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </div>
        <div class="content">
            <header>
                <h3>Data Keluhan</h3>
                <input type="text" id="search" placeholder="Search...">
                <span class="search-icon"><i class="fas fa-search"></i></span>

            </header>
            <div class="table-container">
                <table id="data-table">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>KD TIKET</th>
                            <th>NOMOR INTERNET</th>
                            <th>NAMA PELAPOR</th>
                            <th>NO HP</th>
                            <th>ALAMAT</th>
                            <th>KELUHAN</th>
                            <th>KOORDINAT</th>
                            <th>TANGGAL SUBMIT</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <!-- Rows will be inserted here by JavaScript -->
                    </tbody>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" integrity="sha512-LjU08OqMwTKLa+4w6dD2yJX2L1q/3M/brIO9Tm4z8ktbQAM7hN5RPwrFroUKfZ7gGItBkdV8zF0w8N5edwYUgA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="scripts.js"></script>
</body>

</html>