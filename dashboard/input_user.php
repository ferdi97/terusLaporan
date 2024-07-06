<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Koneksi ke database
include "../api/conec.php";

// Periksa apakah form sudah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk memasukkan data ke tabel users
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);

    // Eksekusi query
    if ($stmt->execute()) {
        $message = "Data berhasil disimpan!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input User</title>
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

        .input-container {
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

        .input-container h2 {
            margin-bottom: 20px;
            font-weight: 600;
            color: #333;
        }

        .input-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .input-container label {
            text-align: left;
            font-weight: 600;
            color: #333;
        }

        .input-container input[type="text"],
        .input-container input[type="password"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s;
            width: 100%;
            box-sizing: border-box;
        }

        .input-container input[type="text"]:focus,
        .input-container input[type="password"]:focus {
            border-color: #007BFF;
            outline: none;
        }

        .input-container input[type="submit"] {
            padding: 12px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
        }

        .input-container input[type="submit"]:hover {
            background: #0056b3;
        }

        .input-container p {
            color: red;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .input-container input[type="text"],
        .input-container input[type="password"] {
            padding-left: 40px;
        }

        .input-wrapper input[type="text"]:focus+i,
        .input-wrapper input[type="password"]:focus+i {
            color: #007BFF;
        }
    </style>
</head>

<body>
    <div class="input-container">
        <h2>Input User</h2>
        <?php if (isset($message)) : ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
            <div class="input-wrapper">
                <input type="text" id="username" name="username" required>
                <i class="fas fa-user"></i>
            </div>
            <div class="input-wrapper">
                <input type="password" id="password" name="password" required>
                <i class="fas fa-lock"></i>
            </div>
            <input type="submit" value="Simpan">
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