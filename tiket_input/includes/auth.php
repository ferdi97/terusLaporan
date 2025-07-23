<?php
function start_secure_session() {
    // Pastikan session belum dimulai
    if (session_status() === PHP_SESSION_NONE) {
        $session_name = 'secure_session';
        $secure = true; // Hanya kirim cookie melalui HTTPS
        $httponly = true; // Mencegah akses JavaScript ke cookie
        
        // Force sessions to only use cookies
        ini_set('session.use_only_cookies', 1);
        
        // Get current cookies params
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params([
            'lifetime' => $cookieParams["lifetime"],
            'path' => '/',
            'domain' => $cookieParams["domain"],
            'secure' => $secure,
            'httponly' => $httponly,
            'samesite' => 'Strict'
        ]);
        
        session_name($session_name);
        session_start();
        session_regenerate_id(true);
    }
}

function is_logged_in() {
    start_secure_session();
    return isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string']);
}

function check_login() {
    if (!is_logged_in()) {
        header('Location: ../login.php');
        exit;
    }
}

function check_role($allowed_roles) {
    if (!is_logged_in()) {
        header('Location: ../login.php');
        exit;
    }
    
    if (is_array($allowed_roles)) {
        if (!in_array($_SESSION['user_level'], $allowed_roles)) {
            header('Location: ../unauthorized.php');
            exit;
        }
    } else {
        if ($_SESSION['user_level'] !== $allowed_roles) {
            header('Location: ../unauthorized.php');
            exit;
        }
    }
}

function clean_input($data) {
    if (is_array($data)) {
        return array_map('clean_input', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return $data;
}