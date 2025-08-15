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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'process.php';
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card animated fadeInUp">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Tiket #<?php echo $tiket['no_tiket']; ?></h3>
                </div>
                <div class="card-body">
                    <form id="tiketForm" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $tiket['id']; ?>">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $tiket['nik']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="no_tiket" class="form-label">No. Tiket</label>
                                <input type="text" class="form-control" id="no_tiket" name="no_tiket" value="<?php echo $tiket['no_tiket']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="no_inet" class="form-label">No. Internet</label>
                                <input type="text" class="form-control" id="no_inet" name="no_inet" value="<?php echo $tiket['no_inet']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="rfo" class="form-label">RFO</label>
                                <select class="form-select" id="rfo" name="rfo" required>
                                    <option value="SAMBUNG" <?php echo $tiket['rfo'] == 'SAMBUNG' ? 'selected' : ''; ?>>SAMBUNG</option>
                                    <option value="CONFUL" <?php echo $tiket['rfo'] == 'CONFUL' ? 'selected' : ''; ?>>CONFUL</option>
                                    <option value="GANTI" <?php echo $tiket['rfo'] == 'GANTI' ? 'selected' : ''; ?>>GANTI</option>
                                    <option value="IKR" <?php echo $tiket['rfo'] == 'IKR' ? 'selected' : ''; ?>>IKR</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="PENDING" <?php echo $tiket['status'] == 'PENDING' ? 'selected' : ''; ?>>PENDING</option>
                                    <option value="CLOSE" <?php echo $tiket['status'] == 'CLOSE' ? 'selected' : ''; ?>>CLOSE</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <h5 class="mb-3"><i class="fas fa-camera me-2"></i>Swafoto</h5>
                            
                            <?php for ($i = 1; $i <= 4; $i++): ?>
                                <div class="col-md-6 col-lg-3 mb-4">
                                    <div class="camera-container">
                                        <div class="camera-preview" id="preview<?php echo $i; ?>">
                                            <?php if (!empty($tiket['swafoto'.$i])): ?>
                                                <img src="<?php echo $tiket['swafoto'.$i]; ?>" class="img-fluid">
                                            <?php endif; ?>
                                        </div>
                                        <div class="camera-controls mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-primary camera-btn" data-preview="preview<?php echo $i; ?>" data-input="swafoto<?php echo $i; ?>">
                                                <i class="fas fa-camera"></i> Ambil Foto
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary switch-btn" data-preview="preview<?php echo $i; ?>">
                                                <i class="fas fa-sync-alt"></i> Switch
                                            </button>
                                        </div>
                                        <input type="hidden" id="swafoto<?php echo $i; ?>" name="swafoto<?php echo $i; ?>" value="<?php echo !empty($tiket['swafoto'.$i]) ? $tiket['swafoto'.$i] : ''; ?>">
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="index.php" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Camera Modal -->
<div class="modal fade" id="cameraModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ambil Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="camera-modal-preview">
                    <video id="cameraFeed" autoplay playsinline></video>
                    <canvas id="cameraCanvas" style="display:none;"></canvas>
                </div>
                <div class="mt-3">
                    <button id="captureBtn" class="btn btn-primary">
                        <i class="fas fa-camera me-1"></i> Capture
                    </button>
                    <button id="switchCameraBtn" class="btn btn-secondary">
                        <i class="fas fa-sync-alt me-1"></i> Switch Camera
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>