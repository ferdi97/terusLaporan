// script.js
document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Mencegah form submit default

    // Ambil nilai input
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // Validasi sederhana
    if (username === "admin" || password === "admin") {
        alert("Username dan Password harus diisi!");
    } else {
        alert("Login berhasil! Redirecting...");
        // Redirect atau lakukan sesuatu setelah login berhasil
        // window.location.href = "dashboard.html";
    }
});