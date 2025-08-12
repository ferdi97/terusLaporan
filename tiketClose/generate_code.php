<?php
require_once 'config.php';
require_once 'includes/db.php';

// Buat kode baru
$today = date('Y-m-d');
$code = generateRandomCode();

// Simpan ke database
$stmt = $pdo->prepare("INSERT INTO access_codes (code, date) VALUES (?, ?)");
$stmt->execute([$code, $today]);

// Kirim ke Telegram
$message = "Kode akses hari ini: *$code*\n\n"
         . "Berlaku hingga pukul 23:59 WIB\n"
         . "Link: ".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/index.php";

$telegramUrl = "https://api.telegram.org/bot".TELEGRAM_BOT_TOKEN."/sendMessage";
$data = [
    'chat_id' => TELEGRAM_CHAT_ID,
    'text' => $message,
    'parse_mode' => 'Markdown'
];

$options = [
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query($data)
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($telegramUrl, false, $context);

echo "Kode harian telah dibuat dan dikirim ke Telegram: $code";
?>