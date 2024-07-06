<?php
// $servername = "localhost";
// $username = "u545755515_algoritma";
// $password = "Algoritma97";
// $dbname = "u545755515_db_keluhan";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_keluhan";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Mendapatkan data dari request JSON
$data = json_decode(file_get_contents("php://input"), true);
$nomor_internet = $data['nomor_internet'];
$nama_pelapor = $data['nama_pelapor'];
$no_hp_pelapor = $data['no_hp_pelapor'];
$alamat_lengkap = $data['alamat_lengkap'];
$keluhan = $data['keluhan'];
$share_location = $data['share_location'];
$kd_tiket = $data['kd_tiket'];

// Mengatur zona waktu untuk WITA atau Kalimantan Timur
date_default_timezone_set('Asia/Makassar'); // WITA atau GMT+8

// Mendapatkan waktu saat ini dalam format yang sesuai untuk MySQL
$tanggal_keluhan = date('Y-m-d H:i:s');

// Membuat query SQL untuk insert atau update data
$sql = "INSERT INTO keluhan (nomor_internet, nama_pelapor, no_hp_pelapor, alamat_lengkap, keluhan, share_location, kd_tiket, tanggal_keluhan) 
        VALUES ('$nomor_internet', '$nama_pelapor', '$no_hp_pelapor', '$alamat_lengkap', '$keluhan', '$share_location', '$kd_tiket', '$tanggal_keluhan') 
        ON DUPLICATE KEY UPDATE
        nama_pelapor = '$nama_pelapor',
        no_hp_pelapor = '$no_hp_pelapor',
        alamat_lengkap = '$alamat_lengkap',
        keluhan = '$keluhan',
        share_location = '$share_location',
        kd_tiket = '$kd_tiket',
        tanggal_keluhan = '$tanggal_keluhan'";

// Menjalankan query
if ($conn->query($sql) === TRUE) {
    echo "Laporan anda telah tersimpan silahkan menunggu 1 x 24 jam terimakasih";
} else {
    echo "Error saving data: " . $conn->error;
}

// Menutup koneksi
$conn->close();
