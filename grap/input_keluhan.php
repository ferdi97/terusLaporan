<?php
session_start();

// Redirect jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$user = $_SESSION['user'];

// Generate ID Tiket Otomatis (CSR + 9 digit random)
$id_tiket = 'CSR' . str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Keluhan Pelanggan</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Font Awesome -->
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
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 28px;
            font-weight: bold;
            color: #ff3b5c;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-logout {
            background: linear-gradient(45deg, #dc3545, #c82333);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s;
        }
        .btn-logout:hover {
            background: linear-gradient(45deg, #c82333, #bd2130);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-row {
            display: flex;
            gap: 15px;
        }
        .form-col {
            flex: 1;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .input-group {
            display: flex;
            align-items: center;
            background: #f1f1f1;
            padding: 12px;
            border-radius: 10px;
            box-shadow: inset 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .input-group i {
            color: #ff3b5c;
            font-size: 18px;
            margin-right: 10px;
        }
        .input-group input, 
        .input-group textarea,
        .input-group select {
            border: none;
            outline: none;
            background: none;
            width: 100%;
            font-size: 16px;
            padding-left: 10px;
        }
        .input-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        #id_tiket {
            /* background-color: #f8f9fa; */
            font-weight: bold;
            color: #333;
        }
        .btn-refresh {
            background: none;
            border: none;
            color: #ff3b5c;
            cursor: pointer;
            padding: 0 5px;
            transition: all 0.3s;
            margin-left: 5px;
        }
        .btn-refresh:hover {
            color: #ff6a88;
        }
        .rotating {
            animation: rotate 0.5s ease-in-out;
        }
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
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
        }
        .btn:hover {
            background: linear-gradient(45deg, #ff6a88, #ff9a8b);
            transform: translateY(-3px);
        }
        .btn-secondary {
            background: linear-gradient(45deg, #6c757d, #868e96);
        }
        .btn-secondary:hover {
            background: linear-gradient(45deg, #868e96, #adb5bd);
        }
        #map {
            height: 300px;
            width: 100%;
            border-radius: 10px;
            margin-top: 10px;
            z-index: 1;
        }
        .coordinates {
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2><i class="fas fa-exclamation-triangle"></i> Form Input Keluhan Pelanggan</h2>
            <div class="user-info">
                <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($user['nama_csr']); ?></span>
                <a href="logout.php" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
        
        <form action="end_keluhan.php" method="POST">
            <input type="hidden" name="nama_csr" value="<?php echo htmlspecialchars($user['nama_csr']); ?>">
            <input type="hidden" name="lokasi_grapari" value="<?php echo htmlspecialchars($user['lokasi_grapari']); ?>">
            
            <div class="form-row">  
                <div class="form-col">
                    <div class="form-group">
                        <label for="id_tiket">ID Tiket</label>
                        <div class="input-group">
                            <i class="fas fa-ticket-alt"></i>
                            <input type="text" id="id_tiket" name="id_tiket" value="<?php echo $id_tiket; ?>" readonly>
                            <button type="button" class="btn-refresh" id="refreshTicket" title="Generate New ID">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>      
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label for="no_internet">No. Internet</label>
                        <div class="input-group">
                            <i class="fas fa-wifi"></i>
                            <input type="text" id="no_internet" name="no_internet" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="nama_pelanggan">Nama Pelanggan</label>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="nama_pelanggan" name="nama_pelanggan" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="no_hp">No. HP Pelanggan</label>
                        <div class="input-group">
                            <i class="fas fa-phone"></i>
                            <input type="tel" id="no_hp" name="no_hp" required>
                        </div>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label for="alamat">Alamat Pelanggan</label>
                        <div class="input-group">
                            <i class="fas fa-home"></i>
                            <input type="text" id="alamat" name="alamat" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="keluhan">Keluhan</label>
                <div class="input-group">
                    <i class="fas fa-comment-dots"></i>
                    <textarea id="keluhan" name="keluhan" required></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="location">Lokasi Pelanggan</label>
                <button type="button" class="btn" id="getLocation">
                    <i class="fas fa-map-marked-alt"></i> Dapatkan Lokasi Saya
                </button>
                <div id="map"></div>
                <div class="coordinates">
                    Koordinat: <span id="coordinates">Klik peta atau gunakan tombol di atas</span>
                </div>
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
            </div>

            <div class="btn-group">
                <button type="reset" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </button>
                <button type="submit" class="btn">
                    <i class="fas fa-paper-plane"></i> Submit
                </button>
            </div>
        </form>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        const map = L.map('map').setView([-6.2088, 106.8456], 13); // Default ke Jakarta
        
        // Tambahkan tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Tambahkan marker yang bisa di-drag
        let marker = L.marker(map.getCenter(), {
            draggable: true
        }).addTo(map);
        
        // Update koordinat saat marker dipindahkan
        marker.on('dragend', function(e) {
            updateCoordinates(marker.getLatLng());
        });
        
        // Fungsi untuk mendapatkan lokasi pengguna
        document.getElementById('getLocation').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        // Pindahkan peta ke lokasi pengguna
                        map.setView([lat, lng], 15);
                        
                        // Pindahkan marker ke lokasi pengguna
                        marker.setLatLng([lat, lng]);
                        
                        updateCoordinates({ lat, lng });
                    },
                    function(error) {
                        alert('Error mendapatkan lokasi: ' + error.message);
                    }
                );
            } else {
                alert('Geolocation tidak didukung oleh browser Anda');
            }
        });
        
        // Fungsi untuk update koordinat di form
        function updateCoordinates(latLng) {
            document.getElementById('latitude').value = latLng.lat;
            document.getElementById('longitude').value = latLng.lng;
            document.getElementById('coordinates').textContent = 
                `Lat: ${latLng.lat.toFixed(6)}, Lng: ${latLng.lng.toFixed(6)}`;
        }
        
        // Update koordinat saat peta diklik
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateCoordinates(e.latlng);
        });
        
        // Inisialisasi koordinat awal
        updateCoordinates(marker.getLatLng());
        
        // Fungsi untuk generate ID Tiket baru
        document.getElementById('refreshTicket').addEventListener('click', function() {
            const randomNum = Math.floor(100000000 + Math.random() * 900000000);
            document.getElementById('id_tiket').value = 'CSR' + randomNum;
            
            // Animasi refresh
            this.classList.add('rotating');
            setTimeout(() => {
                this.classList.remove('rotating');
            }, 500);
        });
    </script>
</body>
</html>