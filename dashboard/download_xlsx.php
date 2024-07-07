<?php
// Pastikan pengguna sudah login atau memiliki akses yang sesuai
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
if ($_SESSION['level_user'] !== 'admin') {
    header('Location: unauthorized.php');
    exit;
}

// Include autoload dari composer
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Buat objek Spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Mengambil data dari database
include "../api/conec.php"; // Sesuaikan dengan path ke file koneksi database Anda

$sql = "SELECT kd_tiket, nomor_internet, nama_pelapor, no_hp_pelapor, alamat_lengkap, keluhan, share_location, tanggal_keluhan FROM keluhan";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    // Mengambil data dari database dan menambahkannya ke array $data
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Menambahkan data ke sheet
$sheet->setCellValue('A1', 'KD TIKET');
$sheet->setCellValue('B1', 'NOMOR INTERNET');
$sheet->setCellValue('C1', 'NAMA PELAPOR');
$sheet->setCellValue('D1', 'NO HP');
$sheet->setCellValue('E1', 'ALAMAT');
$sheet->setCellValue('F1', 'KELUHAN');
$sheet->setCellValue('G1', 'KOORDINAT');
$sheet->setCellValue('H1', 'TANGGAL SUBMIT');

$rowNum = 2;
foreach ($data as $row) {
    $sheet->setCellValue('A' . $rowNum, $row['kd_tiket']);
    $sheet->setCellValue('B' . $rowNum, $row['nomor_internet']);
    $sheet->setCellValue('C' . $rowNum, $row['nama_pelapor']);
    $sheet->setCellValue('D' . $rowNum, $row['no_hp_pelapor']);
    $sheet->setCellValue('E' . $rowNum, $row['alamat_lengkap']);
    $sheet->setCellValue('F' . $rowNum, $row['keluhan']);
    $sheet->setCellValue('G' . $rowNum, $row['share_location']);
    $sheet->setCellValue('H' . $rowNum, $row['tanggal_keluhan']);
    $rowNum++;
}

// Set headers untuk download file Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="data_keluhan.xlsx"');
header('Cache-Control: max-age=0');

// Simpan ke file Excel dan kirim output ke browser
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
