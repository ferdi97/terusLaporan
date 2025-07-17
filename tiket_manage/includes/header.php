<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technician Ticket System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/terusLaporan/tiket_manage/main.css"> <!-- Benar -->

    <style>
        /* Additional styles can be added here */
    </style>
</head>
<body>
    <div class="header slideInDown">
        <h1><i class="fas fa-tools"></i> Technician Ticket System</h1>
        <div class="nav">
            <a href="index.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="modules/teknisi/list.php"><i class="fas fa-user-cog"></i> Technicians</a>
            <a href="modules/hd/list.php"><i class="fas fa-headset"></i> HD Staff</a>
            <a href="modules/tiket/list.php"><i class="fas fa-ticket-alt"></i> Tickets</a>
            <a href="modules/close/list.php"><i class="fas fa-check-circle"></i> Closed Tickets</a>
        </div>
    </div>
    
    <div class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>