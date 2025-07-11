<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- In index.php head section -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Lapor Gangguan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="styles.css">
    <script>
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        document.addEventListener('keydown', function(e) {
            // Menonaktifkan F12  
            if (e.key === 'F12') {
                e.preventDefault();
            }
            // Menonaktifkan Ctrl+Shift+I ment)
            if (e.ctrlKey && e.shiftKey && e.key === 'I') {
                e.preventDefault();
            }
            // Menonaktifkan Ctrl+Shift+J (Console)
            if (e.ctrlKey && e.shiftKey && e.key === 'J') {
                e.preventDefault();
            }
            // Menonaktifkan Ctrl+U (View Source)
            if (e.ctrlKey && e.key === 'U') {
                e.preventDefault();
            }
        });
    </script>
</head>

<body>
    <div class="container">
        <div class="image-container">
            <img src="img/indi.png" alt="Placeholder Image" class="image-1">
            <img src="img/indi.png" alt="Placeholder Image" class="image-2">
        </div>
        <div class="separator">
            <div class="dot red"></div>
            <div class="dot green"></div>
            <div class="dot blue"></div>
        </div>
        <div class="form-container">
            <h1>LAPOR GANGGUAN</h1>
            <form id="data-form" action="" method="post">
                <div class="form-group">
                    <input type="text" id="kd-tiket" name="kd_tiket" placeholder=" " readonly required>
                    <label for="kd-tiket">ID TIKET</label>
                </div>
                <div class="form-group">
                    <input type="text" id="nomor-internet" name="nomor_internet" placeholder=" " required>
                    <label for="nomor-internet">Nomor Internet</label>
                </div>
                <div class="form-group">
                    <input type="text" id="nama-pelapor" name="nama_pelapor" placeholder=" " required>
                    <label for="nama-pelapor">Nama Pelapor</label>
                </div>
                <div class="form-group">
                    <input type="tel" id="no-hp-pelapor" name="no_hp_pelapor" placeholder=" " required>
                    <label for="no-hp-pelapor">No HP Pelapor</label>
                </div>
                <div class="form-group">
                    <textarea id="alamat-lengkap" rows="3" name="alamat_lengkap" placeholder=" " required></textarea>
                    <label for="alamat-lengkap">Alamat Lengkap</label>
                </div>

                <div class="form-group">
                    <textarea id="keluhan-gangguan" rows="3" name="keluhan" placeholder=" " required></textarea>
                    <label for="keluhan-gangguan">Keluhan Gangguan</label>
                </div>
                <div class="form-group">
                    <div class="map-container">
                        <div id="map" style="height: 300px;"></div>
                    </div>
                    <label for="share-location"></label>
                    <input type="text" id="share-location" name="share_location" placeholder=" " readonly required>
                    <button type="button" id="shareButton" onclick="getCurrentLocation()">Bagikan Lokasi</button>
                </div>
                <button type="submit" id="submit-button">Simpan</button>
            </form>
        </div>
    </div>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="scripts.js"></script>
</body>

</html>