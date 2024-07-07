document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('loader');
    const tableBody = document.getElementById('table-body');
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggle-btn');
    const dataKeluhanLink = document.getElementById('data-keluhan');
    const settingLink = document.getElementById('setting');
    const content = document.querySelector('.content');

    loader.style.display = 'block';

    // Function to fetch data from server
    function fetchData() {
        fetch('data_fetch.php')
            .then(response => response.json())
            .then(data => {
                // Reverse the data array to display the newest data first
                data.reverse();

                let rows = '';
                data.forEach((item, index) => {
                    rows += `
                        <tr>
                            <td data-label="NO">${index + 1}</td>
                            <td data-label="KD TIKET">${item.kd_tiket}</td>
                            <td data-label="NOMOR INTERNET">${item.nomor_internet}</td>
                            <td data-label="NAMA PELAPOR">${item.nama_pelapor}</td>
                            <td data-label="NO HP">${item.no_hp_pelapor}</td>
                            <td data-label="ALAMAT">${item.alamat_lengkap}</td>
                            <td data-label="KELUHAN">${item.keluhan}</td>
                            <td data-label="KOORDINAT"><a href="https://www.google.com/maps?q=${item.share_location}"
                                    target="_blank">https://www.google.com/maps?q=${item.share_location}</a></td>
                            <td data-label="TANGGAL SUBMIT">${item.tanggal_keluhan}</td>
                            <td data-label="AKSI"><button class="delete-btn" data-id="${item.kd_tiket}">Delete</button></td>
                        </tr>
                    `;
                });
                tableBody.innerHTML = rows;
                loader.style.display = 'none';

                // Add event listeners to delete buttons
                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const kdTiket = this.getAttribute('data-id');
                        deleteRecord(kdTiket);
                    });
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                loader.style.display = 'none'; // Hide loader on error
            });
    }

    // Function to delete a record
    function deleteRecord(kdTiket) {
        if (confirm('Are you sure you want to delete this record?')) {
            fetch('data_fetch.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=delete&kd_tiket=${kdTiket}`,
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    alert('Record deleted successfully');
                    fetchData();
                } else {
                    alert('Error deleting record');
                }
            })
            .catch(error => {
                console.error('Error deleting record:', error);
            });
        }
    }

    // Initial fetch data
    fetchData();

    // Refresh data every 5 seconds
    setInterval(fetchData, 5000);

    // Search functionality
    document.getElementById('search').addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();
        document.querySelectorAll('#table-body tr').forEach(row => {
            const cells = Array.from(row.cells).map(cell => cell.textContent.toLowerCase());
            if (cells.some(cell => cell.includes(searchValue))) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('header-collapsed');
    });

    // Event listener untuk navigasi link Data Keluhan
    dataKeluhanLink.addEventListener('click', () => {
        console.log('Data Keluhan link clicked');
        // Tambahkan logika atau aksi yang diinginkan di sini
    });

    // Event listener untuk navigasi link Setting
    settingLink.addEventListener('click', () => {
        console.log('Setting link clicked');
        // Tambahkan logika atau aksi yang diinginkan di sini
    });

     // Event listener untuk tombol download
    document.getElementById('download-xlsx').addEventListener('click', function () {
        window.location.href = 'download_xlsx.php';
    });
});
