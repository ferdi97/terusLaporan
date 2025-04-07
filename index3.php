<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaporan Keluhan Pelanggan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --success-color: #4ad66d;
            --warning-color: #f8961e;
            --danger-color: #f94144;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem;
            text-align: center;
        }

        .card-header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .card-header p {
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .card-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-color);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
        }

        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-block {
            display: block;
            width: 100%;
        }

        .btn-location {
            background-color: var(--accent-color);
            margin-top: 0.5rem;
        }

        .btn-location:hover {
            background-color: #3aa8d8;
        }

        .location-info {
            display: flex;
            align-items: center;
            margin-top: 0.5rem;
            padding: 0.5rem;
            background-color: #f8f9fa;
            border-radius: 6px;
            font-size: 0.9rem;
        }

        .location-info i {
            margin-right: 0.5rem;
            color: var(--primary-color);
        }

        .ticket-display {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            text-align: center;
            border-left: 4px solid var(--primary-color);
        }

        .ticket-display h3 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .ticket-number {
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .status-message {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            text-align: center;
            display: none;
        }

        .success {
            background-color: rgba(74, 214, 109, 0.2);
            border-left: 4px solid var(--success-color);
            color: var(--success-color);
        }

        .error {
            background-color: rgba(249, 65, 68, 0.2);
            border-left: 4px solid var(--danger-color);
            color: var(--danger-color);
        }

        .loading {
            display: none;
            text-align: center;
            margin: 1rem 0;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(67, 97, 238, 0.2);
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .map-container {
            height: 200px;
            margin-top: 1rem;
            border-radius: 6px;
            overflow: hidden;
            display: none;
        }

        .footer {
            text-align: center;
            margin-top: 2rem;
            color: var(--gray-color);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .container {
                margin: 1rem auto;
                padding: 0 0.5rem;
            }

            .card-header h1 {
                font-size: 1.5rem;
            }

            .card-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1><i class="fas fa-headset"></i> Pelaporan Keluhan Pelanggan</h1>
                <p>Silakan isi form berikut untuk melaporkan keluhan Anda</p>
            </div>
            <div class="card-body">
                <div class="ticket-display">
                    <h3>Nomor Tiket Anda</h3>
                    <div class="ticket-number" id="ticketNumber">ID-<span id="generatedTicket"></span></div>
                    <small>Simpan nomor ini untuk pelacakan keluhan Anda</small>
                </div>

                <div class="status-message" id="statusMessage"></div>

                <form id="complaintForm">
                    <div class="form-group">
                        <label for="nomor_internet">Nomor Internet / Pelanggan</label>
                        <input type="text" class="form-control" id="nomor_internet" name="nomor_internet" required placeholder="Contoh: 162333333333 / 0541234567">
                    </div>

                    <div class="form-group">
                        <label for="nama_pelapor">Nama Pelapor</label>
                        <input type="text" class="form-control" id="nama_pelapor" name="nama_pelapor" required placeholder="Nama lengkap Anda">
                    </div>

                    <div class="form-group">
                        <label for="no_hp_pelapor">Nomor HP yang Dapat Dihubungi</label>
                        <input type="tel" class="form-control" id="no_hp_pelapor" name="no_hp_pelapor" required placeholder="Contoh: 081234567890">
                    </div>

                    <div class="form-group">
                        <label for="alamat_lengkap">Alamat Lengkap</label>
                        <input type="text" class="form-control" id="alamat_lengkap" name="alamat_lengkap" required placeholder="Alamat lengkap sesuai layanan">
                    </div>

                    <div class="form-group">
                        <label for="keluhan">Detail Keluhan</label>
                        <textarea class="form-control" id="keluhan" name="keluhan" required placeholder="Jelaskan keluhan Anda secara detail"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Lokasi (Opsional)</label>
                        <button type="button" class="btn btn-location" id="getLocation">
                            <i class="fas fa-map-marker-alt"></i> Bagikan Lokasi Saya
                        </button>
                        <div class="location-info" id="locationInfo" style="display: none;">
                            <i class="fas fa-check-circle"></i>
                            <span id="locationText">Lokasi telah dibagikan</span>
                        </div>
                        <div class="map-container" id="mapContainer"></div>
                        <input type="hidden" id="share_location" name="share_location">
                    </div>

                    <input type="hidden" id="kd_tiket" name="kd_tiket">

                    <div class="loading" id="loadingIndicator">
                        <div class="spinner"></div>
                        <p>Mengirim data...</p>
                    </div>

                    <button type="submit" class="btn btn-block">
                        <i class="fas fa-paper-plane"></i> Kirim Laporan
                    </button>
                </form>
            </div>
        </div>

        <div class="footer">
            <p>&copy; 2023 Layanan Pelanggan. Semua hak dilindungi.</p>
        </div>
    </div>

    <!-- Leaflet JS untuk peta -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Generate random ticket number
            const generateTicketNumber = () => {
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                let result = '';
                for (let i = 0; i < 8; i++) {
                    result += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                return result;
            };

            const ticketNumber = 'ID-' + generateTicketNumber();
            document.getElementById('generatedTicket').textContent = ticketNumber.split('-')[1];
            document.getElementById('kd_tiket').value = ticketNumber;

            // Handle location sharing
            const getLocationBtn = document.getElementById('getLocation');
        const locationInfo = document.getElementById('locationInfo');
        const locationText = document.getElementById('locationText');
        const mapContainer = document.getElementById('mapContainer');
        const shareLocationInput = document.getElementById('share_location');
        let map = null;
        let marker = null;

        function updateLocation(lat, lng) {
            const locationString = `${lat},${lng}`;
            shareLocationInput.value = locationString;
            locationText.textContent = `Lokasi: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            
            if (marker) {
                marker.setLatLng([lat, lng]);
            }
        }

        getLocationBtn.addEventListener('click', function() {
            if (navigator.geolocation) {
                getLocationBtn.disabled = true;
                getLocationBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mendapatkan lokasi...';

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        
                        updateLocation(latitude, longitude);
                        locationInfo.style.display = 'flex';
                        
                        // Show map
                        mapContainer.style.display = 'block';
                        if (!map) {
                            map = L.map('mapContainer').setView([latitude, longitude], 15);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);
                            
                            // Buat marker yang bisa di-drag
                            marker = L.marker([latitude, longitude], {
                                draggable: true
                            }).addTo(map)
                                .bindPopup('Lokasi Anda (Geser untuk memindahkan)')
                                .openPopup();
                            
                            // Event ketika marker dipindahkan
                            marker.on('dragend', function(event) {
                                const marker = event.target;
                                const position = marker.getLatLng();
                                updateLocation(position.lat, position.lng);
                            });
                        } else {
                            map.setView([latitude, longitude], 15);
                            marker.setLatLng([latitude, longitude]);
                        }
                        
                        getLocationBtn.disabled = false;
                        getLocationBtn.innerHTML = '<i class="fas fa-map-marker-alt"></i> Perbarui Lokasi Saya';
                    },
                    function(error) {
                        let errorMessage = 'Gagal mendapatkan lokasi: ';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += "Anda menolak permintaan lokasi.";
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += "Informasi lokasi tidak tersedia.";
                                break;
                            case error.TIMEOUT:
                                errorMessage += "Permintaan lokasi timeout.";
                                break;
                            case error.UNKNOWN_ERROR:
                                errorMessage += "Terjadi kesalahan yang tidak diketahui.";
                                break;
                        }
                        
                        alert(errorMessage);
                        getLocationBtn.disabled = false;
                        getLocationBtn.innerHTML = '<i class="fas fa-map-marker-alt"></i> Bagikan Lokasi Saya';
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                alert("Browser Anda tidak mendukung geolokasi.");
            }
        });


            // Handle form submission
            const complaintForm = document.getElementById('complaintForm');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const statusMessage = document.getElementById('statusMessage');

            complaintForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show loading indicator
                loadingIndicator.style.display = 'block';
                statusMessage.style.display = 'none';
                
                // Prepare form data
                const formData = {
                    nomor_internet: document.getElementById('nomor_internet').value,
                    nama_pelapor: document.getElementById('nama_pelapor').value,
                    no_hp_pelapor: document.getElementById('no_hp_pelapor').value,
                    alamat_lengkap: document.getElementById('alamat_lengkap').value,
                    keluhan: document.getElementById('keluhan').value,
                    share_location: shareLocationInput.value,
                    kd_tiket: document.getElementById('kd_tiket').value
                };
                
                // Send data to server
                fetch('insert_data.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    loadingIndicator.style.display = 'none';
                    
                    if (data.status === 'success') {
                        statusMessage.className = 'status-message success';
                        statusMessage.innerHTML = `<i class="fas fa-check-circle"></i> ${data.message}`;
                        
                        // Optional: Reset form or show success details
                        // complaintForm.reset();
                    } else {
                        statusMessage.className = 'status-message error';
                        statusMessage.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${data.message}`;
                    }
                    
                    statusMessage.style.display = 'block';
                    
                    // Scroll to status message
                    statusMessage.scrollIntoView({ behavior: 'smooth' });
                })
                .catch(error => {
                    loadingIndicator.style.display = 'none';
                    statusMessage.className = 'status-message error';
                    statusMessage.innerHTML = `<i class="fas fa-exclamation-circle"></i> Terjadi kesalahan: ${error.message}`;
                    statusMessage.style.display = 'block';
                    statusMessage.scrollIntoView({ behavior: 'smooth' });
                });
            });

            // Input validation
            const noHpInput = document.getElementById('no_hp_pelapor');
            noHpInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
    </script>
</body>
</html>