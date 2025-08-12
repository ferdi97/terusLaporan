<?php
// $host = 'localhost';
// $dbname = 'db_keluhan';
// $username = 'root';
// $password = '';

$servername = "localhost";
$username = "u545755515_algoritma";
$password = "Algoritma97";
$dbname = "u545755515_db_keluhan";


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>