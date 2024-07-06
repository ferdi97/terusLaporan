<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <div id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <h2>Menu</h2>
                <button id="toggle-btn"><i class="fas fa-bars"></i></button>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php"><i class="fas fa-bug"></i> Data Keluhan</a></li>
                    <li><a href="today.php"><i class="fas fa-calendar-day"></i> Keluhan Hari Ini</a></li>
                    <li><a href="data_user.php" class="active"><i class="fas fa-user"></i> Data User</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </div>
        <div class="content">
            <header>
                <h3>Data User</h3>
                <input type="text" id="search" placeholder="Search...">
                <span class="search-icon"><i class="fas fa-search"></i></span>
            </header>
            <div class="table-container">
                <table id="data-table">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>USERNAME</th>
                            <th>PASSWORD</th>
                            <th>LEVEL USER</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <!-- Rows will be inserted here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="loader" class="loader"></div>

    <!-- Edit User Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Edit User</h2>
            <form id="editForm">
                <input type="hidden" id="editUserId">
                <div class="form-group">
                    <label for="editUsername">Username:</label>
                    <input type="text" id="editUsername" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="editPassword">Password:</label>
                    <input type="password" id="editPassword" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="editLevelUser">Level User:</label>
                    <div class="custom-select-wrapper">
                        <select id="editLevelUser" class="custom-select" required>
                            <option value="">Select Level</option>
                            <option value="Admin">admin</option>
                            <option value="User">user</option>
                        </select>
                        <div class="custom-select-trigger">Select Level</div>
                        <div class="custom-options">
                            <span class="custom-option" data-value="Admin">Admin</span>
                            <span class="custom-option" data-value="User">User</span>
                        </div>
                    </div>
                </div>
                <div class="button-group">
                    <button type="submit" class="save-btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Confirm Delete</h2>
            <p>Are you sure you want to delete this user?</p>
            <button id="confirmDelete" class="delete-btn">Delete</button>
            <button id="cancelDelete" class="cancel-btn">Cancel</button>
        </div>
    </div>

    <script src="scripts_data_user.js"></script>
</body>

</html>