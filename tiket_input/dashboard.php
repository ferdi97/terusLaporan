<?php
require_once 'includes/auth.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';

check_login();

$user = get_current_user();
$stats = get_dashboard_stats();
$recent_closed = get_recent_closed_tickets();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Tiket</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar animated slideInLeft">
            <div class="sidebar-header">
                <div class="user-profile">
                    <div class="avatar">
                        <img src="assets/images/avatars/<?= $user['foto'] ?? 'default.png' ?>" alt="User Avatar">
                    </div>
                    <div class="user-info">
                        <h4><?= $user['nama'] ?></h4>
                        <span class="badge badge-<?= get_level_badge($user['level_user']) ?>">
                            <?= $user['level_user'] ?>
                        </span>
                    </div>
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <ul>
                    <li class="active"><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <?php if ($user['level_user'] === 'HD' || $user['level_user'] === 'HO'): ?>
                    <li><a href="modules/teknisi/"><i class="fas fa-users-cog"></i> Data Teknisi</a></li>
                    <li><a href="modules/hd/"><i class="fas fa-user-tie"></i> Data HD</a></li>
                    <?php endif; ?>
                    <li><a href="modules/tiket/"><i class="fas fa-ticket-alt"></i> Tiket</a></li>
                    <li><a href="modules/close_tiket/"><i class="fas fa-check-circle"></i> Close Tiket</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="top-bar">
                <div class="search-bar">
                    <input type="text" placeholder="Search...">
                    <button><i class="fas fa-search"></i></button>
                </div>
                <div class="notifications">
                    <button class="btn-notification">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </button>
                </div>
            </div>
            
            <div class="content-wrapper">
                <h1 class="page-title">Dashboard</h1>
                
                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card stat-primary animated fadeIn delay-1">
                        <div class="stat-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?= $stats['total_tiket'] ?></h3>
                            <p>Total Tiket</p>
                        </div>
                    </div>
                    
                    <div class="stat-card stat-warning animated fadeIn delay-2">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?= $stats['sisa_tiket'] ?></h3>
                            <p>Tiket Sisa</p>
                        </div>
                    </div>
                    
                    <div class="stat-card stat-success animated fadeIn delay-3">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?= $stats['close_tiket'] ?></h3>
                            <p>Tiket Closed</p>
                        </div>
                    </div>
                    
                    <div class="stat-card stat-danger animated fadeIn delay-4">
                        <div class="stat-icon">
                            <i class="fas fa-pause-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?= $stats['pending_tiket'] ?></h3>
                            <p>Tiket Pending</p>
                        </div>
                    </div>
                    
                    <div class="stat-card stat-info animated fadeIn delay-5">
                        <div class="stat-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?= $stats['total_hd'] ?></h3>
                            <p>Total HD</p>
                        </div>
                    </div>
                    
                    <div class="stat-card stat-secondary animated fadeIn delay-6">
                        <div class="stat-icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?= $stats['total_teknisi'] ?></h3>
                            <p>Total Teknisi</p>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Closed Tickets -->
                <div class="card animated fadeInUp">
                    <div class="card-header">
                        <h3>Tiket Terakhir Ditutup</h3>
                        <div class="card-actions">
                            <select id="sto-filter" class="form-control">
                                <option value="">Semua STO</option>
                                <option value="STO A">STO A</option>
                                <option value="STO B">STO B</option>
                                <option value="STO C">STO C</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>ID Tiket</th>
                                        <th>Report Date</th>
                                        <th>Booking Date</th>
                                        <th>Tipe Tiket</th>
                                        <th>Flag</th>
                                        <th>Sektor</th>
                                        <th>Teknisi</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_closed as $tiket): ?>
                                    <tr>
                                        <td><?= $tiket['id_tiket'] ?></td>
                                        <td><?= format_date($tiket['reportdate']) ?></td>
                                        <td><?= format_date($tiket['bookingdate']) ?></td>
                                        <td><?= $tiket['tipe_tiket'] ?></td>
                                        <td><span class="badge badge-<?= get_flag_badge($tiket['flag_tiket']) ?>"><?= $tiket['flag_tiket'] ?></span></td>
                                        <td><?= $tiket['sektor'] ?></td>
                                        <td><?= $tiket['teknisi'] ?></td>
                                        <td><span class="badge badge-<?= $tiket['status'] === 'CLOSE' ? 'success' : 'warning' ?>"><?= $tiket['status'] ?></span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info btn-view" data-id="<?= $tiket['id_tiket'] ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Charts -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Distribusi Tiket per Bulan</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="ticketChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Status Tiket</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="statusChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View Ticket -->
    <div class="modal fade" id="viewTicketModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Tiket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="ticketDetails">
                    <!-- Details will be loaded here via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Filter STO
        document.getElementById('sto-filter').addEventListener('change', function() {
            const sto = this.value;
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                const stoCell = row.querySelector('td:nth-child(6)').textContent;
                if (sto === '' || stoCell.includes(sto)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
        // View Ticket
        document.querySelectorAll('.btn-view').forEach(btn => {
            btn.addEventListener('click', function() {
                const ticketId = this.getAttribute('data-id');
                
                fetch(`includes/get_ticket.php?id=${ticketId}`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('ticketDetails').innerHTML = html;
                        $('#viewTicketModal').modal('show');
                    });
            });
        });
        
        // Charts
        const ticketCtx = document.getElementById('ticketChart').getContext('2d');
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        
        const ticketChart = new Chart(ticketCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Tiket Dibuat',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Tiket Ditutup',
                    data: [8, 15, 2, 4, 1, 2],
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Sisa', 'Close', 'Pending'],
                datasets: [{
                    data: [<?= $stats['sisa_tiket'] ?>, <?= $stats['close_tiket'] ?>, <?= $stats['pending_tiket'] ?>],
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(255, 99, 132, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
</body>
</html>