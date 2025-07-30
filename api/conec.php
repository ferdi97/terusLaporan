<?php
// $servername = "localhost";
// $username_db = "u545755515_algoritma";
// $password_db = "Algoritma97";
// $dbname = "u545755515_db_keluhan";

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "db_keluhan";

// Membuat koneksi
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
