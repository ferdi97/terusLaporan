document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('loader');
    const tableBody = document.getElementById('table-body');
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggle-btn');
    const searchInput = document.getElementById('search');
    const content = document.querySelector('.content');

    loader.style.display = 'block';

    // Function to fetch data from server
    function fetchData(searchTerm = '') {
        fetch(`data_fetch.php?action=today&search=${encodeURIComponent(searchTerm)}`)
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
                    fetchData(searchInput.value); // Refetch data with current search term
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
    searchInput.addEventListener('input', function () {
        fetchData(this.value.toLowerCase());
    });

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('header-collapsed');
    });
});
