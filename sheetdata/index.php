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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            font-size: xx-small;
        }
        .container {
            margin-top: 20px;
            max-width: 100%;
        }
        .table-container {
            background: #fff;
            padding: 15px;
            font-size: xx-small;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }
        .filter-select {
            font-size: xx-small;
            width: 100%;
        }
        .table thead th {
            position: sticky;
            top: 0;
            background: #343a40;
            color: white;
            z-index: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="table-container">
            <h2 class="text-center">Data dari Google Sheets</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="dataTable">
                    <thead class="table-dark">
                        <tr>
                            <?php 
                            foreach ($headers as $index => $header) {
                                echo "<th>" . htmlspecialchars($header) . "<br><select class='filter-select' data-index='$index'><option value=''>Semua</option>";
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
        $(document).ready(function() {
            $('.filter-select').select2({
                width: '100%',
                allowClear: true,
                placeholder: "Pilih atau ketik"
            });

            let debounceTimer;
            $('.filter-select').on('change', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(filterTable, 200);
            });
        });

        function filterTable() {
            let filters = {};
            $('.filter-select').each(function() {
                let index = $(this).data('index');
                let value = $(this).val()?.toLowerCase() || "";
                if (value) filters[index] = value;
            });

            $('#dataTable tbody tr').each(function() {
                let rowData = JSON.parse($(this).attr('data-row'));
                let showRow = Object.keys(filters).every(index => rowData[index]?.toLowerCase().includes(filters[index]));
                $(this).css("display", showRow ? "" : "none");
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>