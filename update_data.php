<?php
$servername = "localhost";
$username = "algoritma";
$password = "Algoritma97";
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

// Lakukan INSERT data tanpa memeriksa apakah sudah ada
$sql_insert = "INSERT INTO keluhan (nomor_internet, nama_pelapor, no_hp_pelapor, alamat_lengkap, keluhan, share_location) VALUES (?, ?, ?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);

if ($stmt_insert) {
    $stmt_insert->bind_param("ssssss", $nomor_internet, $nama_pelapor, $no_hp_pelapor, $alamat_lengkap, $keluhan, $share_location);
    if ($stmt_insert->execute()) {
        echo "Data inserted successfully!";
    } else {
        echo "Error inserting data: " . $stmt_insert->error;
    }
    $stmt_insert->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
