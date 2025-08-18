<?php
header('Content-Type: application/json');
date_default_timezone_set('Asia/Makassar');

Database configuration
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "db_keluhan";

// $servername = "localhost";
// $username_db = "u545755515_algoritma";
// $password_db = "Algoritma97";
// $dbname = "u545755515_db_keluhan";

// Create connection
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        'status' => 'error',
        'message' => 'Connection failed: ' . $conn->connect_error
    ]));
}

// Get and sanitize input data
$nomor_internet = $conn->real_escape_string($_POST['nomor_internet']);
$nama_pelapor = $conn->real_escape_string($_POST['nama_pelapor']);
$no_hp_pelapor = $conn->real_escape_string($_POST['no_hp_pelapor']);

// Combine address parts
$jalan = $conn->real_escape_string($_POST['jalan']);
$rt_rw = $conn->real_escape_string($_POST['rt_rw']);
$kelurahan = $conn->real_escape_string($_POST['kelurahan']);
$kecamatan = $conn->real_escape_string($_POST['kecamatan']);
$kota_kabupaten = $conn->real_escape_string($_POST['kota_kabupaten']);
$alamat_lengkap = "$jalan | $rt_rw | $kelurahan | $kecamatan | $kota_kabupaten";

$keluhan = $conn->real_escape_string($_POST['keluhan']);
$share_location = $conn->real_escape_string($_POST['share_location']);
$tanggal_keluhan = date('Y-m-d H:i:s');

// Generate ticket number
$kd_tiket = 'IND' . time();

// Prepare SQL statement
$sql = "INSERT INTO keluhan (
    kd_tiket, 
    nomor_internet, 
    nama_pelapor, 
    no_hp_pelapor, 
    alamat_lengkap, 
    keluhan, 
    share_location, 
    tanggal_keluhan
) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssss",
    $kd_tiket,
    $nomor_internet,
    $nama_pelapor,
    $no_hp_pelapor,
    $alamat_lengkap,
    $keluhan,
    $share_location,
    $tanggal_keluhan
);

// Execute and return response
if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'data' => [
            'kd_tiket' => $kd_tiket,
            'nomor_internet' => $nomor_internet,
            'nama_pelapor' => $nama_pelapor,
            'no_hp_pelapor' => $no_hp_pelapor,
            'alamat_lengkap' => $alamat_lengkap,
            'keluhan' => $keluhan,
            'share_location' => $share_location,
            'tanggal_keluhan' => $tanggal_keluhan
        ]
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error: ' . $stmt->error
    ]);
}

// Close connections
$stmt->close();
$conn->close();
