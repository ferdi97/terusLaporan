<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_keluhan";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$nomor_internet = $data['nomor_internet'];
$nama_pelapor = $data['nama_pelapor'];
$no_hp_pelapor = $data['no_hp_pelapor'];
$alamat_lengkap = $data['alamat_lengkap'];
$keluhan = $data['keluhan'];
$share_location = $data['share_location'];
$kd_tiket = $data['kd_tiket'];

$sql = "INSERT INTO keluhan (nomor_internet, nama_pelapor, no_hp_pelapor, alamat_lengkap, keluhan, share_location, kd_tiket) 
        VALUES ('$nomor_internet', '$nama_pelapor', '$no_hp_pelapor', '$alamat_lengkap', '$keluhan', '$share_location', '$kd_tiket') 
        ON DUPLICATE KEY UPDATE
        nama_pelapor = '$nama_pelapor',
        no_hp_pelapor = '$no_hp_pelapor',
        alamat_lengkap = '$alamat_lengkap',
        keluhan = '$keluhan',
        share_location = '$share_location',
        kd_tiket = '$kd_tiket'";

if ($conn->query($sql) === TRUE) {
    echo "Data saved successfully!";
} else {
    echo "Error saving data: " . $conn->error;
}

$conn->close();
