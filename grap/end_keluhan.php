<?php
session_start();

// Redirect jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Ambil data dari form
date_default_timezone_set('Asia/Makassar'); // WITA (GMT+8)
$data = [
    'nama_csr' => htmlspecialchars($_POST['nama_csr']),
    'lokasi_grapari' => htmlspecialchars($_POST['lokasi_grapari']),
    'id_tiket' => htmlspecialchars($_POST['id_tiket']),
    'no_internet' => htmlspecialchars($_POST['no_internet']),
    'nama_pelanggan' => htmlspecialchars($_POST['nama_pelanggan']),
    'no_hp' => htmlspecialchars($_POST['no_hp']),
    'alamat' => htmlspecialchars($_POST['alamat']),
    'keluhan' => htmlspecialchars($_POST['keluhan']),
    'latitude' => $_POST['latitude'],
    'longitude' => $_POST['longitude'],
    'waktu_input' => date('d-m-Y H:i:s')
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Keluhan Pelanggan</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #ff9a8b, #ff6a88);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            max-width: 800px;
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }
        h2 {
            font-size: 28px;
            font-weight: bold;
            color: #ff3b5c;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            text-align: center;
        }
        .data-container {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            position: relative;
        }
        .data-item {
            margin-bottom: 15px;
            display: flex;
        }
        .data-label {
            font-weight: bold;
            min-width: 150px;
            color: #555;
        }
        .data-value {
            flex: 1;
            word-break: break-word;
        }
        .btn-group {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        .btn {
            background: linear-gradient(45deg, #ff3b5c, #ff6a88);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(255, 59, 92, 0.4);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn:hover {
            background: linear-gradient(45deg, #ff6a88, #ff9a8b);
            transform: translateY(-3px);
        }
        .btn-copy {
            background: linear-gradient(45deg, #28a745, #218838);
        }
        .btn-copy:hover {
            background: linear-gradient(45deg, #218838, #1e7e34);
        }
        .copy-all {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: #ff3b5c;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .copy-all:hover {
            color: #ff6a88;
        }
        .toast {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .toast.show {
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-check-circle"></i> Data Keluhan Tersimpan</h2>
        
        <div class="data-container" id="dataContainer">
            <button class="copy-all" id="copyAllBtn">
                <i class="fas fa-copy"></i> Copy Semua
            </button>
            
            <?php foreach ($data as $label => $value): ?>
                <div class="data-item">
                    <div class="data-label"><?php echo ucfirst(str_replace('_', ' ', $label)); ?>:</div>
                    <div class="data-value" id="<?php echo $label; ?>"><?php echo $value; ?></div>
                    <button class="copy-btn" data-target="<?php echo $label; ?>" title="Copy">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="btn-group">
            <a href="input_keluhan.php" class="btn">
                <i class="fas fa-plus-circle"></i> Input Baru
            </a>
            <a href="logout.php" class="btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <div class="toast" id="toast">Teks berhasil disalin!</div>

    <script>
        // Fungsi untuk copy teks
        function copyToClipboard(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            
            // Tampilkan toast
            const toast = document.getElementById('toast');
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 2000);
        }
        
        // Copy per item
        document.querySelectorAll('.copy-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const text = document.getElementById(targetId).textContent;
                copyToClipboard(text);
            });
        });
        
        // Copy semua data
        document.getElementById('copyAllBtn').addEventListener('click', function() {
            let allText = '';
            document.querySelectorAll('.data-item').forEach(item => {
                const label = item.querySelector('.data-label').textContent;
                const value = item.querySelector('.data-value').textContent;
                allText += `${label} ${value}\n`;
            });
            copyToClipboard(allText);
        });
    </script>
</body>
</html>