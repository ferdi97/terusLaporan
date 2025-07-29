document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('loader');
    const table = $('#keluhanTable').DataTable({
        ajax: {
            url: 'data_fetch.php',
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: (data, type, row, meta) => meta.row + 1 },
            { data: 'kd_tiket' },
            { data: 'nomor_internet' },
            { data: 'nama_pelapor' },
            { data: 'no_hp_pelapor' },
            { data: 'alamat_lengkap' },
            { data: 'keluhan' },
            {
                data: 'share_location',
                render: data => `<a href="https://www.google.com/maps?q=${data}" target="_blank">Lihat Lokasi</a>`
            },
            { data: 'tanggal_keluhan' },
            {
                data: 'kd_tiket',
                render: kd_tiket => `<button class="delete-btn" data-id="${kd_tiket}">Delete</button>`
            }
        ],
        initComplete: function () {
            $('#keluhanTable tbody').on('click', '.delete-btn', function () {
                const kdTiket = $(this).data('id');
                if (confirm('Yakin ingin menghapus data ini?')) {
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
                            alert('Berhasil dihapus');
                            table.ajax.reload();
                        } else {
                            alert('Gagal menghapus data');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting record:', error);
                    });
                }
            });
        }
    });
});
