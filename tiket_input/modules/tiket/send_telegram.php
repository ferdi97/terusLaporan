<?php
require_once '../../includes/auth.php';
require_once '../../includes/database.php';
require_once '../../includes/functions.php';

check_login();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid']);
    exit;
}

$id_tiket = clean_input($_POST['id_tiket']);
$tiket = get_tiket_by_id($id_tiket);

if (!$tiket) {
    echo json_encode(['success' => false, 'message' => 'Tiket tidak ditemukan']);
    exit;
}

// Simulasi pengiriman Telegram
// Di produksi, gunakan API Telegram Bot
$message = "📢 *TIKET BARU* 📢\n\n";
$message .= "🆔 *ID Tiket*: {$tiket['id_tiket']}\n";
$message .= "📅 *Report Date*: {$tiket['reportdate']}\n";
$message .= "📅 *Booking Date*: {$tiket['bookingdate']}\n";
$message .= "🔧 *Tipe Tiket*: {$tiket['tipe_tiket']}\n";
$message .= "🚩 *Flag*: {$tiket['flag_tiket']}\n";
$message .= "📍 *Sektor*: {$tiket['sektor']}\n";
$message .= "🔌 *Datek ODP*: {$tiket['datek_odp']}\n";
$message .= "👨‍💼 *HD*: {$tiket['nama_hd']}\n";
$message .= "👨‍🔧 *Teknisi*: {$tiket['teknisi_nama']}\n\n";
$message .= "⚠️ *Segera ditindaklanjuti!*";

// Simpan log pengiriman (di produksi, ganti dengan API call sebenarnya)
$log = [
    'date' => date('Y-m-d H:i:s'),
    'tiket_id' => $id_tiket,
    'message' => $message,
    'status' => 'sent'
];

file_put_contents('../../data/telegram_log.json', json_encode($log, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), FILE_APPEND);

echo json_encode([
    'success' => true,
    'message' => 'Tiket berhasil dikirim ke Telegram',
    'ticket_id' => $id_tiket
]);