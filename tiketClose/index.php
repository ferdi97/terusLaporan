<?php
session_start();
require_once 'includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once 'config.php';

// Fungsi untuk memeriksa kode akses
function checkAccessCode($pdo, $code) {
    $today = date('Y-m-d');
    $stmt = $pdo->prepare("SELECT * FROM access_codes WHERE code = ? AND date = ?");
    $stmt->execute([$code, $today]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Proses autentikasi
if (!isset($_SESSION['authenticated'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['access_code'])) {
        if ($validCode = checkAccessCode($pdo, $_POST['access_code'])) {
            $_SESSION['authenticated'] = true;
            $_SESSION['last_activity'] = time();
        } else {
            $error = "Kode akses tidak valid atau sudah kadaluarsa!";
        }
    }

    // Tampilkan form login jika belum terautentikasi
    if (!isset($_SESSION['authenticated'])) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Autentikasi Sistem</title>
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
            <link rel="stylesheet" href="assets/css/style.css">
            <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        </head>
        <body class="bg-gray-100 min-h-screen flex items-center justify-center">
            <div class="bg-white rounded-xl shadow-md overflow-hidden w-full max-w-md mx-4">
                <div class="bg-blue-600 py-4 px-6">
                    <h1 class="text-2xl font-bold text-white text-center">Akses Sistem</h1>
                </div>
                
                <div class="p-6">
                    <?php if (isset($error)): ?>
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <?php echo $error; ?>
                    </div>
                    <?php endif; ?>
                    
                    <form method="POST" class="space-y-4">
                        <div>
                            <label for="access_code" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-key mr-2"></i>Kode Akses Harian
                            </label>
                            <input type="text" id="access_code" name="access_code" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2">
                            <p class="mt-2 text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i> Dapatkan kode akses dari grup Telegram
                            </p>
                        </div>
                        
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <p class="text-xs text-gray-500 text-center">
                            <i class="fas fa-clock mr-1"></i> Kode berlaku hingga 23:59 WIB hari ini
                        </p>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

// Cek timeout session (30 menit)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
    header("Refresh:0");
    exit;
}
$_SESSION['last_activity'] = time();

// Lanjutkan dengan tampilan utama jika sudah terautentikasi
$tickets = getAllTickets($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tiket Close</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.tailwindcss.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Daftar Tiket Close</h1>
                <p class="text-sm text-gray-500 mt-1">
                    <i class="fas fa-calendar-day mr-1"></i> <?= date('d F Y') ?>
                </p>
            </div>
            <div class="flex space-x-3">
                <a href="create.php" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center">
                    <i class="fas fa-plus mr-2"></i> Tambah Tiket
                </a>
                <a href="logout.php" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table id="ticketsTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Tiket</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Internet</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RFO</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($tickets as $ticket): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($ticket['ticket']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= htmlspecialchars($ticket['nik']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= htmlspecialchars($ticket['no_inet']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= 
                                        $ticket['rfo'] == 'SAMBUNG' ? 'bg-green-100 text-green-800' : 
                                        ($ticket['rfo'] == 'CONFUL' ? 'bg-blue-100 text-blue-800' : 
                                        ($ticket['rfo'] == 'GANTI' ? 'bg-yellow-100 text-yellow-800' : 
                                        'bg-purple-100 text-purple-800')) 
                                    ?>">
                                    <?= htmlspecialchars($ticket['rfo']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d M Y', strtotime($ticket['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="view.php?id=<?= $ticket['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <a href="edit.php?id=<?= $ticket['id'] ?>" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="delete.php?id=<?= $ticket['id'] ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus tiket ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.tailwindcss.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ticketsTable').DataTable({
                responsive: true,
                order: [[4, 'desc']],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
                }
            });
        });
    </script>
</body>
</html>