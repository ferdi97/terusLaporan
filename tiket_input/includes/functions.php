<?php
require_once __DIR__ . '/auth.php';

function generate_captcha($length = 6) {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $code;
}

function generate_captcha_image($code) {
    $width = 200;
    $height = 50;
    
    $image = imagecreatetruecolor($width, $height);
    
    // Warna background
    $bgColor = imagecolorallocate($image, 255, 255, 255);
    imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);
    
    // Warna teks
    $textColor = imagecolorallocate($image, 0, 0, 0);
    
    // Tambahkan noise
    for ($i = 0; $i < 5; $i++) {
        $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
        imageline($image, 0, rand() % $height, $width, rand() % $height, $color);
    }
    
    // Tulis teks
    $font = 5; // Font built-in
    $x = 10;
    $y = 20;
    
    for ($i = 0; $i < strlen($code); $i++) {
        $char = $code[$i];
        imagestring($image, $font, $x, $y + rand(-5, 5), $char, $textColor);
        $x += 30;
    }
    
    // Output gambar
    ob_start();
    imagepng($image);
    $imageData = ob_get_clean();
    imagedestroy($image);
    
    return 'data:image/png;base64,' . base64_encode($imageData);
}

function generate_otp($length = 6) {
    return str_pad(rand(0, pow(10, $length)-1), $length, '0', STR_PAD_LEFT);
}

function authenticate_user($username, $password) {
    $users = get_all_users();
    
    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            return $user;
        }
    }
    
    return false;
}