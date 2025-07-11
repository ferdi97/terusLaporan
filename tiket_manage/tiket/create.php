<?php 
include '../../includes/functions.php';
include '../../includes/telegram.php';

$teknisi = readJson('data/teknisi.json');
$hd = readJson('data/hd.json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tickets = [];
    $tiketData = readJson('data/tiket.json');
    
    // Process each row of the form
    for ($i = 0; $i < 10; $i++) {
        if (!empty($_POST['reportdate'][$i])) {
            $ticket = [
                'id_tiket' => generateId('TKT'),
                'reportdate' => $_POST['reportdate'][$i],
                'bookingdate' => $_POST['bookingdate'][$i],
                'Tipe_Tiket' => $_POST['Tipe_Tiket'][$i],
                'flag_tiket' => $_POST['flag_tiket'][$i],
                'sektor' => $_POST['sektor'][$i],
                'datek_odp' => $_POST['datek_odp'][$i],
                'status_tiket' => 'SISA',
                'nama_hd' => $_POST['nama_hd'][$i],
                'teknisi' => $_POST['teknisi'][$i]
            ];
            
            $tickets[] = $ticket;
            $tiketData[] = $ticket;
            
            // Send to Telegram
            sendToTelegram($ticket);
        }
    }
    
    writeJson('data/tiket.json', $tiketData);
    
    // Store the created tickets in session to display
    session_start();
    $_SESSION['created_tickets'] = $tickets;
    
    header('Location: index.php?created=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Tiket Baru</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-tools"></i>
            <span>TechTicket</span>
        </div>
        <ul class="menu">
            <li><a href="../../index.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="../../teknisi/"><i class="fas fa-user-cog"></i> Teknisi</a></li>
            <li><a href="../../hd/"><i class="fas fa-user-tie"></i> HD</a></li>
            <li class="active"><a href=""><i class="fas fa-ticket-alt"></i> Tiket</a></li>
            <li><a href="../../close/"><i class="fas fa-check-circle"></i> Close Tiket</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Buat Tiket Baru</h1>
            <div class="user-profile">
                <img src="../../assets/images/user.png" alt="User">
                <span>Admin</span>
            </div>
        </div>

        <div class="card animated fadeIn">
            <div class="card-header">
                <h3>Form Input Tiket (Multiple Entry)</h3>
                <div class="card-actions">
                    <button class="btn btn-secondary" onclick="location.href='index.php'">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form id="ticketForm" method="POST">
                    <div class="table-responsive">
                        <table class="multi-entry-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Report Date</th>
                                    <th>Booking Date</th>
                                    <th>Tipe Tiket</th>
                                    <th>Flag Tiket</th>
                                    <th>Sektor</th>
                                    <th>Datek ODP</th>
                                    <th>Nama HD</th>
                                    <th>Teknisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < 10; $i++): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td>
                                        <input type="datetime-local" name="reportdate[]" class="form-control">
                                    </td>
                                    <td>
                                        <input type="datetime-local" name="bookingdate[]" class="form-control">
                                    </td>
                                    <td>
                                        <select name="Tipe_Tiket[]" class="form-control">
                                            <option value="Gangguan">Gangguan</option>
                                            <option value="PSB">PSB</option>
                                            <option value="Migrasi">Migrasi</option>
                                            <option value="Upgrade">Upgrade</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="flag_tiket[]" class="form-control">
                                            <option value="Normal">Normal</option>
                                            <option value="Urgent">Urgent</option>
                                            <option value="Critical">Critical</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="sektor[]" class="form-control" list="sektorList">
                                        <datalist id="sektorList">
                                            <?php
                                            $sektors = array_unique(array_column($teknisi, 'SEKTOR'));
                                            foreach ($sektors as $sektor) {
                                                echo "<option value='$sektor'>";
                                            }
                                            ?>
                                        </datalist>
                                    </td>
                                    <td>
                                        <input type="text" name="datek_odp[]" class="form-control">
                                    </td>
                                    <td>
                                        <select name="nama_hd[]" class="form-control">
                                            <?php foreach ($hd as $user): ?>
                                                <option value="<?= $user['NAMA'] ?>"><?= $user['NAMA'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="teknisi[]" class="form-control">
                                            <?php foreach ($teknisi as $tech): ?>
                                                <option value="<?= $tech['NAMA'] ?>"><?= $tech['NAMA'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Semua Tiket
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearForm()">
                            <i class="fas fa-eraser"></i> Bersihkan Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../../assets/js/script.js"></script>
    <script>
        // Set default dates
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const reportDate = now.toISOString().slice(0, 16);
            
            // Set booking date to next day by default
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const bookingDate = tomorrow.toISOString().slice(0, 16);
            
            // Set default dates for all rows
            const reportInputs = document.querySelectorAll('input[name="reportdate[]"]');
            const bookingInputs = document.querySelectorAll('input[name="bookingdate[]"]');
            
            reportInputs.forEach(input => {
                input.value = reportDate;
            });
            
            bookingInputs.forEach(input => {
                input.value = bookingDate;
            });
        });
        
        function clearForm() {
            if (confirm('Apakah Anda yakin ingin membersihkan semua input?')) {
                document.getElementById('ticketForm').reset();
                
                // Reset dates to default
                const now = new Date();
                const reportDate = now.toISOString().slice(0, 16);
                
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                const bookingDate = tomorrow.toISOString().slice(0, 16);
                
                const reportInputs = document.querySelectorAll('input[name="reportdate[]"]');
                const bookingInputs = document.querySelectorAll('input[name="bookingdate[]"]');
                
                reportInputs.forEach(input => {
                    input.value = reportDate;
                });
                
                bookingInputs.forEach(input => {
                    input.value = bookingDate;
                });
            }
        }
    </script>
</body>
</html>