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
        modal.style.width = '100%';
        modal.style.height = '100%';
        modal.style.backgroundColor = 'rgba(0,0,0,0.7)';
        modal.style.display = 'flex';
        modal.style.justifyContent = 'center';
        modal.style.alignItems = 'center';
        modal.style.zIndex = '1000';
    
        // Create modal content
        const modalContent = document.createElement('div');
        modalContent.className = 'modal-content';
        modalContent.style.backgroundColor = '#fff';
        modalContent.style.padding = '20px';
        modalContent.style.borderRadius = '10px';
        modalContent.style.maxWidth = '600px';
        modalContent.style.width = '90%';
        modalContent.style.maxHeight = '80vh';
        modalContent.style.overflowY = 'auto';
    
        // Create close button
        const closeButton = document.createElement('button');
        closeButton.textContent = 'Tutup';
        closeButton.style.marginTop = '20px';
        closeButton.style.padding = '10px 20px';
        closeButton.style.backgroundColor = '#4CAF50';
        closeButton.style.color = 'white';
        closeButton.style.border = 'none';
        closeButton.style.borderRadius = '5px';
        closeButton.style.cursor = 'pointer';
        closeButton.onclick = function() {
            document.body.removeChild(modal);
        };
    
        // Create copy button
        const copyButton = document.createElement('button');
        copyButton.textContent = 'Salin Data';
        copyButton.style.marginTop = '20px';
        copyButton.style.marginRight = '10px';
        copyButton.style.padding = '10px 20px';
        copyButton.style.backgroundColor = '#2196F3';
        copyButton.style.color = 'white';
        copyButton.style.border = 'none';
        copyButton.style.borderRadius = '5px';
        copyButton.style.cursor = 'pointer';
        copyButton.onclick = function() {
            copyToClipboard(data);
        };
    
        // Create summary content
        const summaryTitle = document.createElement('h2');
        summaryTitle.textContent = 'Ringkasan Laporan Anda';
        summaryTitle.style.textAlign = 'center';
        summaryTitle.style.marginBottom = '20px';
    
        const summaryMessage = document.createElement('p');
        summaryMessage.textContent = 'Terima kasih atas laporan yang Anda kirimkan. Berikut adalah detail laporan Anda:';
        summaryMessage.style.marginBottom = '20px';
    
        const summaryData = document.createElement('div');
        summaryData.style.marginBottom = '20px';
        
        // Format the data for display
        const formattedData = `
            <p><strong>ID Tiket:</strong> ${data.kd_tiket}</p>
            <p><strong>Nomor Internet:</strong> ${data.nomor_internet}</p>
            <p><strong>Nama Pelapor:</strong> ${data.nama_pelapor}</p>
            <p><strong>No HP Pelapor:</strong> ${data.no_hp_pelapor}</p>
            <p><strong>Alamat Lengkap:</strong> ${data.alamat_lengkap}</p>
            <p><strong>Keluhan:</strong> ${data.keluhan}</p>
            <p><strong>Lokasi:</strong> ${data.share_location}</p>
            <p><strong>Tanggal Laporan:</strong> ${data.tanggal_keluhan}</p>
        `;
        summaryData.innerHTML = formattedData;
    
        // Add elements to modal
        modalContent.appendChild(summaryTitle);
        modalContent.appendChild(summaryMessage);
        modalContent.appendChild(summaryData);
        
        const buttonContainer = document.createElement('div');
        buttonContainer.style.display = 'flex';
        buttonContainer.style.justifyContent = 'center';
        buttonContainer.appendChild(copyButton);
        buttonContainer.appendChild(closeButton);
        
        modalContent.appendChild(buttonContainer);
        modal.appendChild(modalContent);
        document.body.appendChild(modal);
    }
    
    function copyToClipboard(data) {
        // Format the data for copying
        const textToCopy = `
    ID Tiket: ${data.kd_tiket}
    Nomor Internet: ${data.nomor_internet}
    Nama Pelapor: ${data.nama_pelapor}
    No HP Pelapor: ${data.no_hp_pelapor}
    Alamat Lengkap: ${data.alamat_lengkap}
    Keluhan: ${data.keluhan}
    Lokasi: ${data.share_location}
    Tanggal Laporan: ${data.tanggal_keluhan}
        `;
    
        // Create a temporary textarea element
        const textarea = document.createElement('textarea');
        textarea.value = textToCopy;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
    
        // Show a brief notification
        alert('Data telah disalin ke clipboard!');
    }

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
