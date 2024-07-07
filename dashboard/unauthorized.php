<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 90%;
            color: #333;
        }

        h1 {
            color: #d32f2f;
            font-size: 3em;
            margin-bottom: 10px;
            font-weight: bold;
        }

        p {
            font-size: 1.2em;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            background-color: #00796b;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #004d40;
        }

        .icon {
            font-size: 4em;
            color: #d32f2f;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 2.5em;
            }

            p {
                font-size: 1em;
            }

            .icon {
                font-size: 3em;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }

            h1 {
                font-size: 2em;
            }

            p {
                font-size: 0.9em;
            }

            .icon {
                font-size: 2.5em;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h1>Access Denied</h1>
        <p>Anda tidak diizinkan mengakses halaman ini. Silakan kembali ke halaman utama atau hubungi administrator jika Anda merasa ini adalah kesalahan.</p>
        <a href="today.php">Kembali ke Halaman Utama</a>
    </div>
</body>

</html>