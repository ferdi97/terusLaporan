<?php
// Ganti dengan Spreadsheet ID kamu
$spreadsheetId = "1cNEzrgnhuijPC-qCR8UKG-NzRFVcpUF9i3gOG3anoU4"; 
$range = "MASTER_DATA!A1:V"; // Batas sampai kolom COMPLY 3JAM

// API Key dari Google Cloud
$apiKey = "AIzaSyDFdaSruBmI5mqA48IdCDeJvlnUppiJ5jA"; 

// URL API Google Sheets
$url = "https://sheets.googleapis.com/v4/spreadsheets/$spreadsheetId/values/$range?key=$apiKey";

// Mengambil data dari Google Sheets
$response = file_get_contents($url);
$data = json_decode($response, true);
$headers = !empty($data['values'][0]) ? $data['values'][0] : [];
$rows = array_slice($data['values'], 1);

// Menyiapkan opsi filter untuk combo box
$filterOptions = [];
foreach ($headers as $index => $header) {
    $filterOptions[$index] = [];
    foreach ($rows as $row) {
        if (isset($row[$index]) && !in_array($row[$index], $filterOptions[$index])) {
            $filterOptions[$index][] = $row[$index];
        }
    }
    sort($filterOptions[$index]);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Google Sheets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            margin-top: 20px;
        }
        .table-container {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .filter-select, .search-box {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .table tbody tr {
            transition: background-color 0.2s;
        }
        .table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }
        .scroll-container {
            overflow-x: auto;
            white-space: nowrap;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="table-container">
            <h4 class="text-center">ENTRY DATA</h4>
            <input type="text" id="searchInput" class="search-box" placeholder="Cari data..." onkeyup="searchTable()">
            <div class="scroll-container">
                <table class="table table-striped table-bordered" id="dataTable">
                    <thead class="table-dark">
                        <tr>
                            <?php 
                            foreach ($headers as $index => $header) {
                                echo "<th>" . htmlspecialchars($header) . "<br><select class='filter-select' data-index='$index' onchange='filterTable()'>";
                                echo "<option value=''>Semua</option>";
                                foreach ($filterOptions[$index] as $option) {
                                    echo "<option value='" . htmlspecialchars($option) . "'>" . htmlspecialchars($option) . "</option>";
                                }
                                echo "</select></th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($rows as $row) {
                            echo "<tr data-row='" . htmlspecialchars(json_encode($row)) . "'>";
                            foreach ($row as $cell) {
                                echo "<td>" . htmlspecialchars($cell) . "</td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function filterTable() {
            let selects = document.querySelectorAll(".filter-select");
            let rows = document.querySelectorAll("#dataTable tbody tr");
            let filters = Array.from(selects).map(select => select.value.toLowerCase());
            rows.forEach(row => {
                let rowData = JSON.parse(row.getAttribute("data-row"));
                let showRow = filters.every((filter, index) => !filter || (rowData[index] && rowData[index].toLowerCase() === filter));
                row.style.display = showRow ? "" : "none";
            });
        }
        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let rows = document.querySelectorAll("#dataTable tbody tr");
            rows.forEach(row => {
                let rowData = JSON.parse(row.getAttribute("data-row"));
                let showRow = rowData.some(cell => cell.toLowerCase().includes(input));
                row.style.display = showRow ? "" : "none";
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
