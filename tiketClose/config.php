<?php
// Konfigurasi Telegram
define('TELEGRAM_BOT_TOKEN', '7558002858:AAFA3K96GC_RKx_EXu0M_JKwxKwfMa6psDs');
define('TELEGRAM_CHAT_ID', '-4694102752');

// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_keluhan');
define('DB_USER', 'root');
define('DB_PASS', '');

// Fungsi untuk membuat kode acak
function generateRandomCode($length = 6) {
    return substr(str_shuffle("0123456789"), 0, $length);
}
?>