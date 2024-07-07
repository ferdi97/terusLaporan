<?php
// Mulai session
session_start();

// Cek apakah form login sudah di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simpan koneksi database dan informasi login di sini
    include "../api/conec.php";

    // Ambil username dan password dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan sanitasi input untuk mencegah SQL injection (disarankan menggunakan prepared statement)
    $username = $conn->real_escape_string($username);

    // Buat query untuk memeriksa kecocokan username dan password
    $sql = "SELECT id, username, password, level_user FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Bind result variables
    $stmt->bind_result($id, $db_username, $db_password, $level_user);

    // Check jika username ditemukan
    if ($stmt->num_rows > 0) {
        // Ambil hasil query
        $stmt->fetch();

        // Verifikasi password
        if (password_verify($password, $db_password)) {
            // Password cocok, atur session
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $id;
            $_SESSION['level_user'] = $level_user;

            // Redirect ke halaman index.php atau halaman lain setelah login berhasil
            header('Location: index.php');
            exit;
        } else {
            // Password tidak cocok
            $login_error = "Password salah.";
        }
    } else {
        // Username tidak ditemukan
        $login_error = "Username tidak ditemukan.";
    }

    // Tutup statement dan koneksi database
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-weight: 600;
            color: #333;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .login-container label {
            text-align: left;
            font-weight: 600;
            color: #333;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s;
            width: 100%;
            box-sizing: border-box;
        }

        .login-container input[type="text"]:focus,
        .login-container input[type="password"]:focus {
            border-color: #007BFF;
            outline: none;
        }

        .login-container input[type="submit"] {
            padding: 12px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
        }

        .login-container input[type="submit"]:hover {
            background: #0056b3;
        }

        .login-container p {
            color: red;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .input-container {
            position: relative;
        }

        .input-container i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            padding-left: 40px;
        }

        .input-container input[type="text"]:focus+i,
        .input-container input[type="password"]:focus+i {
            color: #007BFF;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($login_error)) : ?>
            <p><?php echo $login_error; ?></p>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
            <div class="input-container">
                <input type="text" id="username" name="username" required>
                <i class="fas fa-user"></i>
            </div>
            <div class="input-container">
                <input type="password" id="password" name="password" required>
                <i class="fas fa-lock"></i>
            </div>
            <input type="submit" value="Login">
        </form>
    </div>
    <script>
        function validateForm() {
            let username = document.getElementById("username").value;
            let password = document.getElementById("password").value;
            if (username === "" || password === "") {
                alert("Both fields must be filled out");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
