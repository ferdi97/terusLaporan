<!-- pelanggan.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Data Pelanggan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container-fluid">
        <?php include 'sidebar.php'; ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="content pt-3">
                <h2>Data Pelanggan</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <!-- Add more columns as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Include database configuration and functions
                        include 'includes/config.php';
                        include 'includes/functions.php';

                        // Fetch customers from database
                        $customers = getCustomers();

                        foreach ($customers as $customer) {
                            echo '<tr>';
                            echo '<td>' . $customer['id'] . '</td>';
                            echo '<td>' . $customer['nama'] . '</td>';
                            echo '<td>' . $customer['alamat'] . '</td>';
                            // Output additional columns here
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
