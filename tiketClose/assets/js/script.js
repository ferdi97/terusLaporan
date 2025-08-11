document.addEventListener('DOMContentLoaded', function() {
    // Camera functionality
    let currentCamera = null;
    let currentTarget = null;
    let stream = null;
    const cameraModal = document.getElementById('cameraModal');
    const cameraFeed = document.getElementById('cameraFeed');
    const photoCanvas = document.getElementById('photoCanvas');
    const captureBtn = document.getElementById('captureBtn');
    const closeCameraBtn = document.getElementById('closeCameraBtn');
    
    // Camera buttons
    document.querySelectorAll('.camera-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            currentCamera = this.getAttribute('data-camera');
            currentTarget = this.getAttribute('data-target');
            openCamera(currentCamera);
        });
    });
    
    // File input change
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const previewId = 'preview' + this.id.replace('photo', '');
                const preview = document.getElementById(previewId);
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.parentElement.classList.remove('hidden');
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    
    // Remove photo buttons
    document.querySelectorAll('.remove-photo').forEach(btn => {
        btn.addEventListener('click', function() {
            const target = this.getAttribute('data-target');
            const input = document.getElementById(target);
            const preview = document.getElementById('preview' + target.replace('photo', ''));
            
            input.value = '';
            preview.src = '#';
            preview.parentElement.classList.add('hidden');
        });
    });
    
    // Open camera
    function openCamera(facingMode) {
        cameraModal.classList.remove('hidden');
        
        const constraints = {
            video: {
                facingMode: facingMode === 'front' ? 'user' : 'environment',
                width: { ideal: 1280 },
                height: { ideal: 720 }
            }
        };
        
        navigator.mediaDevices.getUserMedia(constraints)
            .then(function(mediaStream) {
                stream = mediaStream;
                cameraFeed.srcObject = stream;
            })
            .catch(function(err) {
                console.error("Error accessing camera: ", err);
                Swal.fire({
                    icon: 'error',
                    title: 'Kamera tidak dapat diakses',
                    text: 'Pastikan Anda memberikan izin akses kamera'
                });
                closeCamera();
            });
    }
    
    // Capture photo
    captureBtn.addEventListener('click', function() {
        const context = photoCanvas.getContext('2d');
        photoCanvas.width = cameraFeed.videoWidth;
        photoCanvas.height = cameraFeed.videoHeight;
        context.drawImage(cameraFeed, 0, 0, photoCanvas.width, photoCanvas.height);
        
        // Convert canvas to blob and create file
        photoCanvas.toBlob(function(blob) {
            const file = new File([blob], 'photo.jpg', { type: 'image/jpeg' });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            
            // Set the file to the input
            const input = document.getElementById(currentTarget);
            input.files = dataTransfer.files;
            
            // Trigger change event
            const event = new Event('change');
            input.dispatchEvent(event);
            
            closeCamera();
        }, 'image/jpeg', 0.9);
    });
    
    // Close camera
    closeCameraBtn.addEventListener('click', closeCamera);
    
    function closeCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        cameraModal.classList.add('hidden');
    }
    
    // Form submission
    document.getElementById('closeTicketForm').addEventListener('submit', function(e) {
        // You can add additional validation here if needed
    });
});