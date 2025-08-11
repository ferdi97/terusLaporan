<?php
require_once 'includes/functions.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$ticket = getTicketById($id);

if (!$ticket) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nik' => $_POST['nik'],
        'ticket' => $_POST['ticket'],
        'no_inet' => $_POST['no_inet'],
        'rfo' => $_POST['rfo'],
        'photos' => $ticket['photos'] // Keep existing photos
    ];
    
    // Handle photo updates
    for ($i = 1; $i <= 4; $i++) {
        if (isset($_FILES['photo'.$i]) && $_FILES['photo'.$i]['error'] === UPLOAD_ERR_OK) {
            // Remove old photo if exists
            if (isset($ticket['photos'][$i-1])) {
                @unlink($ticket['photos'][$i-1]);
            }
            
            // Upload new photo
            $photo = $_FILES['photo'.$i];
            $uploadDir = 'assets/uploads/';
            $filename = uniqid() . '_' . basename($photo['name']);
            $targetPath = $uploadDir . $filename;
            
            if (move_uploaded_file($photo['tmp_name'], $targetPath)) {
                $data['photos'][$i-1] = $targetPath;
            }
        }
    }
    
    if (updateTicket($id, $data)) {
        header("Location: view.php?id=$id");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tiket #<?= htmlspecialchars($ticket['ticket']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-blue-600 py-4 px-6">
                <h1 class="text-2xl font-bold text-white">Edit Tiket #<?= htmlspecialchars($ticket['ticket']) ?></h1>
            </div>
            
            <form id="editTicketForm" class="p-6" method="POST" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                        <input type="text" id="nik" name="nik" value="<?= htmlspecialchars($ticket['nik']) ?>" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="ticket" class="block text-sm font-medium text-gray-700">Nomor Tiket</label>
                        <input type="text" id="ticket" name="ticket" value="<?= htmlspecialchars($ticket['ticket']) ?>" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="no_inet" class="block text-sm font-medium text-gray-700">Nomor Internet</label>
                        <input type="text" id="no_inet" name="no_inet" value="<?= htmlspecialchars($ticket['no_inet']) ?>" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="rfo" class="block text-sm font-medium text-gray-700">RFO</label>
                        <select id="rfo" name="rfo" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="SAMBUNG" <?= $ticket['rfo'] == 'SAMBUNG' ? 'selected' : '' ?>>SAMBUNG</option>
                            <option value="CONFUL" <?= $ticket['rfo'] == 'CONFUL' ? 'selected' : '' ?>>CONFUL</option>
                            <option value="GANTI" <?= $ticket['rfo'] == 'GANTI' ? 'selected' : '' ?>>GANTI</option>
                            <option value="IKR" <?= $ticket['rfo'] == 'IKR' ? 'selected' : '' ?>>IKR</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Swafoto</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php for ($i = 1; $i <= 4; $i++): 
                            $photoExists = isset($ticket['photos'][$i-1]);
                        ?>
                        <div class="photo-upload-container">
                            <label class="block text-sm font-medium text-gray-700">Swafoto <?= $i ?></label>
                            <div class="mt-1 flex items-center space-x-4">
                                <button type="button" class="camera-btn" data-camera="front" data-target="photo<?= $i ?>">
                                    <i class="fas fa-camera text-blue-500"></i> Kamera Depan
                                </button>
                                <button type="button" class="camera-btn" data-camera="back" data-target="photo<?= $i ?>">
                                    <i class="fas fa-camera text-blue-500"></i> Kamera Belakang
                                </button>
                            </div>
                            <input type="file" id="photo<?= $i ?>" name="photo<?= $i ?>" accept="image/*" capture="environment" class="hidden">
                            <div class="photo-preview mt-2 <?= $photoExists ? '' : 'hidden' ?>">
                                <?php if ($photoExists): ?>
                                <img id="preview<?= $i ?>" src="<?= htmlspecialchars($ticket['photos'][$i-1]) ?>" alt="Preview" class="h-32 object-cover rounded-md">
                                <?php else: ?>
                                <img id="preview<?= $i ?>" src="#" alt="Preview" class="h-32 object-cover rounded-md hidden">
                                <?php endif; ?>
                                <button type="button" class="remove-photo mt-2 text-sm text-red-600" data-target="photo<?= $i ?>">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
                
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="view.php?id=<?= $id ?>" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-white hover:bg-gray-600">
                        <i class="fas fa-times mr-2"></i> Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Camera Modal -->
    <div id="cameraModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg overflow-hidden w-full max-w-md">
            <div class="p-4 bg-blue-600 text-white">
                <h3 class="text-lg font-medium">Ambil Foto</h3>
            </div>
            <div class="p-4">
                <video id="cameraFeed" autoplay playsinline class="w-full h-auto bg-gray-800"></video>
                <canvas id="photoCanvas" class="hidden"></canvas>
            </div>
            <div class="p-4 bg-gray-100 flex justify-between">
                <button id="captureBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                    <i class="fas fa-camera mr-2"></i> Ambil Foto
                </button>
                <button id="closeCameraBtn" class="px-4 py-2 bg-gray-500 text-white rounded-md">
                    <i class="fas fa-times mr-2"></i> Tutup
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>