// General utility functions
document.addEventListener('DOMContentLoaded', function() {
    // Add animation to cards
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('animated', 'fadeIn');
        }, index * 100);
    });
    
    // Toast notification for success messages
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('created')) {
        showToast('Tiket berhasil dibuat!', 'success');
    }
    if (urlParams.has('updated')) {
        showToast('Data berhasil diperbarui!', 'success');
    }
    if (urlParams.has('deleted')) {
        showToast('Data berhasil dihapus!', 'success');
    }
});

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

// Camera functionality for close ticket
function openCamera(fieldId, cameraType = 'environment') {
    const video = document.createElement('video');
    video.setAttribute('autoplay', '');
    video.setAttribute('playsinline', '');
    
    const modal = document.createElement('div');
    modal.className = 'camera-modal';
    modal.innerHTML = `
        <div class="camera-modal-content">
            <div class="camera-preview"></div>
            <div class="camera-actions">
                <button class="btn btn-danger" id="cancelCamera"><i class="fas fa-times"></i> Batal</button>
                <button class="btn btn-success" id="captureBtn"><i class="fas fa-camera"></i> Ambil Foto</button>
                <button class="btn btn-primary" id="switchCamera"><i class="fas fa-sync-alt"></i> Ganti Kamera</button>
            </div>
        </div>
    `;
    
    const preview = modal.querySelector('.camera-preview');
    preview.appendChild(video);
    
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
    
    let currentStream = null;
    let facingMode = cameraType;
    
    function startCamera() {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
        }
        
        const constraints = {
            video: { facingMode: facingMode },
            audio: false
        };
        
        navigator.mediaDevices.getUserMedia(constraints)
            .then(function(stream) {
                currentStream = stream;
                video.srcObject = stream;
            })
            .catch(function(err) {
                console.error("Error accessing camera: ", err);
                showToast('Gagal mengakses kamera', 'danger');
                modal.remove();
                document.body.style.overflow = '';
            });
    }
    
    startCamera();
    
    // Switch camera
    modal.querySelector('#switchCamera').addEventListener('click', function() {
        facingMode = facingMode === 'user' ? 'environment' : 'user';
        startCamera();
    });
    
    // Capture photo
    modal.querySelector('#captureBtn').addEventListener('click', function() {
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        
        const imageData = canvas.toDataURL('image/jpeg');
        document.getElementById(fieldId).value = imageData;
        
        // Show preview
        const previewElement = document.getElementById(`${fieldId}-preview`);
        if (previewElement) {
            previewElement.src = imageData;
            previewElement.style.display = 'block';
        }
        
        // Clean up
        currentStream.getTracks().forEach(track => track.stop());
        modal.remove();
        document.body.style.overflow = '';
    });
    
    // Cancel
    modal.querySelector('#cancelCamera').addEventListener('click', function() {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
        }
        modal.remove();
        document.body.style.overflow = '';
    });
}

// Additional utility functions
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// Initialize tooltips
function initTooltips() {
    const tooltipElements = document.querySelectorAll('[data-toggle="tooltip"]');
    tooltipElements.forEach(el => {
        el.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.getAttribute('title');
            
            const rect = this.getBoundingClientRect();
            tooltip.style.top = `${rect.top - 40}px`;
            tooltip.style.left = `${rect.left + rect.width / 2}px`;
            tooltip.style.transform = 'translateX(-50%)';
            
            document.body.appendChild(tooltip);
            
            this.addEventListener('mouseleave', function() {
                tooltip.remove();
            });
        });
    });
}

// Initialize date pickers
function initDatePickers() {
    const dateInputs = document.querySelectorAll('input[type="date"], input[type="datetime-local"]');
    dateInputs.forEach(input => {
        if (!input.value) {
            const now = new Date();
            const formattedDate = now.toISOString().slice(0, 16);
            input.value = formattedDate;
        }
    });
}

// Initialize all
document.addEventListener('DOMContentLoaded', function() {
    initTooltips();
    initDatePickers();
});