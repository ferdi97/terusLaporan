<?php
date_default_timezone_set('Asia/Makassar'); // Set zona waktu ke WITA (Asia/Makassar)
// Daftar STO
$sto_list = array(
    "SMR1", "SMR2", "LMP", "TMD", "LOB", "SEM", 
    "SGK", "BOT1", "BOT2", "STT1", "STT2", 
    "SBR", "MLA", "TGG"
);

// Proses form jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik_teknisi = htmlspecialchars($_POST['nik_teknisi']);
    $nama_teknisi = htmlspecialchars($_POST['nama_teknisi']);
    $sto = htmlspecialchars($_POST['sto']);
    $latitude = htmlspecialchars($_POST['latitude']);
    $longitude = htmlspecialchars($_POST['longitude']);
    
    // Proses gambar swafoto
    if (isset($_FILES['swafoto']) && $_FILES['swafoto']['error'] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // Generate nama file unik
        $new_filename = uniqid() . '.jpg';
        $target_file = $target_dir . $new_filename;
        
        // Check jika file adalah gambar
        $check = getimagesize($_FILES["swafoto"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["swafoto"]["tmp_name"], $target_file)) {
                // Simpan data ke database atau file
                $data = array(
                    'nik' => $nik_teknisi,
                    'nama' => $nama_teknisi,
                    'sto' => $sto,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'foto' => $new_filename,
                    'waktu' => date('Y-m-d H:i:s'),
                    'timezone' => 'WITA'
                );
                
                // Simpan ke file JSON (bisa diganti dengan database)
                file_put_contents('data_teknisi.json', json_encode($data) . "\n", FILE_APPEND);
                
                echo "<script>
                    alert('Data berhasil disimpan!');
                    window.location.href = 'index.php';
                </script>";
            } else {
                echo "<script>alert('Maaf, terjadi error saat upload file.');</script>";
            }
        } else {
            echo "<script>alert('File bukan gambar.');</script>";
        }
    } else {
        echo "<script>alert('Harap mengambil swafoto.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Form Teknisi | Aplikasi Lapangan</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --danger-color: #f72585;
            --success-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: var(--dark-color);
            line-height: 1.6;
            padding: 0;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .header h1 {
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .container {
            flex: 1;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 1rem;
        }
        
        .form-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 1rem;
        }
        
        .form-header {
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 1rem;
            font-size: 1.1rem;
            font-weight: 500;
        }
        
        .form-body {
            padding: 1rem;
        }
        
        .form-group {
            margin-bottom: 1.25rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-color);
            font-size: 0.9rem;
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.95rem;
            transition: border 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.2);
        }
        
        #map {
            height: 250px;
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-top: 0.5rem;
        }
        
        .map-info {
            font-size: 0.8rem;
            color: #666;
            margin-top: 0.25rem;
            text-align: center;
        }
        
        .camera-section {
            margin-top: 1rem;
        }
        
        .camera-container {
            position: relative;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            border-radius: 8px;
            overflow: hidden;
            background-color: #f0f0f0;
            aspect-ratio: 3/4;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        #camera-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        #photo-result {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }
        
        .camera-buttons {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            margin-top: 1rem;
        }
        
        .btn {
            padding: 0.75rem 1.25rem;
            border: none;
            border-radius: 8px;
            font-family: inherit;
            font-weight: 500;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #d11465;
        }
        
        .btn-success {
            background-color: var(--success-color);
            color: white;
        }
        
        .btn-success:hover {
            background-color: #3ab0d6;
        }
        
        .btn-block {
            display: block;
            width: 100%;
        }
        
        .btn-icon {
            font-size: 1.2rem;
        }
        
        #file-input {
            display: none;
        }
        
        .location-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            font-size: 0.85rem;
            color: #666;
        }
        
        .location-status .icon {
            font-size: 1rem;
        }
        
        .footer {
            text-align: center;
            padding: 1rem;
            font-size: 0.8rem;
            color: #666;
            background-color: white;
            border-top: 1px solid #eee;
        }
        
        /* Camera select dropdown */
        #camera-select {
            margin-top: 0.5rem;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 0.75rem;
            font-family: inherit;
            font-size: 0.95rem;
            width: 100%;
        }
        
        #camera-select:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.2);
        }
        
        /* Responsive adjustments */
        @media (min-width: 768px) {
            .header h1 {
                font-size: 1.8rem;
            }
            
            .form-body {
                padding: 1.5rem;
            }
            
            #map {
                height: 300px;
            }
            
            .camera-container {
                max-width: 350px;
            }
        }
        
        @media (max-width: 480px) {
            .form-control {
                padding: 0.65rem;
            }
            
            .btn {
                padding: 0.65rem 1rem;
                font-size: 0.9rem;
            }
        }
        
        /* Loading spinner */
        .spinner {
            display: none;
            width: 24px;
            height: 24px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Animation for camera */
        @keyframes flash {
            0% { opacity: 0; }
            50% { opacity: 1; }
            100% { opacity: 0; }
        }
        
        .flash-effect {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            opacity: 0;
            pointer-events: none;
        }
        
        .flashing {
            animation: flash 0.5s;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Form Data Teknisi Lapangan</h1>
    </div>
    
    <div class="container">
        <form id="teknisiForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-container">
                <div class="form-header">
                    <span>Informasi Teknisi</span>
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <label for="nik_teknisi">NIK TEKNISI</label>
                        <input type="text" class="form-control" id="nik_teknisi" name="nik_teknisi" placeholder="Masukkan NIK" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama_teknisi">NAMA TEKNISI</label>
                        <input type="text" class="form-control" id="nama_teknisi" name="nama_teknisi" placeholder="Masukkan Nama Lengkap" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="sto">STO</label>
                        <select class="form-control" id="sto" name="sto" required>
                            <option value="">-- Pilih STO --</option>
                            <?php foreach ($sto_list as $sto): ?>
                                <option value="<?php echo $sto; ?>"><?php echo $sto; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-container">
                <div class="form-header">
                    <span>Lokasi Saat Ini</span>
                </div>
                <div class="form-body">
                    <div id="map"></div>
                    <p class="map-info">Lokasi Anda akan otomatis terdeteksi</p>
                    <div class="location-status">
                        <span class="icon">📍</span>
                        <span id="locationStatus">Mendeteksi lokasi...</span>
                    </div>
                    <input type="hidden" id="latitude" name="latitude" required>
                    <input type="hidden" id="longitude" name="longitude" required>
                </div>
            </div>
            
            <div class="form-container">
                <div class="form-header">
                    <span>Swafoto</span>
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <label for="camera-select">Pilih Kamera</label>
                        <select class="form-control" id="camera-select">
                            <option value="environment">Kamera Belakang</option>
                            <option value="user">Kamera Depan</option>
                        </select>
                    </div>
                    
                    <div class="camera-section">
                        <div class="camera-container">
                            <video id="camera-preview" autoplay playsinline></video>
                            <img id="photo-result" alt="Foto hasil capture">
                            <div class="flash-effect" id="flashEffect"></div>
                        </div>
                        
                        <div class="camera-buttons">
                            <button type="button" id="capture-btn" class="btn btn-primary">
                                <span class="btn-icon">📷</span> Ambil Foto
                            </button>
                            <button type="button" id="retake-btn" class="btn btn-danger" style="display:none;">
                                <span class="btn-icon">🔄</span> Ulangi
                            </button>
                        </div>
                        
                        <input type="file" id="file-input" name="swafoto" accept="image/*" capture="environment">
                    </div>
                </div>
            </div>
            
            <button type="submit" id="submit-btn" class="btn btn-success btn-block">
                <span id="submit-text">Simpan Data</span>
                <span class="spinner" id="submit-spinner"></span>
            </button>
        </form>
    </div>
    
    <div class="footer">
        Aplikasi Teknisi Lapangan &copy; <?php echo date('Y'); ?>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Inisialisasi variabel
        let map;
        let marker;
        let defaultLat = -6.2088;
        let defaultLng = 106.8456;
        let userLocated = false;
        let stream = null;
        let currentFacingMode = 'environment';
        
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            initCamera();
            setupForm();
        });
        
        function initMap() {
            // Buat peta dengan view default
            map = L.map('map', {
                zoomControl: false,
                dragging: !L.Browser.mobile
            }).setView([defaultLat, defaultLng], 13);
            
            // Tambahkan tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Tambahkan marker (tidak bisa dipindah)
            marker = L.marker([defaultLat, defaultLng], {
                draggable: false,
                autoPan: true
            }).addTo(map);
            
            // Set nilai default untuk input latitude dan longitude
            document.getElementById('latitude').value = defaultLat;
            document.getElementById('longitude').value = defaultLng;
            
            // Coba dapatkan lokasi pengguna
            locateUser();
        }
        
        function locateUser() {
            const locationStatus = document.getElementById('locationStatus');
            
            if (navigator.geolocation) {
                locationStatus.textContent = "Mendeteksi lokasi...";
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;
                        
                        // Pindahkan peta ke lokasi pengguna
                        map.setView([userLat, userLng], 17);
                        marker.setLatLng([userLat, userLng]);
                        
                        // Update input koordinat
                        document.getElementById('latitude').value = userLat;
                        document.getElementById('longitude').value = userLng;
                        
                        locationStatus.textContent = "Lokasi berhasil dideteksi";
                        locationStatus.innerHTML += ` (${userLat.toFixed(6)}, ${userLng.toFixed(6)})`;
                        userLocated = true;
                    },
                    function(error) {
                        console.error("Error getting location: ", error);
                        let errorMessage = "Tidak dapat mendapatkan lokasi: ";
                        
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += "Izin ditolak";
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += "Informasi lokasi tidak tersedia";
                                break;
                            case error.TIMEOUT:
                                errorMessage += "Permintaan lokasi timeout";
                                break;
                            default:
                                errorMessage += "Error tidak diketahui";
                        }
                        
                        locationStatus.textContent = errorMessage;
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                locationStatus.textContent = "Geolokasi tidak didukung oleh browser Anda";
            }
        }
        
        // Function to start camera with selected facing mode
        function startCamera(facingMode) {
            stopCamera(); // Stop any existing stream
            
            const video = document.getElementById('camera-preview');
            
            navigator.mediaDevices.getUserMedia({ 
                video: { 
                    facingMode: facingMode,
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                } 
            })
            .then(function(mediaStream) {
                stream = mediaStream;
                video.srcObject = mediaStream;
                currentFacingMode = facingMode;
                
                video.onloadedmetadata = function() {
                    adjustVideoOrientation();
                };
            })
            .catch(function(error) {
                console.error("Error accessing camera: ", error);
                handleCameraError();
            });
        }
        
        // Function to stop camera
        function stopCamera() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        }
        
        // Function to handle camera error
        function handleCameraError() {
            const video = document.getElementById('camera-preview');
            const fileInput = document.getElementById('file-input');
            const captureBtn = document.getElementById('capture-btn');
            
            video.style.display = 'none';
            fileInput.style.display = 'block';
            captureBtn.style.display = 'none';
            
            // Buat elemen untuk meminta akses kamera
            const cameraError = document.createElement('div');
            cameraError.innerHTML = `
                <p style="text-align: center; color: #666; margin-bottom: 1rem;">
                    Kamera tidak dapat diakses. Silakan gunakan tombol di bawah untuk upload foto.
                </p>
            `;
            video.parentNode.insertBefore(cameraError, video.nextSibling);
        }
        
        // Function to adjust video orientation
        function adjustVideoOrientation() {
            const video = document.getElementById('camera-preview');
            const isPortrait = window.matchMedia("(orientation: portrait)").matches;
            if (isPortrait) {
                video.style.transform = 'rotate(0deg)';
            } else {
                video.style.transform = 'rotate(90deg)';
            }
        }
        
        function initCamera() {
            const video = document.getElementById('camera-preview');
            const photoResult = document.getElementById('photo-result');
            const captureBtn = document.getElementById('capture-btn');
            const retakeBtn = document.getElementById('retake-btn');
            const fileInput = document.getElementById('file-input');
            const flashEffect = document.getElementById('flashEffect');
            const cameraSelect = document.getElementById('camera-select');
            
            // Start with default camera (back)
            startCamera(currentFacingMode);
            
            // Handle camera selection change
            cameraSelect.addEventListener('change', function() {
                const facingMode = this.value;
                startCamera(facingMode);
            });
            
            // Tangkap foto
            captureBtn.addEventListener('click', function() {
                // Efek flash
                flashEffect.classList.add('flashing');
                
                // Buat canvas untuk menangkap gambar
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const ctx = canvas.getContext('2d');
                
                // Tunggu efek flash selesai sebelum capture
                setTimeout(function() {
                    // Gambar video ke canvas
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                    
                    // Tampilkan hasil foto
                    photoResult.src = canvas.toDataURL('image/jpeg');
                    photoResult.style.display = 'block';
                    video.style.display = 'none';
                    captureBtn.style.display = 'none';
                    retakeBtn.style.display = 'inline-block';
                    
                    // Buat blob dari canvas dan set sebagai file input
                    canvas.toBlob(function(blob) {
                        const file = new File([blob], 'swafoto.jpg', { type: 'image/jpeg' });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        fileInput.files = dataTransfer.files;
                    }, 'image/jpeg');
                    
                    // Hentikan efek flash
                    setTimeout(function() {
                        flashEffect.classList.remove('flashing');
                    }, 500);
                }, 250);
            });
            
            // Ulangi foto
            retakeBtn.addEventListener('click', function() {
                photoResult.style.display = 'none';
                video.style.display = 'block';
                captureBtn.style.display = 'inline-block';
                retakeBtn.style.display = 'none';
                fileInput.value = '';
            });
            
            // Handle perubahan orientasi perangkat
            window.addEventListener('orientationchange', function() {
                if (video.srcObject) {
                    adjustVideoOrientation();
                }
            });
        }
        
        function setupForm() {
            const form = document.getElementById('teknisiForm');
            const submitBtn = document.getElementById('submit-btn');
            const submitText = document.getElementById('submit-text');
            const submitSpinner = document.getElementById('submit-spinner');
            
            form.addEventListener('submit', function(e) {
                // Validasi lokasi
                if (!userLocated) {
                    e.preventDefault();
                    alert('Harap tunggu hingga lokasi terdeteksi atau aktifkan izin lokasi.');
                    return;
                }
                
                // Validasi foto
                const fileInput = document.getElementById('file-input');
                if (!fileInput.files || fileInput.files.length === 0) {
                    e.preventDefault();
                    alert('Harap mengambil swafoto terlebih dahulu.');
                    return;
                }
                
                // Tampilkan loading
                submitText.textContent = "Menyimpan...";
                submitSpinner.style.display = 'inline-block';
                submitBtn.disabled = true;
            });
        }
    </script>
</body>
</html>