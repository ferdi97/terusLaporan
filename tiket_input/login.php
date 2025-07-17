<?php
session_start();
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);
    $captcha = clean_input($_POST['captcha']);
    
    if ($captcha !== $_SESSION['captcha']) {
        $error = 'CAPTCHA tidak valid!';
    } else {
        $user = authenticate_user($username, $password);
        if ($user) {
            // Generate OTP
            $otp = generate_otp();
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_time'] = time();
            $_SESSION['temp_user'] = $user;
            
            // Kirim OTP (simulasi)
            // Di produksi, integrasikan dengan Google Auth atau layanan SMS
            echo "<script>alert('OTP Anda: $otp');</script>";
            
            header('Location: verify_otp.php');
            exit;
        } else {
            $error = 'Username atau password salah!';
        }
    }
}

// Generate CAPTCHA
$captcha_code = generate_captcha();
$_SESSION['captcha'] = $captcha_code;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Tiket</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-container animated fadeIn">
        <div class="login-box">
            <div class="login-header">
                <h2>Login Sistem</h2>
                <p>Silakan masuk dengan akun Anda</p>
            </div>
            
            <?php if ($error): ?>
            <div class="alert alert-danger animated shake"><?= $error ?></div>
            <?php endif; ?>
            
            <form action="login.php" method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required class="form-control">
                </div>
                
                <div class="form-group captcha-group">
                    <label for="captcha">CAPTCHA</label>
                    <div class="captcha-container">
                        <div class="captcha-image"><?= $captcha_code ?></div>
                        <button type="button" class="btn-refresh" onclick="refreshCaptcha()">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                    <input type="text" id="captcha" name="captcha" required class="form-control">
                </div>
                
                <button type="submit" class="btn btn-primary btn-login">Login</button>
            </form>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        function refreshCaptcha() {
            fetch('includes/captcha.php')
                .then(response => response.text())
                .then(data => {
                    document.querySelector('.captcha-image').textContent = data;
                });
        }
    </script>
</body>
</html>