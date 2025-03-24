<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ffeb3b, #ff9800);
            color: #333;
            overflow-x: hidden;
        }
        .dashboard {
            padding: 30px;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            color: #333;
            text-align: center;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .sidebar {
            background: rgba(255, 152, 0, 0.9);
            padding: 20px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 200px;
            color: white;
        }
        .sidebar a {
            color: white;
            display: block;
            margin: 10px 0;
            text-decoration: none;
            font-weight: bold;
        }
        .content {
            margin-left: 220px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Admin Panel</h3>
        <a href="#">Dashboard</a>
        <a href="#">Users</a>
        <a href="#">Reports</a>
        <a href="#">Settings</a>
    </div>
    <div class="container dashboard content">
        <h1 class="text-center mb-4">🚀 Admin Dashboard</h1>
        <div class="row g-4">
            <div class="col-md-8 mx-auto">
                <div class="card p-4">
                    <h3>Jenis Tiket vs Status</h3>
                    <canvas id="combinedChart"></canvas>
                </div>
            </div>
        </div>
        <div class="row g-4 mt-4">
            <div class="col-md-10 mx-auto">
                <div class="card p-4">
                    <h3>Jumlah Tiket Berdasarkan Sektor</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sektor</th>
                                <th>SISA</th>
                                <th>PENDING</th>
                                <th>CLOSE</th>
                            </tr>
                        </thead>
                        <tbody id="sectorTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        gsap.from(".card", { opacity: 0, y: 50, duration: 1, stagger: 0.2 });

        async function fetchData() {
            const apiKey = "AIzaSyDFdaSruBmI5mqA48IdCDeJvlnUppiJ5jA"; 
            const spreadsheetId = "1cNEzrgnhuijPC-qCR8UKG-NzRFVcpUF9i3gOG3anoU4";
            const range = "MASTER_DATA!A1:V";
            const url = `https://sheets.googleapis.com/v4/spreadsheets/${spreadsheetId}/values/${range}?key=${apiKey}`;

            try {
                const response = await fetch(url);
                const data = await response.json();
                const values = data.values.slice(1);

                let ticketData = {};
                let sectorData = {};
                values.forEach(row => {
                    let jenis = row[6]; 
                    let status = row[16]; 
                    let sektor = row[9]; 

                    if (!ticketData[jenis]) {
                        ticketData[jenis] = { SISA: 0, PENDING: 0, CLOSE: 0 };
                    }
                    if (ticketData[jenis][status] !== undefined) {
                        ticketData[jenis][status]++;
                    }

                    if (!sectorData[sektor]) {
                        sectorData[sektor] = { SISA: 0, PENDING: 0, CLOSE: 0 };
                    }
                    if (sectorData[sektor][status] !== undefined) {
                        sectorData[sektor][status]++;
                    }
                });
                
                renderChart(ticketData);
                renderTable(sectorData);
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        }

        function renderChart(ticketData) {
            const labels = Object.keys(ticketData);
            const sisaData = labels.map(jenis => ticketData[jenis].SISA);
            const pendingData = labels.map(jenis => ticketData[jenis].PENDING);
            const closeData = labels.map(jenis => ticketData[jenis].CLOSE);

            const ctx = document.getElementById("combinedChart").getContext("2d");
            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "SISA",
                            data: sisaData,
                            backgroundColor: "#36a2eb"
                        },
                        {
                            label: "PENDING",
                            data: pendingData,
                            backgroundColor: "#ffce56"
                        },
                        {
                            label: "CLOSE",
                            data: closeData,
                            backgroundColor: "#ff6384"
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        function renderTable(sectorData) {
            let tableBody = document.getElementById("sectorTableBody");
            tableBody.innerHTML = "";
            Object.keys(sectorData).forEach(sektor => {
                let row = `<tr>
                    <td>${sektor}</td>
                    <td>${sectorData[sektor].SISA}</td>
                    <td>${sectorData[sektor].PENDING}</td>
                    <td>${sectorData[sektor].CLOSE}</td>
                </tr>`;
                tableBody.innerHTML += row;
            });
        }

        fetchData();
    </script>
</body>
</html>
