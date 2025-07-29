<?php
header('Content-Type: application/json');
include "api/conec.php";

// Set timezone untuk Indonesia
date_default_timezone_set('Asia/Makassar');

$data = json_decode(file_get_contents("php://input"), true);

// Validasi data
if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak valid']);
    exit;
}

// Format data
$tanggal_keluhan = date('Y-m-d H:i:s'); // Format tanggal baru

try {
    $stmt = $conn->prepare("INSERT INTO keluhan 
        (nomor_internet, nama_pelapor, no_hp_pelapor, alamat_lengkap, keluhan, share_location, kd_tiket, tanggal_keluhan) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param(
        "ssssssss",
        $data['nomor_internet'],
        $data['nama_pelapor'],
        $data['no_hp_pelapor'],
        $data['alamat_lengkap'],
        $data['keluhan'],
        $data['share_location'],
        $data['kd_tiket'],
        $tanggal_keluhan
    );

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Laporan berhasil disimpan',
            'data' => [
                'kd_tiket' => $data['kd_tiket'],
                'nomor_internet' => $data['nomor_internet'],
                'nama_pelapor' => $data['nama_pelapor'],
                'no_hp_pelapor' => $data['no_hp_pelapor'],
                'alamat_lengkap' => $data['alamat_lengkap'],
                'keluhan' => $data['keluhan'],
                'share_location' => $data['share_location'],
                'tanggal_keluhan' => $tanggal_keluhan // Menggunakan format baru
            ]
        ]); 
    } else {
        throw new Exception("Gagal menyimpan data");
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

$conn->close();
?>