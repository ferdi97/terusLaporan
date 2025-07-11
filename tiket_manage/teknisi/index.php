<?php 
include '../includes/functions.php';
$teknisi = readJson('data/teknisi.json');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Teknisi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-tools"></i>
            <span>TechTicket</span>
        </div>
        <ul class="menu">
            <li><a href="../index.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="active"><a href=""><i class="fas fa-user-cog"></i> Teknisi</a></li>
            <li><a href="../hd/"><i class="fas fa-user-tie"></i> HD</a></li>
            <li><a href="../tiket/"><i class="fas fa-ticket-alt"></i> Tiket</a></li>
            <li><a href="../close/"><i class="fas fa-check-circle"></i> Close Tiket</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Data Teknisi</h1>
            <div class="user-profile">
                <img src="../assets/images/user.png" alt="User">
                <span>Admin</span>
            </div>
        </div>

        <div class="card animated fadeIn">
            <div class="card-header">
                <h3>Daftar Teknisi</h3>
                <div class="card-actions">
                    <button class="btn btn-primary" onclick="location.href='create.php'">
                        <i class="fas fa-plus"></i> Tambah Teknisi
                    </button>
                    <div class="search-box">
                        <input type="text" id="searchInput" placeholder="Cari teknisi...">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="filter-section">
                    <select id="filterSektor">
                        <option value="">Semua Sektor</option>
                        <?php
                        $sektors = array_unique(array_column($teknisi, 'SEKTOR'));
                        foreach ($sektors as $sektor) {
                            echo "<option value='$sektor'>$sektor</option>";
                        }
                        ?>
                    </select>
                    <select id="filterSTO">
                        <option value="">Semua STO</option>
                        <?php
                        $stos = array_unique(array_column($teknisi, 'STO'));
                        foreach ($stos as $sto) {
                            echo "<option value='$sto'>$sto</option>";
                        }
                        ?>
                    </select>
                    <button class="btn btn-secondary" id="resetFilters">Reset Filter</button>
                </div>
                
                <div class="table-responsive">
                    <table id="teknisiTable">
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($teknisi as $tech): ?>
                            <tr>
                                <td><?= $tech['NIK'] ?></td>
                                <td><?= $tech['NAMA'] ?></td>
                                <td><?= $tech['JOBDESK'] ?></td>
                                <td><?= $tech['SEKTOR'] ?></td>
                                <td><?= $tech['STO'] ?></td>
                                <td><?= $tech['RAYON'] ?></td>
                                <td><?= $tech['DATEL'] ?></td>
                                <td>
                                    <?php if (!empty($tech['FOTO'])): ?>
                                        <img src="../<?= $tech['FOTO'] ?>" alt="Foto Teknisi" class="table-image" onclick="showImageModal('../<?= $tech['FOTO'] ?>')">
                                    <?php else: ?>
                                        <span class="no-image">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-edit" onclick="location.href='edit.php?nik=<?= $tech['NIK'] ?>'">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-delete" onclick="confirmDelete('<?= $tech['NIK'] ?>')">
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

    <!-- Image Modal -->
    <div id="imageModal" class="modal">
        <span class="close-modal" onclick="closeImageModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3>Konfirmasi Hapus</h3>
            <p>Apakah Anda yakin ingin menghapus data teknisi ini?</p>
            <div class="modal-actions">
                <button class="btn btn-secondary" onclick="closeDeleteModal()">Batal</button>
                <button class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#teknisiTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });

        // Filter functionality
        document.getElementById('filterSektor').addEventListener('change', filterTable);
        document.getElementById('filterSTO').addEventListener('change', filterTable);
        
        function filterTable() {
            const sektorFilter = document.getElementById('filterSektor').value;
            const stoFilter = document.getElementById('filterSTO').value;
            const rows = document.querySelectorAll('#teknisiTable tbody tr');
            
            rows.forEach(row => {
                const sektor = row.cells[3].textContent;
                const sto = row.cells[4].textContent;
                
                const sektorMatch = sektorFilter === '' || sektor === sektorFilter;
                const stoMatch = stoFilter === '' || sto === stoFilter;
                
                row.style.display = sektorMatch && stoMatch ? '' : 'none';
            });
        }

        document.getElementById('resetFilters').addEventListener('click', function() {
            document.getElementById('filterSektor').value = '';
            document.getElementById('filterSTO').value = '';
            filterTable();
        });

        // Delete functionality
        let currentDeleteId = null;
        
        function confirmDelete(nik) {
            currentDeleteId = nik;
            document.getElementById('deleteModal').style.display = 'block';
        }
        
        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }
        
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (currentDeleteId) {
                window.location.href = `delete.php?nik=${currentDeleteId}`;
            }
        });

        // Image modal
        function showImageModal(src) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modal.style.display = 'block';
            modalImg.src = src;
        }

        function closeImageModal() {
            document.getElementById('imageModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const imageModal = document.getElementById('imageModal');
            const deleteModal = document.getElementById('deleteModal');
            
            if (event.target === imageModal) {
                imageModal.style.display = 'none';
            }
            
            if (event.target === deleteModal) {
                deleteModal.style.display = 'none';
            }
        };
    </script>
</body>
</html>