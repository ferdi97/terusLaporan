<?php
function sendToTelegram($ticket) {
    $botToken = 'YOUR_TELEGRAM_BOT_TOKEN';
    $chatId = 'YOUR_CHAT_ID';
    
    $message = "📢 *Tiket Baru Dibuat* 📢\n\n";
    $message .= "🆔 ID Tiket: *{$ticket['id_tiket']}*\n";
    $message .= "📅 Report Date: *{$ticket['reportdate']}*\n";
    $message .= "⏰ Booking Date: *{$ticket['bookingdate']}*\n";
    $message .= "🔧 Tipe Tiket: *{$ticket['Tipe_Tiket']}*\n";
    $message .= "🚩 Flag Tiket: *{$ticket['flag_tiket']}*\n";
    $message .= "📍 Sektor: *{$ticket['sektor']}*\n";
    $message .= "🔌 Datek ODP: *{$ticket['datek_odp']}*\n";
    $message .= "👨‍💼 HD: *{$ticket['nama_hd']}*\n";
    $message .= "👷 Teknisi: *{$ticket['teknisi']}*\n";
    $message .= "🔄 Status: *{$ticket['status_tiket']}*\n";
    
    $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'Markdown'
    ];
    
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type:application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($data)
        ]
    ];
    
    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}
?>