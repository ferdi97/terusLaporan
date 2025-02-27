<?php
include "api/conec.php";

// Mendapatkan data dari request JSON
$data = json_decode(file_get_contents("php://input"), true);
$nomor_internet = $data['nomor_internet'];
$nama_pelapor = $data['nama_pelapor'];
$no_hp_pelapor = $data['no_hp_pelapor'];
$alamat_lengkap = $data['alamat_lengkap'];
$keluhan = $data['keluhan'];
$share_location = $data['share_location'];
$kd_tiket = $data['kd_tiket'];

// Mengatur zona waktu untuk WITA atau Kalimantan Timur
date_default_timezone_set('Asia/Makassar'); // WITA atau GMT+8

// Mendapatkan waktu saat ini dalam format yang sesuai untuk MySQL
$tanggal_keluhan = date('Y-m-d H:i:s');

// Membuat query SQL untuk insert atau update data
$sql = "INSERT INTO keluhan (nomor_internet, nama_pelapor, no_hp_pelapor, alamat_lengkap, keluhan, share_location, kd_tiket, tanggal_keluhan) 
        VALUES ('$nomor_internet', '$nama_pelapor', '$no_hp_pelapor', '$alamat_lengkap', '$keluhan', '$share_location', '$kd_tiket', '$tanggal_keluhan') 
        ON DUPLICATE KEY UPDATE
        nama_pelapor = '$nama_pelapor',
        no_hp_pelapor = '$no_hp_pelapor',
        alamat_lengkap = '$alamat_lengkap',
        keluhan = '$keluhan',
        share_location = '$share_location',
        kd_tiket = '$kd_tiket',
        tanggal_keluhan = '$tanggal_keluhan'";

// Menjalankan query
if ($conn->query($sql) === TRUE) {
    echo "Terima kasih atas laporan yang Anda kirimkan. Kami ingin memberitahukan bahwa laporan Anda telah berhasil tersimpan dalam sistem kami. Tim kami akan segera memulai proses verifikasi dan analisis terhadap laporan tersebut.

Proses ini biasanya memerlukan waktu hingga 24 jam untuk memastikan bahwa semua detail yang Anda berikan ditinjau secara menyeluruh dan akurat. Kami sangat menghargai kesabaran dan pengertian Anda selama periode ini.

Apabila ada informasi tambahan yang diperlukan, kami akan segera menghubungi Anda. Jika tidak ada kendala, Anda dapat mengharapkan pembaruan atau penyelesaian dalam waktu 24 jam. Terima kasih atas kerjasama dan kepercayaan Anda.";
} else {
    echo "Error saving data: " . $conn->error;
}

// Menutup koneksi
$conn->close();
