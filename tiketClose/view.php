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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tiket #<?= htmlspecialchars($ticket['ticket']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-blue-600 py-4 px-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-white">Detail Tiket #<?= htmlspecialchars($ticket['ticket']) ?></h1>
                <div class="flex space-x-2">
                    <a href="edit.php?id=<?= $id ?>" class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="delete.php?id=<?= $id ?>" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600" onclick="return confirm('Apakah Anda yakin ingin menghapus tiket ini?')">
                        <i class="fas fa-trash"></i> Hapus
                    </a>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">NIK</h3>
                        <p class="mt-1 text-lg font-semibold text-gray-900"><?= htmlspecialchars($ticket['nik']) ?></p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Nomor Tiket</h3>
                        <p class="mt-1 text-lg font-semibold text-gray-900"><?= htmlspecialchars($ticket['ticket']) ?></p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Nomor Internet</h3>
                        <p class="mt-1 text-lg font-semibold text-gray-900"><?= htmlspecialchars($ticket['no_inet']) ?></p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">RFO</h3>
                        <p class="mt-1 text-lg font-semibold text-gray-900"><?= htmlspecialchars($ticket['rfo']) ?></p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Dibuat Pada</h3>
                        <p class="mt-1 text-lg font-semibold text-gray-900"><?= htmlspecialchars($ticket['created_at']) ?></p>
                    </div>
                    
                    <?php if (isset($ticket['updated_at'])): ?>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Diupdate Pada</h3>
                        <p class="mt-1 text-lg font-semibold text-gray-900"><?= htmlspecialchars($ticket['updated_at']) ?></p>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Swafoto</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach ($ticket['photos'] as $index => $photo): ?>
                        <div class="border rounded-lg overflow-hidden">
                            <img src="<?= htmlspecialchars($photo) ?>" alt="Swafoto <?= $index + 1 ?>" class="w-full h-48 object-cover">
                            <div class="p-2 bg-gray-50 text-center">
                                <span class="text-sm text-gray-600">Swafoto <?= $index + 1 ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="mt-8 flex justify-end">
                    <a href="index.php" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>