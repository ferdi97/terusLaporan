<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'process.php';
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card animated fadeInUp">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Close Tiket</h3>
                </div>
                <div class="card-body">
                    <form id="tiketForm" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik" required>
                            </div>
                            <div class="col-md-6">
                                <label for="no_tiket" class="form-label">No. Tiket</label>
                                <input type="text" class="form-control" id="no_tiket" name="no_tiket" required>
                            </div>
                            <div class="col-md-6">
                                <label for="no_inet" class="form-label">No. Internet</label>
                                <input type="text" class="form-control" id="no_inet" name="no_inet" required>
                            </div>
                            <div class="col-md-6">
                                <label for="rfo" class="form-label">RFO</label>
                                <select class="form-select" id="rfo" name="rfo" required>
                                    <option value="" selected disabled>Pilih RFO</option>
                                    <option value="SAMBUNG">SAMBUNG</option>
                                    <option value="CONFUL">CONFUL</option>
                                    <option value="GANTI">GANTI</option>
                                    <option value="IKR">IKR</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="PENDING">PENDING</option>
                                    <option value="CLOSE">CLOSE</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <h5 class="mb-3"><i class="fas fa-camera me-2"></i>Swafoto</h5>
                            
                            <!-- Swafoto 1 -->
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="camera-container">
                                    <div class="camera-preview" id="preview1"></div>
                                    <div class="camera-controls mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary camera-btn" data-preview="preview1" data-input="swafoto1">
                                            <i class="fas fa-camera"></i> Ambil Foto
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary switch-btn" data-preview="preview1">
                                            <i class="fas fa-sync-alt"></i> Switch
                                        </button>
                                    </div>
                                    <input type="hidden" id="swafoto1" name="swafoto1">
                                </div>
                            </div>
                            
                            <!-- Swafoto 2 -->
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="camera-container">
                                    <div class="camera-preview" id="preview2"></div>
                                    <div class="camera-controls mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary camera-btn" data-preview="preview2" data-input="swafoto2">
                                            <i class="fas fa-camera"></i> Ambil Foto
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary switch-btn" data-preview="preview2">
                                            <i class="fas fa-sync-alt"></i> Switch
                                        </button>
                                    </div>
                                    <input type="hidden" id="swafoto2" name="swafoto2">
                                </div>
                            </div>
                            
                            <!-- Swafoto 3 -->
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="camera-container">
                                    <div class="camera-preview" id="preview3"></div>
                                    <div class="camera-controls mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary camera-btn" data-preview="preview3" data-input="swafoto3">
                                            <i class="fas fa-camera"></i> Ambil Foto
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary switch-btn" data-preview="preview3">
                                            <i class="fas fa-sync-alt"></i> Switch
                                        </button>
                                    </div>
                                    <input type="hidden" id="swafoto3" name="swafoto3">
                                </div>
                            </div>
                            
                            <!-- Swafoto 4 -->
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="camera-container">
                                    <div class="camera-preview" id="preview4"></div>
                                    <div class="camera-controls mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary camera-btn" data-preview="preview4" data-input="swafoto4">
                                            <i class="fas fa-camera"></i> Ambil Foto
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary switch-btn" data-preview="preview4">
                                            <i class="fas fa-sync-alt"></i> Switch
                                        </button>
                                    </div>
                                    <input type="hidden" id="swafoto4" name="swafoto4">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="reset" class="btn btn-secondary me-md-2">
                                <i class="fas fa-undo me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan
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