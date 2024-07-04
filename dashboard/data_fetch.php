<?php
$servername = "localhost";
$username = "u545755515_algoritma";
$password = "Algoritma97";
$dbname = "u545755515_db_keluhan";

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "db_keluhan";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk menghapus record
if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['kd_tiket'])) {
    $kd_tiket = $_POST['kd_tiket'];
    $sql = "DELETE FROM keluhan WHERE kd_tiket = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $kd_tiket);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Fungsi untuk mengambil data keluhan
if (isset($_GET['action']) && $_GET['action'] === 'today') {
    $today = date('Y-m-d');
    $sql = "SELECT kd_tiket, nomor_internet, nama_pelapor, no_hp_pelapor, alamat_lengkap, keluhan, share_location, tanggal_keluhan FROM keluhan WHERE DATE(tanggal_keluhan) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
    $stmt->close();
    $conn->close();
    exit;
}

$sql = "SELECT kd_tiket, nomor_internet, nama_pelapor, no_hp_pelapor, alamat_lengkap, keluhan, share_location, tanggal_keluhan FROM keluhan";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
