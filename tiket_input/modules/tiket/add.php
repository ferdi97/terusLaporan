<?php
require_once '../../includes/auth.php';
require_once '../../includes/database.php';
require_once '../../includes/functions.php';

check_login();
check_role('HD'); // Hanya HD yang bisa input tiket

$teknisi_list = get_all_teknisi();
$tipe_tiket_options = ['Gangguan', 'Pasang Baru', 'Migrasi', 'Complain'];
$flag_tiket_options = ['Critical', 'Major', 'Minor', 'Trivial'];
$sektor_options = ['SEKTOR 1', 'SEKTOR 2', 'SEKTOR 3', 'SEKTOR 4'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tiket - Sistem Tiket</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include '../../includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include '../../includes/topbar.php'; ?>
        
        <div class="content-wrapper">
            <div class="page-header">
                <h1>Tambah Tiket</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../../dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="../tiket/">Tiket</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Tiket</li>
                    </ol>
                </nav>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Input Tiket</h4>
                            <p>Anda dapat menambahkan hingga 10 tiket sekaligus</p>
                        </div>
                        
                        <div class="card-body">
                            <form id="tiketForm">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="tiketTable">
                                        <thead>
                                            <tr>
                                                <th>Report Date</th>
                                                <th>Booking Date</th>
                                                <th>Tipe Tiket</th>
                                                <th>Flag Tiket</th>
                                                <th>Sektor</th>
                                                <th>Datek ODP</th>
                                                <th>Teknisi</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Baris pertama -->
                                            <tr>
                                                <td>
                                                    <input type="datetime-local" name="reportdate[]" class="form-control" required>
                                                </td>
                                                <td>
                                                    <input type="datetime-local" name="bookingdate[]" class="form-control" required>
                                                </td>
                                                <td>
                                                    <select name="tipe_tiket[]" class="form-control" required>
                                                        <option value="">Pilih Tipe</option>
                                                        <?php foreach ($tipe_tiket_options as $tipe): ?>
                                                        <option value="<?= $tipe ?>"><?= $tipe ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="flag_tiket[]" class="form-control" required>
                                                        <option value="">Pilih Flag</option>
                                                        <?php foreach ($flag_tiket_options as $flag): ?>
                                                        <option value="<?= $flag ?>"><?= $flag ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="sektor[]" class="form-control" required>
                                                        <option value="">Pilih Sektor</option>
                                                        <?php foreach ($sektor_options as $sektor): ?>
                                                        <option value="<?= $sektor ?>"><?= $sektor ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="datek_odp[]" class="form-control" required>
                                                </td>
                                                <td>
                                                    <select name="teknisi[]" class="form-control" required>
                                                        <option value="">Pilih Teknisi</option>
                                                        <?php foreach ($teknisi_list as $teknisi): ?>
                                                        <option value="<?= $teknisi['NIK'] ?>"><?= $teknisi['NAMA'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-remove-row" disabled>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="form-group mt-3">
                                    <button type="button" class="btn btn-success" id="addRow">
                                        <i class="fas fa-plus"></i> Tambah Baris
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan Semua
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Preview Data -->
                    <div class="card mt-4" id="previewCard" style="display: none;">
                        <div class="card-header">
                            <h4>Preview Data Tiket</h4>
                            <p>Periksa data sebelum dikirim</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="previewTable">
                                    <thead>
                                        <tr>
                                            <th>ID Tiket</th>
                                            <th>Report Date</th>
                                            <th>Booking Date</th>
                                            <th>Tipe Tiket</th>
                                            <th>Flag</th>
                                            <th>Sektor</th>
                                            <th>Datek ODP</th>
                                            <th>Teknisi</th>
                                            <th>Status</th>
                                            <th>Kirim Telegram</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            
                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-success" id="sendAllTelegram">
                                    <i class="fab fa-telegram"></i> Kirim Semua ke Telegram
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/js/script.js"></script>
    <script>
        $(document).ready(function() {
            let rowCount = 1;
            const maxRows = 10;
            
            // Tambah baris
            $('#addRow').click(function() {
                if (rowCount < maxRows) {
                    const newRow = `
                        <tr>
                            <td>
                                <input type="datetime-local" name="reportdate[]" class="form-control" required>
                            </td>
                            <td>
                                <input type="datetime-local" name="bookingdate[]" class="form-control" required>
                            </td>
                            <td>
                                <select name="tipe_tiket[]" class="form-control" required>
                                    <option value="">Pilih Tipe</option>
                                    <?php foreach ($tipe_tiket_options as $tipe): ?>
                                    <option value="<?= $tipe ?>"><?= $tipe ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <select name="flag_tiket[]" class="form-control" required>
                                    <option value="">Pilih Flag</option>
                                    <?php foreach ($flag_tiket_options as $flag): ?>
                                    <option value="<?= $flag ?>"><?= $flag ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <select name="sektor[]" class="form-control" required>
                                    <option value="">Pilih Sektor</option>
                                    <?php foreach ($sektor_options as $sektor): ?>
                                    <option value="<?= $sektor ?>"><?= $sektor ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="datek_odp[]" class="form-control" required>
                            </td>
                            <td>
                                <select name="teknisi[]" class="form-control" required>
                                    <option value="">Pilih Teknisi</option>
                                    <?php foreach ($teknisi_list as $teknisi): ?>
                                    <option value="<?= $teknisi['NIK'] ?>"><?= $teknisi['NAMA'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-remove-row">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    
                    $('#tiketTable tbody').append(newRow);
                    rowCount++;
                    
                    if (rowCount === maxRows) {
                        $(this).prop('disabled', true);
                    }
                    
                    // Aktifkan tombol hapus di baris pertama
                    $('#tiketTable tbody tr:first .btn-remove-row').prop('disabled', false);
                }
            });
            
            // Hapus baris
            $(document).on('click', '.btn-remove-row', function() {
                if (rowCount > 1) {
                    $(this).closest('tr').remove();
                    rowCount--;
                    
                    $('#addRow').prop('disabled', false);
                    
                    // Jika hanya tersisa 1 baris, nonaktifkan tombol hapus
                    if (rowCount === 1) {
                        $('#tiketTable tbody tr:first .btn-remove-row').prop('disabled', true);
                    }
                }
            });
            
            // Submit form
            $('#tiketForm').submit(function(e) {
                e.preventDefault();
                
                const formData = $(this).serializeArray();
                
                // Validasi
                let isValid = true;
                $('#tiketTable tbody tr').each(function() {
                    $(this).find('input, select').each(function() {
                        if (!$(this).val()) {
                            $(this).addClass('is-invalid');
                            isValid = false;
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });
                });
                
                if (!isValid) {
                    alert('Harap isi semua field yang wajib diisi!');
                    return;
                }
                
                // Kirim data ke server
                $.ajax({
                    url: 'save_tiket.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        try {
                            const data = JSON.parse(response);
                            if (data.success) {
                                // Tampilkan preview
                                $('#previewCard').show();
                                const previewTable = $('#previewTable tbody');
                                previewTable.empty();
                                
                                data.tickets.forEach(ticket => {
                                    const row = `
                                        <tr data-id="${ticket.id_tiket}">
                                            <td>${ticket.id_tiket}</td>
                                            <td>${ticket.reportdate}</td>
                                            <td>${ticket.bookingdate}</td>
                                            <td>${ticket.tipe_tiket}</td>
                                            <td><span class="badge bg-${getFlagClass(ticket.flag_tiket)}">${ticket.flag_tiket}</span></td>
                                            <td>${ticket.sektor}</td>
                                            <td>${ticket.datek_odp}</td>
                                            <td>${ticket.teknisi_nama}</td>
                                            <td><span class="badge bg-warning">SISA</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-telegram btn-send-telegram" data-id="${ticket.id_tiket}">
                                                    <i class="fab fa-telegram"></i> Kirim
                                                </button>
                                            </td>
                                        </tr>
                                    `;
                                    previewTable.append(row);
                                });
                                
                                // Scroll ke preview
                                $('html, body').animate({
                                    scrollTop: $('#previewCard').offset().top
                                }, 500);
                            } else {
                                alert('Gagal menyimpan tiket: ' + (data.message || 'Terjadi kesalahan'));
                            }
                        } catch (e) {
                            alert('Terjadi kesalahan dalam memproses respons');
                            console.error(e);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            });
            
            // Kirim ke Telegram per tiket
            $(document).on('click', '.btn-send-telegram', function() {
                const ticketId = $(this).data('id');
                const btn = $(this);
                
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengirim...');
                
                $.ajax({
                    url: 'send_telegram.php',
                    type: 'POST',
                    data: { id_tiket: ticketId },
                    success: function(response) {
                        try {
                            const data = JSON.parse(response);
                            if (data.success) {
                                btn.removeClass('btn-telegram').addClass('btn-success')
                                   .html('<i class="fas fa-check"></i> Terkirim');
                                showToast('success', 'Berhasil', 'Tiket berhasil dikirim ke Telegram');
                            } else {
                                btn.prop('disabled', false).html('<i class="fab fa-telegram"></i> Kirim');
                                showToast('error', 'Gagal', data.message || 'Gagal mengirim ke Telegram');
                            }
                        } catch (e) {
                            btn.prop('disabled', false).html('<i class="fab fa-telegram"></i> Kirim');
                            showToast('error', 'Error', 'Terjadi kesalahan dalam memproses respons');
                            console.error(e);
                        }
                    },
                    error: function(xhr, status, error) {
                        btn.prop('disabled', false).html('<i class="fab fa-telegram"></i> Kirim');
                        showToast('error', 'Error', 'Terjadi kesalahan: ' + error);
                    }
                });
            });
            
            // Kirim semua ke Telegram
            $('#sendAllTelegram').click(function() {
                const btn = $(this);
                const sendButtons = $('.btn-send-telegram:not(.btn-success)');
                
                if (sendButtons.length === 0) {
                    showToast('info', 'Info', 'Semua tiket sudah dikirim ke Telegram');
                    return;
                }
                
                if (!confirm(`Anda yakin ingin mengirim ${sendButtons.length} tiket ke Telegram?`)) {
                    return;
                }
                
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengirim...');
                
                let successCount = 0;
                let failCount = 0;
                let processed = 0;
                
                sendButtons.each(function() {
                    const ticketId = $(this).data('id');
                    const currentBtn = $(this);
                    
                    currentBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengirim...');
                    
                    $.ajax({
                        url: 'send_telegram.php',
                        type: 'POST',
                        data: { id_tiket: ticketId },
                        success: function(response) {
                            try {
                                const data = JSON.parse(response);
                                if (data.success) {
                                    currentBtn.removeClass('btn-telegram').addClass('btn-success')
                                              .html('<i class="fas fa-check"></i> Terkirim');
                                    successCount++;
                                } else {
                                    currentBtn.prop('disabled', false)
                                              .html('<i class="fab fa-telegram"></i> Kirim');
                                    failCount++;
                                }
                            } catch (e) {
                                currentBtn.prop('disabled', false)
                                          .html('<i class="fab fa-telegram"></i> Kirim');
                                failCount++;
                                console.error(e);
                            }
                            
                            processed++;
                            checkCompletion();
                        },
                        error: function() {
                            currentBtn.prop('disabled', false)
                                      .html('<i class="fab fa-telegram"></i> Kirim');
                            failCount++;
                            processed++;
                            checkCompletion();
                        }
                    });
                });
                
                function checkCompletion() {
                    if (processed === sendButtons.length) {
                        btn.prop('disabled', false).html('<i class="fab fa-telegram"></i> Kirim Semua ke Telegram');
                        
                        let message = `Berhasil mengirim ${successCount} tiket`;
                        if (failCount > 0) {
                            message += `, gagal mengirim ${failCount} tiket`;
                        }
                        
                        showToast(
                            failCount === 0 ? 'success' : (successCount === 0 ? 'error' : 'warning'),
                            failCount === 0 ? 'Berhasil' : (successCount === 0 ? 'Gagal' : 'Peringatan'),
                            message
                        );
                    }
                }
            });
            
            function getFlagClass(flag) {
                switch (flag) {
                    case 'Critical': return 'danger';
                    case 'Major': return 'warning';
                    case 'Minor': return 'info';
                    case 'Trivial': return 'secondary';
                    default: return 'primary';
                }
            }
            
            function showToast(type, title, message) {
                const toast = $(`
                    <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                <strong>${title}</strong><br>${message}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                `);
                
                $('.toast-container').append(toast);
                const bsToast = new bootstrap.Toast(toast[0]);
                bsToast.show();
                
                setTimeout(() => {
                    bsToast.dispose();
                    toast.remove();
                }, 5000);
            }
        });
    </script>
</body>
</html>