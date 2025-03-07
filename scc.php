<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tiket & Inet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
            animation: fadeIn 1s ease-in-out;
        }
        h2 {
            color: white;
            margin-bottom: 15px;
        }
        .input-group {
            margin: 10px 0;
            position: relative;
        }
        input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
            outline: none;
        }
        input:focus {
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
        .btn {
            background: #ff7eb3;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: bold;
        }
        .btn:hover {
            background: #ff4e91;
            transform: scale(1.05);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    <script>
        function submitForm() {
            var noTiket = document.getElementById("noTiket").value;
            var noInet = document.getElementById("noInet").value;
            if(noTiket && noInet) {
                window.location.href = `https://scc.telkom.co.id/CloseTicket.Internet/Check_embeded/?ticketId=${noTiket}&nd=${noInet}`;
            } else {
                alert("Harap isi semua field!");
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>FORM SCC INET</h2>
        <div class="input-group">
            <input type="text" id="noTiket" placeholder="No Tiket" required>
        </div>
        <div class="input-group">
            <input type="text" id="noInet" placeholder="No Inet" required>
        </div>
        <button class="btn" onclick="submitForm()">Submit</button>
    </div>
</body>
</html>
