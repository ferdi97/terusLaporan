<?php
require_once '../../includes/auth.php';
require_once '../../includes/database.php';
require_once '../../includes/functions.php';

check_login();
check_role('HD'); // Hanya HD dan HO yang bisa akses

$teknisi = get_all_teknisi();
$jobdesk_options = ['FTTH', 'FLEXI', 'KABEL', 'WIRELESS'];
$sektor_options = ['SEKTOR 1', 'SEKTOR 2', 'SEKTOR 3', 'SEKTOR 4'];
$sto_options = ['STO A', 'STO B', 'STO C'];
$datel_options = ['DATEL A', 'DATEL B', 'DATEL C'];
$rayon_options = ['RAYON 1', 'RAYON 2', 'RAYON 3', 'RAYON 4', 'RAYON 5'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Teknisi - Sistem Tiket</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
<body>
    <?php include '../../includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include '../../includes/topbar.php'; ?>
        
        <div class="content-wrapper">
            <div class="page-header">
                <h1>Data Teknisi</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../../dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Teknisi</li>
                    </ol>
                </nav>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-actions">
                                <button class="btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#teknisiModal">
                                    <i class="fas fa-plus"></i> Tambah Teknisi
                                </button>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-filters mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select id="filter-jobdesk" class="form-control">
                                            <option value="">Semua Jobdesk</option>
                                            <?php foreach ($jobdesk_options as $job): ?>
                                            <option value="<?= $job ?>"><?= $job ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="filter-sektor" class="form-control">
                                            <option value="">Semua Sektor</option>
                                            <?php foreach ($sektor_options as $sektor): ?>
                                            <option value="<?= $sektor ?>"><?= $sektor ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="filter-sto" class="form-control">
                                            <option value="">Semua STO</option>
                                            <?php foreach ($sto_options as $sto): ?>
                                            <option value="<?= $sto ?>"><?= $sto ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" id="search-box" class="form-control" placeholder="Cari...">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table id="teknisiTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Jobdesk</th>
                                            <th>Sektor</th>
                                            <th>STO</th>
                                            <th>Rayon</th>
                                            <th>Datel</th>
                                            <th>Foto</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($teknisi as $t): ?>
                                        <tr>
                                            <td><?= $t['NIK'] ?></td>
                                            <td><?= $t['NAMA'] ?></td>
                                            <td><?= $t['JOBDESK'] ?></td>
                                            <td><?= $t['SEKTOR'] ?></td>
                                            <td><?= $t['STO'] ?></td>
                                            <td><?= $t['RAYON'] ?></td>
                                            <td><?= $t['DATEL'] ?></td>
                                            <td>
                                                <?php if (!empty($t['FOTO'])): ?>
                                                <img src="../../assets/images/teknisi/<?= $t['FOTO'] ?>" alt="Foto Teknisi" class="thumbnail-img">
                                                <?php else: ?>
                                                <span class="text-muted">No Photo</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info btn-edit" data-id="<?= $t['NIK'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger btn-delete" data-id="<?= $t['NIK'] ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add/Edit Teknisi -->
    <div class="modal fade" id="teknisiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Teknisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="teknisiForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="nik_old" name="nik_old">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" id="nik" name="nik" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" id="nama" name="nama" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jobdesk">Jobdesk</label>
                                    <select id="jobdesk" name="jobdesk" class="form-control" required>
                                        <option value="">Pilih Jobdesk</option>
                                        <?php foreach ($jobdesk_options as $job): ?>
                                        <option value="<?= $job ?>"><?= $job ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sektor">Sektor</label>
                                    <select id="sektor" name="sektor" class="form-control" required>
                                        <option value="">Pilih Sektor</option>
                                        <?php foreach ($sektor_options as $sektor): ?>
                                        <option value="<?= $sektor ?>"><?= $sektor ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sto">STO</label>
                                    <select id="sto" name="sto" class="form-control" required>
                                        <option value="">Pilih STO</option>
                                        <?php foreach ($sto_options as $sto): ?>
                                        <option value="<?= $sto ?>"><?= $sto ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="rayon">Rayon</label>
                                    <select id="rayon" name="rayon" class="form-control" required>
                                        <option value="">Pilih Rayon</option>
                                        <?php foreach ($rayon_options as $rayon): ?>
                                        <option value="<?= $rayon ?>"><?= $rayon ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="datel">Datel</label>
                                    <select id="datel" name="datel" class="form-control" required>
                                        <option value="">Pilih Datel</option>
                                        <?php foreach ($datel_options as $datel): ?>
                                        <option value="<?= $datel ?>"><?= $datel ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="foto">Foto Teknisi</label>
                            <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Maksimal 2MB.</small>
                            <div id="fotoPreview" class="mt-2"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete Confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus teknisi ini?</p>
                    <p class="text-danger"><strong>Data yang dihapus tidak dapat dikembalikan!</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/js/script.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            const table = $('#teknisiTable').DataTable({
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
                }
            });
            
            // Apply filters
            $('#filter-jobdesk, #filter-sektor, #filter-sto').on('change', function() {
                const columnIndex = $(this).attr('id') === 'filter-jobdesk' ? 2 : 
                                  ($(this).attr('id') === 'filter-sektor' ? 3 : 4);
                table.column(columnIndex).search(this.value).draw();
            });
            
            $('#search-box').on('keyup', function() {
                table.search(this.value).draw();
            });
            
            // Add button click
            $('.btn-add').click(function() {
                $('#modalTitle').text('Tambah Teknisi');
                $('#teknisiForm')[0].reset();
                $('#fotoPreview').empty();
                $('#nik_old').val('');
            });
            
            // Edit button click
            $('.btn-edit').click(function() {
                const nik = $(this).data('id');
                
                fetch(`get_teknisi.php?nik=${nik}`)
                    .then(response => response.json())
                    .then(data => {
                        $('#modalTitle').text('Edit Teknisi');
                        $('#nik_old').val(data.NIK);
                        $('#nik').val(data.NIK);
                        $('#nama').val(data.NAMA);
                        $('#jobdesk').val(data.JOBDESK);
                        $('#sektor').val(data.SEKTOR);
                        $('#sto').val(data.STO);
                        $('#rayon').val(data.RAYON);
                        $('#datel').val(data.DATEL);
                        
                        if (data.FOTO) {
                            $('#fotoPreview').html(`
                                <img src="../../assets/images/teknisi/${data.FOTO}" alt="Foto Teknisi" class="img-thumbnail" style="max-height: 150px;">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="deleteFoto" name="deleteFoto">
                                    <label class="form-check-label" for="deleteFoto">
                                        Hapus foto saat menyimpan
                                    </label>
                                </div>
                            `);
                        }
                        
                        $('#teknisiModal').modal('show');
                    });
            });
            
            // Delete button click
            $('.btn-delete').click(function() {
                const nik = $(this).data('id');
                $('#deleteModal').data('nik', nik).modal('show');
            });
            
            // Confirm delete
            $('#confirmDelete').click(function() {
                const nik = $('#deleteModal').data('nik');
                
                fetch('delete_teknisi.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `nik=${encodeURIComponent(nik)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('success', 'Berhasil', 'Teknisi berhasil dihapus');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showToast('error', 'Gagal', data.message || 'Gagal menghapus teknisi');
                    }
                    $('#deleteModal').modal('hide');
                });
            });
            
            // Form submission
            $('#teknisiForm').submit(function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                fetch('save_teknisi.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('success', 'Berhasil', data.message);
                        $('#teknisiModal').modal('hide');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showToast('error', 'Gagal', data.message);
                    }
                });
            });
            
            // Foto preview
            $('#foto').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#fotoPreview').html(`
                            <img src="${e.target.result}" alt="Preview Foto" class="img-thumbnail" style="max-height: 150px;">
                        `);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
        
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
    </script>
</body>
</html>