<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM tickets WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header('Location: index.php');
    exit;
}

$tiket = $result->fetch_assoc();
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card animated fadeIn">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-eye me-2"></i>Detail Tiket #<?php echo $tiket['no_tiket']; ?></h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <h5>NIK</h5>
                                <p><?php echo $tiket['nik']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <h5>No. Tiket</h5>
                                <p><?php echo $tiket['no_tiket']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <h5>No. Internet</h5>
                                <p><?php echo $tiket['no_inet']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <h5>RFO</h5>
                                <p><?php echo $tiket['rfo']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <h5>Status</h5>
                                <p>
                                    <span class="badge bg-<?php echo $tiket['status'] == 'CLOSE' ? 'success' : 'warning'; ?>">
                                        <?php echo $tiket['status']; ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <h5>Tanggal Dibuat</h5>
                                <p><?php echo date('d M Y H:i', strtotime($tiket['created_at'])); ?></p>
                            </div>
                        </div>
                    </div>

                    <h4 class="mb-3"><i class="fas fa-camera me-2"></i>Swafoto</h4>
                    <div class="row">
                        <?php for ($i = 1; $i <= 4; $i++): ?>
                            <?php if (!empty($tiket['swafoto'.$i])): ?>
                                <div class="col-md-6 col-lg-3 mb-4">
                                    <div class="swafoto-container">
                                        <img src="<?php echo $tiket['swafoto'.$i]; ?>" class="img-fluid swafoto-img" alt="Swafoto <?php echo $i; ?>">
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="index.php" class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <a href="edit.php?id=<?php echo $tiket['id']; ?>" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>