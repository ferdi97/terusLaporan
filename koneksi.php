<?php
$servername = "localhost";
$username = "algoritma";
$password = "Algoritma97";
$dbname = "db_keluhan";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

$kd_tiket = $_POST['kd_tiket'];
$nomor_internet = $_POST['nomor_internet'];
$nama_pelapor = $_POST['nama_pelapor'];
$no_hp_pelapor = $_POST['no_hp_pelapor'];
$alamat_lengkap = $_POST['alamat_lengkap'];
$keluhan = $_POST['keluhan'];
$share_location = $_POST['share_location'];

$sql = "INSERT INTO keluhan (kd_tiket, nomor_internet, nama_pelapor, no_hp_pelapor, alamat_lengkap, keluhan, share_location)
VALUES ('$kd_tiket', '$nomor_internet', '$nama_pelapor', '$no_hp_pelapor', '$alamat_lengkap', '$keluhan', '$share_location')";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil disimpan!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
