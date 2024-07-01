<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_keluhan";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT kd_tiket, nomor_internet, nama_pelapor, no_hp_pelapor, alamat_lengkap, keluhan, share_location, tanggal_submit FROM keluhan";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
