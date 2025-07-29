<?php
include "../api/conec.php";
date_default_timezone_set('Asia/Makassar');

if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['kd_tiket'])) {
    $kd_tiket = $_POST['kd_tiket'];
    $sql = "DELETE FROM keluhan WHERE kd_tiket = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $kd_tiket);
    echo $stmt->execute() ? json_encode(['status' => 'success']) : json_encode(['status' => 'error']);
    $stmt->close();
    $conn->close();
    exit;
}

$sql = "SELECT kd_tiket, nomor_internet, nama_pelapor, no_hp_pelapor, alamat_lengkap, keluhan, share_location, tanggal_keluhan FROM keluhan ORDER BY tanggal_keluhan DESC";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(['data' => $data]);
$conn->close();
?>