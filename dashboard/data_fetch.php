<?php
include "../api/conec.php";

// Mengatur zona waktu ke WITA
date_default_timezone_set('Asia/Makassar');

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

// Fungsi untuk mengambil data keluhan hari ini berdasarkan waktu lokal
if (isset($_GET['action']) && $_GET['action'] === 'today') {
    $today = date('Y-m-d');
    $search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
    $sql = "SELECT kd_tiket, nomor_internet, nama_pelapor, no_hp_pelapor, alamat_lengkap, keluhan, share_location, tanggal_keluhan 
            FROM keluhan 
            WHERE DATE(tanggal_keluhan) = ? 
            AND (kd_tiket LIKE ? OR nomor_internet LIKE ? OR nama_pelapor LIKE ? OR keluhan LIKE ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $today, $search, $search, $search, $search);
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

// Query untuk mengambil semua data keluhan
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
