<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "db_keluhan";

$servername = "localhost";
$username_db = "u545755515_algoritma";
$password_db = "Algoritma97";
$dbname = "u545755515_db_keluhan";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8");
?>