<?php
require_once __DIR__ . '/includes/functions.php';

start_secure_session();

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
$captcha_image = generate_captcha_image($captcha_code);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Tiket</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                        <img src="<?= $captcha_image ?>" alt="CAPTCHA" class="captcha-image">
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
            fetch('captcha.php')
                .then(response => response.text())
                .then(data => {
                    // Perbarui CAPTCHA di session
                    fetch('update_captcha.php?captcha=' + data)
                        .then(() => {
                            // Refresh halaman untuk mendapatkan gambar CAPTCHA baru
                            location.reload();
                        });
                });
        }
    </script>
</body>
</html>