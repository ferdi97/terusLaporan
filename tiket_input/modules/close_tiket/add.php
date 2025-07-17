<?php
require_once '../../includes/auth.php';
require_once '../../includes/database.php';
require_once '../../includes/functions.php';

check_login();
check_role(['Teknisi']); // Hanya teknisi yang bisa close tiket

$open_tickets = get_open_tickets_for_teknisi($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Close Tiket - Sistem Tiket</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include '../../includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include '../../includes/topbar.php'; ?>
        
        <div class="content-wrapper">
            <div class="page-header">
                <h1>Close Tiket</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../../dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="../close_tiket/">Close Tiket</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Close Tiket</li>
                    </ol>
                </nav>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Close Tiket</h4>
                            <p>Silakan pilih tiket yang akan di-close atau di-pending</p>
                        </div>
                        
                        <div class="card-body">
                            <form id="closeTiketForm" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="id_tiket">Pilih Tiket</label>
                                    <select id="id_tiket" name="id_tiket" class="form-control" required>
                                        <option value="">Pilih Tiket</option>
                                        <?php foreach ($open_tickets as $tiket): ?>
                                        <option value="<?= $tiket['id_tiket'] ?>" 
                                            data-reportdate="<?= $tiket['reportdate'] ?>"
                                            data-bookingdate="<?= $tiket['bookingdate'] ?>"
                                            data-tipe="<?= $tiket['tipe_tiket'] ?>"
                                            data-flag="<?= $tiket['flag_tiket'] ?>"
                                            data-sektor="<?= $tiket['sektor'] ?>"
                                            data-datek="<?= $tiket['datek_odp'] ?>"
                                            data-hd="<?= $tiket['nama_hd'] ?>">
                                            <?= $tiket['id_tiket'] ?> - <?= $tiket['tipe_tiket'] ?> - <?= $tiket['datek_odp'] ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="reportdate">Report Date</label>
                                            <input type="text" id="reportdate" name="reportdate" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bookingdate">Booking Date</label>
                                            <input type="text" id="bookingdate" name="bookingdate" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tipe_tiket">Tipe Tiket</label>
                                            <input type="text" id="tipe_tiket" name="tipe_tiket" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="flag_tiket">Flag Tiket</label>
                                            <input type="text" id="flag_tiket" name="flag_tiket" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sektor">Sektor</label>
                                            <input type="text" id="sektor" name="sektor" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="datek_odp">Datek ODP</label>
                                    <input type="text" id="datek_odp" name="datek_odp" class="form-control" readonly>
                                </div>
                                
                                <div class="form-group">
                                    <label for="nama_hd">Nama HD</label>
                                    <input type="text" id="nama_hd" name="nama_hd" class="form-control" readonly>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="">Pilih Status</option>
                                        <option value="CLOSE">CLOSE</option>
                                        <option value="PENDING">PENDING</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="rfo">RFO (Reason For Outage)</label>
                                    <textarea id="rfo" name="rfo" class="form-control" rows="3" required></textarea>
                                </div>
                                
                                <!-- Foto Section -->
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5>Dokumentasi Foto</h5>
                                        <p>Silakan ambil foto sesuai kebutuhan</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Swafoto Teknisi</label>
                                                    <div class="camera-container">
                                                        <video id="camera1" class="camera-preview" autoplay playsinline></video>
                                                        <canvas id="canvas1" class="d-none"></canvas>
                                                        <div class="camera-actions mt-2">
                                                            <select class="form-control camera-select mb-2">
                                                                <option value="">Pilih Kamera</option>
                                                            </select>
                                                            <button type="button" class="btn btn-primary btn-capture" data-target="1">
                                                                <i class="fas fa-camera"></i> Ambil Foto
                                                            </button>
                                                            <button type="button" class="btn btn-info btn-switch" data-target="1">
                                                                <i class="fas fa-sync-alt"></i> Ganti Kamera
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <input type="file" id="swafoto1" name="swafoto1" accept="image/*" class="d-none" required>
                                                    <input type="hidden" id="swafoto1_data" name="swafoto1_data">
                                                    <div id="preview1" class="preview-container mt-2"></div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Foto Rumah</label>
                                                    <div class="camera-container">
                                                        <video id="camera2" class="camera-preview" autoplay playsinline></video>
                                                        <canvas id="canvas2" class="d-none"></canvas>
                                                        <div class="camera-actions mt-2">
                                                            <select class="form-control camera-select mb-2">
                                                                <option value="">Pilih Kamera</option>
                                                            </select>
                                                            <button type="button" class="btn btn-primary btn-capture" data-target="2">
                                                                <i class="fas fa-camera"></i> Ambil Foto
                                                            </button>
                                                            <button type="button" class="btn btn-info btn-switch" data-target="2">
                                                                <i class="fas fa-sync-alt"></i> Ganti Kamera
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <input type="file" id="swafoto2" name="swafoto2" accept="image/*" class="d-none">
                                                    <input type="hidden" id="swafoto2_data" name="swafoto2_data">
                                                    <div id="preview2" class="preview-container mt-2"></div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Foto Material</label>
                                                    <div class="camera-container">
                                                        <video id="camera3" class="camera-preview" autoplay playsinline></video>
                                                        <canvas id="canvas3" class="d-none"></canvas>
                                                        <div class="camera-actions mt-2">
                                                            <select class="form-control camera-select mb-2">
                                                                <option value="">Pilih Kamera</option>
                                                            </select>
                                                            <button type="button" class="btn btn-primary btn-capture" data-target="3">
                                                                <i class="fas fa-camera"></i> Ambil Foto
                                                            </button>
                                                            <button type="button" class="btn btn-info btn-switch" data-target="3">
                                                                <i class="fas fa-sync-alt"></i> Ganti Kamera
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <input type="file" id="swafoto3" name="swafoto3" accept="image/*" class="d-none">
                                                    <input type="hidden" id="swafoto3_data" name="swafoto3_data">
                                                    <div id="preview3" class="preview-container mt-2"></div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Foto Redaman</label>
                                                    <div class="camera-container">
                                                        <video id="camera4" class="camera-preview" autoplay playsinline></video>
                                                        <canvas id="canvas4" class="d-none"></canvas>
                                                        <div class="camera-actions mt-2">
                                                            <select class="form-control camera-select mb-2">
                                                                <option value="">Pilih Kamera</option>
                                                            </select>
                                                            <button type="button" class="btn btn-primary btn-capture" data-target="4">
                                                                <i class="fas fa-camera"></i> Ambil Foto
                                                            </button>
                                                            <button type="button" class="btn btn-info btn-switch" data-target="4">
                                                                <i class="fas fa-sync-alt"></i> Ganti Kamera
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <input type="file" id="swafoto4" name="swafoto4" accept="image/*" class="d-none">
                                                    <input type="hidden" id="swafoto4_data" name="swafoto4_data">
                                                    <div id="preview4" class="preview-container mt-2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        <i class="fas fa-check-circle"></i> Submit Close Tiket
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/js/script.js"></script>
    <script>
        $(document).ready(function() {
            // Isi data tiket saat dipilih
            $('#id_tiket').change(function() {
                const selectedOption = $(this).find('option:selected');
                
                $('#reportdate').val(selectedOption.data('reportdate'));
                $('#bookingdate').val(selectedOption.data('bookingdate'));
                $('#tipe_tiket').val(selectedOption.data('tipe'));
                $('#flag_tiket').val(selectedOption.data('flag'));
                $('#sektor').val(selectedOption.data('sektor'));
                $('#datek_odp').val(selectedOption.data('datek'));
                $('#nama_hd').val(selectedOption.data('hd'));
            });
            
            // Inisialisasi kamera
            initializeCameras();
            
            // Tangkap foto
            $(document).on('click', '.btn-capture', function() {
                const target = $(this).data('target');
                capturePhoto(target);
            });
            
            // Ganti kamera
            $(document).on('click', '.btn-switch', function() {
                const target = $(this).data('target');
                switchCamera(target);
            });
            
            // Submit form
            $('#closeTiketForm').submit(function(e) {
                e.preventDefault();
                
                // Validasi
                if (!$('#id_tiket').val()) {
                    alert('Silakan pilih tiket terlebih dahulu');
                    return;
                }
                
                if (!$('#status').val()) {
                    alert('Silakan pilih status tiket');
                    return;
                }
                
                if (!$('#rfo').val()) {
                    alert('Silakan isi RFO (Reason For Outage)');
                    return;
                }
                
                if (!$('#swafoto1_data').val()) {
                    alert('Silakan ambil swafoto teknisi');
                    return;
                }
                
                // Kirim data
                const formData = new FormData(this);
                
                $.ajax({
                    url: 'save_close_tiket.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('button[type="submit"]').prop('disabled', true)
                            .html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
                    },
                    success: function(response) {
                        try {
                            const data = JSON.parse(response);
                            if (data.success) {
                                alert('Tiket berhasil di-close/di-pending');
                                window.location.href = '../close_tiket/';
                            } else {
                                alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
                            }
                        } catch (e) {
                            alert('Terjadi kesalahan dalam memproses respons');
                            console.error(e);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    },
                    complete: function() {
                        $('button[type="submit"]').prop('disabled', false)
                            .html('<i class="fas fa-check-circle"></i> Submit Close Tiket');
                    }
                });
            });
        });
        
        // Fungsi kamera
        let cameras = {};
        let streams = {};
        
        async function initializeCameras() {
            try {
                const devices = await navigator.mediaDevices.enumerateDevices();
                const videoDevices = devices.filter(device => device.kind === 'videoinput');
                
                if (videoDevices.length === 0) {
                    console.warn('Tidak ada kamera yang terdeteksi');
                    return;
                }
                
                // Isi pilihan kamera
                videoDevices.forEach((device, index) => {
                    $('.camera-select').append(`<option value="${device.deviceId}">Kamera ${index + 1}</option>`);
                });
                
                // Inisialisasi kamera untuk setiap video
                for (let i = 1; i <= 4; i++) {
                    await setupCamera(i, videoDevices[0].deviceId);
                }
            } catch (error) {
                console.error('Error accessing cameras:', error);
                alert('Gagal mengakses kamera: ' + error.message);
            }
        }
        
        async function setupCamera(target, deviceId) {
            const video = document.getElementById(`camera${target}`);
            
            // Hentikan stream yang ada
            if (streams[target]) {
                streams[target].getTracks().forEach(track => track.stop());
            }
            
            try {
                const constraints = {
                    video: {
                        deviceId: { exact: deviceId },
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    }
                };
                
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = stream;
                streams[target] = stream;
                cameras[target] = deviceId;
                
                // Set pilihan kamera
                $(`#camera${target}`).siblings('.camera-actions').find('.camera-select').val(deviceId);
            } catch (error) {
                console.error(`Error setting up camera ${target}:`, error);
                alert(`Gagal mengakses kamera ${target}: ` + error.message);
            }
        }
        
        function capturePhoto(target) {
            const video = document.getElementById(`camera${target}`);
            const canvas = document.getElementById(`canvas${target}`);
            const preview = document.getElementById(`preview${target}`);
            
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            
            const imageData = canvas.toDataURL('image/jpeg');
            $(`#swafoto${target}_data`).val(imageData);
            
            preview.innerHTML = `
                <div class="photo-preview">
                    <img src="${imageData}" alt="Preview Foto ${target}" class="img-thumbnail">
                    <button type="button" class="btn btn-sm btn-danger btn-remove-photo" data-target="${target}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
        }
        
        async function switchCamera(target) {
            const currentDeviceId = cameras[target];
            const select = $(`#camera${target}`).siblings('.camera-actions').find('.camera-select')[0];
            const options = Array.from(select.options);
            const currentIndex = options.findIndex(opt => opt.value === currentDeviceId);
            const nextIndex = (currentIndex + 1) % options.length;
            
            if (options[nextIndex].value) {
                await setupCamera(target, options[nextIndex].value);
            }
        }
        
        // Hapus foto
        $(document).on('click', '.btn-remove-photo', function() {
            const target = $(this).data('target');
            $(`#preview${target}`).empty();
            $(`#swafoto${target}_data`).val('');
        });
    </script>
</body>
</html>