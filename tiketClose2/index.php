<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

// Fetch all tickets
$sql = "SELECT * FROM tickets ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card animated fadeIn">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Tiket</h3>
                    <a href="create.php" class="btn btn-light">
                        <i class="fas fa-plus me-1"></i> Buat Baru
                    </a>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show">
                            <?php echo $_SESSION['message']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-hover" id="tiketTable">
                            <thead>
                                <tr>
                                    <th>No. Tiket</th>
                                    <th>NIK</th>
                                    <th>No. Internet</th>
                                    <th>RFO</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows > 0): ?>
                                    <?php while($row = $result->fetch_assoc()): ?>
                                        <tr class="<?php echo $row['status'] == 'CLOSE' ? 'table-success' : 'table-warning'; ?>">
                                            <td><?php echo $row['no_tiket']; ?></td>
                                            <td><?php echo $row['nik']; ?></td>
                                            <td><?php echo $row['no_inet']; ?></td>
                                            <td><?php echo $row['rfo']; ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo $row['status'] == 'CLOSE' ? 'success' : 'warning'; ?>">
                                                    <?php echo $row['status']; ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('d M Y H:i', strtotime($row['created_at'])); ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Yakin ingin menghapus?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data tiket</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>