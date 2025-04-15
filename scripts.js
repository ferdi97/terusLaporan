document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");

    form.addEventListener("submit", function(event) {
        if (!validateForm()) {
            event.preventDefault();
        } else {
            event.preventDefault();  // Prevent default form submission
            saveData();  // Custom function to handle form submission
        }
    });

    const inputs = document.querySelectorAll("input, textarea");

    inputs.forEach(input => {
        input.addEventListener("focus", () => {
            const label = input.previousElementSibling;
            if (label && label.tagName === "LABEL") {
                label.classList.add("active");
            }
        });
        input.addEventListener("blur", () => {
            if (!input.value) {
                const label = input.previousElementSibling;
                if (label && label.tagName === "LABEL") {
                    label.classList.remove("active");
                }
            }
        });
    });

    document.getElementById("nomor-internet").addEventListener("input", function() {
        const nomorInternet = this.value.trim();
        if (nomorInternet) {
            fetch(`check_nomor_internet.php?nomor_internet=${nomorInternet}`)
                .then(response => response.json())
                .then(data => {
                    if (data.found) {
                        // document.getElementById("nama-pelapor").value = data.nama_pelapor;
                        // document.getElementById("no-hp-pelapor").value = data.no_hp_pelapor;
                        // document.getElementById("alamat-lengkap").value = data.alamat_lengkap;
                        // document.getElementById("keluhan-gangguan").value = data.keluhan;
                        // document.getElementById("share-location").value = data.share_location;
                        // document.getElementById("submit-button").textContent = "Simpan";
                    } 
                    else {
                        // document.getElementById("nama-pelapor").value = "";
                        // document.getElementById("no-hp-pelapor").value = "";
                        // document.getElementById("alamat-lengkap").value = "";
                        // document.getElementById("keluhan-gangguan").value = "";
                        // document.getElementById("share-location").value = "";
                        // document.getElementById("submit-button").textContent = "Simpan";
                    }
                });
        }
    });

    function validateForm() {
        const nomorNotel = document.getElementById("no-hp-pelapor");
        const nomorNotelValue = nomorNotel.value.trim();
        const nomorInternetInput = document.getElementById("nomor-internet");
        const nomorInternetValue = nomorInternetInput.value.trim();
        const shareLoc = document.getElementById("share-location");
        const shareLocValue = shareLoc.value.trim();
        const shareButton = document.getElementById("shareButton");
        

        const numberRegex = /^\d+$/;

        if (shareLocValue === "") {
            alert("Silakan klik untuk membagikan lokasi Anda");
            shareLoc.focus();
            return false;
        }

        if (!nomorNotelValue.match(numberRegex)) {
            alert("Nomor Telpon harus berupa angka.");
            nomorNotel.focus();
            return false;
        }

        if (!nomorInternetValue.match(numberRegex)) {
            alert("Nomor Internet harus berupa angka.");
            nomorInternetInput.focus();
            return false;
        }

        if (!nomorInternetValue.startsWith("05") && !nomorInternetValue.startsWith("16")) {
            alert("Nomor Internet harus diawali dengan '05' atau '16'.");
            nomorInternetInput.focus();
            return false;
        }

        if (nomorInternetValue.startsWith("16")) {
            if (nomorInternetValue.length < 12 || nomorInternetValue.length > 13) {
                alert("Nomor Internet yang diawali dengan '16' harus memiliki panjang 12 atau 13 digit.");
                nomorInternetInput.focus();
                return false;
            }
        } else if (nomorInternetValue.startsWith("05")) {
            if (nomorInternetValue.length < 9 || nomorInternetValue.length > 10) {
                alert("Nomor Internet yang diawali dengan '05' harus memiliki panjang minimal 9 digit dan tidak boleh lebih dari 10.");
                nomorInternetInput.focus();
                return false;
            }
        }

        return true;
    }

    // function saveData() {
    //     const nomorInternet = document.getElementById("nomor-internet").value;
    //     const namaPelapor = document.getElementById("nama-pelapor").value;
    //     const noHpPelapor = document.getElementById("no-hp-pelapor").value;
    //     const alamatLengkap = document.getElementById("alamat-lengkap").value;
    //     const keluhan = document.getElementById("keluhan-gangguan").value;
    //     const shareLocation = document.getElementById("share-location").value;
    //     const kdTiket = document.getElementById("kd-tiket").value;
    
    //     fetch('insert_data.php', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json'
    //         },
    //         body: JSON.stringify({
    //             nomor_internet: nomorInternet,
    //             nama_pelapor: namaPelapor,
    //             no_hp_pelapor: noHpPelapor,
    //             alamat_lengkap: alamatLengkap,
    //             keluhan: keluhan,
    //             share_location: shareLocation,
    //             kd_tiket: kdTiket
    //         })
    //     })
    //     .then(response => {
    //         if (!response.ok) {
    //             throw new Error('Network response was not ok');
    //         }
    //         return response.json();
    //     })
    //     .then(data => {
    //         if (data.status === 'success') {
    //             showSummaryModal(data.data);
    //             form.reset();
    //             generateKdTiket();
    //         } else {
    //             console.error('Server error:', data.message);
    //             alert('Error: ' + data.message);
    //         }
    //     })
    //     .catch(error => {
    //         console.error('Fetch error:', error);
    //         alert('Terjadi kesalahan saat mengirim data. Silakan coba lagi atau hubungi administrator.');
    //     });
    // }
    
    function saveData() {
        const nomorInternet = document.getElementById("nomor-internet").value;
        const namaPelapor = document.getElementById("nama-pelapor").value;
        const noHpPelapor = document.getElementById("no-hp-pelapor").value;
        const alamatLengkap = document.getElementById("alamat-lengkap").value;
        const keluhan = document.getElementById("keluhan-gangguan").value;
        const shareLocation = document.getElementById("share-location").value;
        const kdTiket = document.getElementById("kd-tiket").value;

        fetch('insert_data.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                nomor_internet: nomorInternet,
                nama_pelapor: namaPelapor,
                no_hp_pelapor: noHpPelapor,
                alamat_lengkap: alamatLengkap,
                keluhan: keluhan,
                share_location: shareLocation,
                kd_tiket: kdTiket
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                showSummaryModal(data.data);
                form.reset();
                generateKdTiket();
            } else {
                console.error('Server error:', data.message);
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Terjadi kesalahan saat mengirim data. Silakan coba lagi atau hubungi administrator.');
        });
    }

    function showSummaryModal(data) {
        // Create modal element
        const modal = document.createElement('div');
        modal.className = 'summary-modal';
        modal.style.position = 'fixed';
        modal.style.top = '0';
        modal.style.left = '0';
        modal.style.right = '0';
        modal.style.bottom = '0';
        modal.style.backgroundColor = 'rgba(0,0,0,0.7)';
        modal.style.zIndex = '1000';
        modal.style.display = 'flex';
        modal.style.justifyContent = 'center';
        modal.style.alignItems = 'center';
        modal.style.padding = '20px';
        // Create modal content
        const modalContent = document.createElement('div');
        modalContent.className = 'modal-content';
        
        // Create title
        const title = document.createElement('h2');
        title.className = 'modal-title';
        title.textContent = 'Laporan Berhasil Disimpan';
        
        // Create data summary
        const summary = document.createElement('div');
        summary.className = 'summary-data';
        summary.innerHTML = `
            <div class="data-row">
                <span class="data-label">ID Tiket:</span>
                <span class="data-value">${data.kd_tiket}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Nomor Internet:</span>
                <span class="data-value">${data.nomor_internet}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Nama Pelapor:</span>
                <span class="data-value">${data.nama_pelapor}</span>
            </div>
            <div class="data-row">
                <span class="data-label">No HP:</span>
                <span class="data-value">${data.no_hp_pelapor}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Alamat:</span>
                <span class="data-value">${data.alamat_lengkap}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Keluhan:</span>
                <span class="data-value">${data.keluhan}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Lokasi:</span>
                <span class="data-value">${data.share_location}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Tanggal:</span>
                <span class="data-value">${data.tanggal_keluhan}</span>
            </div>
        `;
        
        // Create action buttons
        const buttonContainer = document.createElement('div');
        buttonContainer.className = 'modal-buttons';
        
        // Google Maps button
        const mapsButton = document.createElement('button');
        mapsButton.className = 'maps-btn';
        mapsButton.textContent = 'Buka di Google Maps';
        mapsButton.onclick = function() {
            const coords = data.share_location.replace(/\s/g, '');
            window.open(`https://www.google.com/maps?q=${coords}`, '_blank');
        };
        
        // Copy button
        const copyButton = document.createElement('button');
        copyButton.className = 'copy-btn';
        copyButton.textContent = 'Salin Data';
        copyButton.onclick = function() {
            copyReportData(data);
        };
        
        // Close button
        const closeButton = document.createElement('button');
        closeButton.className = 'close-btn';
        closeButton.textContent = 'Tutup';
        closeButton.onclick = function() {
            document.body.removeChild(modal);
        };
        
        // Add buttons to container
        buttonContainer.appendChild(mapsButton);
        buttonContainer.appendChild(copyButton);
        buttonContainer.appendChild(closeButton);
        
        // Build modal structure
        modalContent.appendChild(title);
        modalContent.appendChild(summary);
        modalContent.appendChild(buttonContainer);
        modal.appendChild(modalContent);
        
        // Add modal to document
        document.body.appendChild(modal);
        
        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                document.body.removeChild(modal);
            }
        });
    }

    function copyReportData(data) {
                const mapsUrl = `https://www.google.com/maps?q=${data.share_location.replace(/\s/g, '')}`;
                
                const reportText = 
        ` LAPORAN GANGGUAN INDIHOME
        =============================
        ID Tiket: ${data.kd_tiket}
        Nomor Internet: ${data.nomor_internet}
        Nama Pelapor: ${data.nama_pelapor}
        No HP: ${data.no_hp_pelapor}
        Alamat: ${data.alamat_lengkap}
        Keluhan: ${data.keluhan}
        Lokasi: ${data.share_location} (${mapsUrl})
        Tanggal: ${data.tanggal_keluhan}`;
                
                navigator.clipboard.writeText(reportText)
                    .then(() => {
                        alert('Data laporan telah disalin ke clipboard!');
                    })
                    .catch(err => {
                        console.error('Gagal menyalin:', err);
                        alert('Gagal menyalin data. Silakan coba manual.');
                    });
    }

                // Your remaining existing code (generateKdTiket, map initialization, etc.)

    function generateKdTiket() {
        const randomNum = Math.floor(1000000000 + Math.random() * 9000000000);
        document.getElementById("kd-tiket").value = `IND${randomNum}`;
    }

    generateKdTiket();

    var map = L.map('map').setView([51.505, -0.09], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker;

    window.getCurrentLocation = function getCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLat = position.coords.latitude;
                var userLng = position.coords.longitude;
                var userLatLng = L.latLng(userLat, userLng);
                var currentZoom = map.getZoom();

                if (marker) {
                    map.removeLayer(marker);
                }

                map.setView(userLatLng, currentZoom);

                marker = L.marker(userLatLng, { draggable: true }).addTo(map);

                marker.on('dragend', function(e) {
                    document.getElementById('share-location').value = e.target.getLatLng().lat + ', ' + e.target.getLatLng().lng;
                });

                document.getElementById('share-location').value = userLat + ', ' + userLng;
            }, function(error) {
                console.error('Error occurred. Error code: ' + error.code);
                alert('Error occurred. Error code: ' + error.code);
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }
});
