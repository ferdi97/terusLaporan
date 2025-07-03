<?php
// Ambil path dari URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Daftar route yang diizinkan
$routes = [
    'home'      => 'index3.php',
    'error' => '404.php',
    'error'   => '404.php',
];

// Jalankan file sesuai route
if (array_key_exists($page, $routes)) {
    include $routes[$page];
} else {
    http_response_code(404);
    echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
}
