<?php include 'includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technician Ticket System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-tools"></i>
            <span>TechTicket</span>
        </div>
        <ul class="menu">
            <li class="active"><a href="index.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="teknisi/"><i class="fas fa-user-cog"></i> Teknisi</a></li>
            <li><a href="hd/"><i class="fas fa-user-tie"></i> HD</a></li>
            <li><a href="tiket/"><i class="fas fa-ticket-alt"></i> Tiket</a></li>
            <li><a href="close/"><i class="fas fa-check-circle"></i> Close Tiket</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Dashboard</h1>
            <div class="user-profile">
                <img src="assets/images/user.png" alt="User">
                <span>Admin</span>
            </div>
        </div>

        <div class="dashboard-cards">
            <div class="card">
                <div class="card-icon blue">
                    <i class="fas fa-user-cog"></i>
                </div>
                <div class="card-info">
                    <h3>Total Teknisi</h3>
                    <p><?php echo count(readJson('data/teknisi.json')); ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-icon green">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="card-info">
                    <h3>Total HD</h3>
                    <p><?php echo count(readJson('data/hd.json')); ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-icon orange">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="card-info">
                    <h3>Total Tiket</h3>
                    <p><?php echo count(readJson('data/tiket.json')); ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-icon red">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="card-info">
                    <h3>Tiket Closed</h3>
                    <p><?php 
                        $closed = array_filter(readJson('data/close.json'), function($item) {
                            return $item['status'] === 'CLOSE';
                        });
                        echo count($closed);
                    ?></p>
                </div>
            </div>
        </div>

        <div class="charts">
            <div class="chart-container">
                <h3>Tiket by Status</h3>
                <canvas id="statusChart"></canvas>
            </div>
            <div class="chart-container">
                <h3>Tiket by Sektor</h3>
                <canvas id="sektorChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        // Dashboard charts
        document.addEventListener('DOMContentLoaded', function() {
            // Status Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            const statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Open', 'Pending', 'Closed'],
                    datasets: [{
                        data: [120, 50, 80],
                        backgroundColor: [
                            '#FF6384',
                            '#FFCE56',
                            '#36A2EB'
                        ],
                        hoverBackgroundColor: [
                            '#FF6384',
                            '#FFCE56',
                            '#36A2EB'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });

            // Sektor Chart
            const sektorCtx = document.getElementById('sektorChart').getContext('2d');
            const sektorChart = new Chart(sektorCtx, {
                type: 'bar',
                data: {
                    labels: ['Sektor A', 'Sektor B', 'Sektor C', 'Sektor D'],
                    datasets: [{
                        label: 'Tiket per Sektor',
                        data: [65, 59, 80, 81],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        });
    </script>
</body>
</html>