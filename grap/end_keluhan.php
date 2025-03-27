<?php
session_start();

// Redirect jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "db_keluhan";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$nama_csr = htmlspecialchars($_POST['nama_csr']);
$lokasi_grapari = htmlspecialchars($_POST['lokasi_grapari']);
$id_tiket = htmlspecialchars($_POST['id_tiket']);
$no_internet = htmlspecialchars($_POST['no_internet']);
$nama_pelanggan = htmlspecialchars($_POST['nama_pelanggan']);
$no_hp = htmlspecialchars($_POST['no_hp']);
$alamat = htmlspecialchars($_POST['alamat']);
$keluhan = htmlspecialchars($_POST['keluhan']);
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

// Validasi format ID Tiket
if (!preg_match('/^CSR\d{9}$/', $id_tiket)) {
    die("Format ID Tiket tidak valid!");
}

// Query untuk menyimpan data
$sql = "INSERT INTO keluhan_pelanggan (
    nama_csr, 
    lokasi_grapari, 
    id_tiket, 
    no_internet, 
    nama_pelanggan, 
    no_hp, 
    alamat, 
    keluhan, 
    latitude, 
    longitude,
    tanggal_input
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssssss", 
    $nama_csr, 
    $lokasi_grapari, 
    $id_tiket, 
    $no_internet, 
    $nama_pelanggan, 
    $no_hp, 
    $alamat, 
    $keluhan, 
    $latitude, 
    $longitude
);

if ($stmt->execute()) {
    echo "<script>
        alert('Data keluhan berhasil disimpan!');
        window.location.href = 'input_keluhan.php';
    </script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>