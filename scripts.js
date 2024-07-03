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
        const nomorInternetInput = document.getElementById("nomor-internet");
        const nomorInternetValue = nomorInternetInput.value.trim();

        const numberRegex = /^\d+$/;

        if (!nomorInternetValue.match(numberRegex)) {
            alert("Nomor Internet harus berupa angka.");
            return false;
        }

        if (!nomorInternetValue.startsWith("05") && !nomorInternetValue.startsWith("16")) {
            alert("Nomor Internet harus diawali dengan '05' atau '16'.");
            return false;
        }

        if (nomorInternetValue.startsWith("16")) {
            if (nomorInternetValue.length < 12 || nomorInternetValue.length > 13) {
                alert("Nomor Internet yang diawali dengan '16' harus memiliki panjang 12 atau 13 digit.");
                return false;
            }
        } else if (nomorInternetValue.startsWith("05")) {
            if (nomorInternetValue.length < 9 || nomorInternetValue.length > 10) {
                alert("Nomor Internet yang diawali dengan '05' harus memiliki panjang minimal 9 digit dan tidak boleh lebih dari 10.");
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
        .then(response => response.text())
        .then(data => {
            alert(data);
            form.reset();
            document.getElementById("submit-button").textContent = "Simpan";
            generateKdTiket();  // Regenerate KD TIKET for next entry
        })
        .catch(error => {
            console.error('Error:', error);
        });
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
