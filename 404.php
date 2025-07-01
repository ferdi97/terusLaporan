<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Under Maintenance</title>
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
            color: #00796b;
            font-size: 3em;
            margin-bottom: 10px;
            font-weight: bold;
        }

        p {
            font-size: 1.2em;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .loader {
            border: 6px solid rgba(0, 121, 107, 0.2);
            border-radius: 50%;
            border-top: 6px solid #00796b;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 1024px) {
            .container {
                padding: 30px;
            }
            h1 {
                font-size: 2.5em;
            }
            p {
                font-size: 1.1em;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            h1 {
                font-size: 2em;
            }
            p {
                font-size: 1em;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }
            h1 {
                font-size: 1.8em;
            }
            p {
                font-size: 0.9em;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="img/23bf6c175985a931c3c2d893f21f3313.gif" alt="Under Maintenance" style="max-width: 50%; height: auto;">
        <h1>Oopss!!!</h1>
        <p>Kami mohon maaf atas ketidaknyamanan ini. Halaman yang Anda cari sedang dalam proses perbaikan agar bisa memberikan pengalaman yang lebih baik.</p>
        <p>Silakan coba lagi nanti.</p>
    </div>
</body>

</html>
