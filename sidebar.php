<div class="sidebar">
    <div class="logo">
        <img src="img/indi.png" alt="IndiHome Logo">
    </div>
    
    <ul class="nav-menu">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="keluhan.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'keluhan.php' ? 'active' : ''; ?>">
                <i class="fas fa-list"></i>
                <span>Data Keluhan</span>
            </a>
        </li>
        <?php if ($_SESSION['level'] == 'admin'): ?>
        <li class="nav-item">
            <a href="input_keluhan.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'input_keluhan.php' ? 'active' : ''; ?>">
                <i class="fas fa-plus-circle"></i>
                <span>Input Keluhan</span>
            </a>
        </li>
        <?php endif; ?>
        <li class="nav-item">
            <a href="logout.php" class="nav-link">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</div>