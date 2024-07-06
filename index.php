<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Under Maintenance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" integrity="sha384-oqdWg7N0a6Zd5O8jwJ7P+1Qv5QNS1u+Z9+8ObCB/5pvPjTUByEme2n6fh0+9uoI0" crossorigin="anonymous"> -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            /* Menggunakan font Poppins */
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

        h2 {
            color: #004d40;
            font-size: 1.8em;
            margin-bottom: 20px;
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

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 2.5em;
            }

            h2 {
                font-size: 1.5em;
            }

            p {
                font-size: 1em;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <img src="img/indi.png" alt="Under Maintenance" style="max-width: 20%; height: auto;">
        <h1>Oopss!!!</h1>
        <p>Kami mohon maaf atas ketidaknyamanan ini. Halaman yang Anda cari sedang dalam proses perbaikan agar bisa memberikan pengalaman yang lebih baik.</p>
        <div class="loader"></div>
        <p>Silakan coba lagi nanti.</p>
    </div>
</body>

</html>