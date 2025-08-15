let currentStream = null;
let currentFacingMode = 'user'; // 'user' for front camera, 'environment' for back
let currentPreview = null;
let currentInput = null;

$(document).ready(function() {
    // Camera button click handler
    $('.camera-btn').click(function() {
        currentPreview = $(this).data('preview');
        currentInput = $(this).data('input');
        $('#cameraModal').modal('show');
        startCamera();
    });
    
    // Switch camera button in modal
    $('#switchCameraBtn').click(function() {
        stopCamera();
        currentFacingMode = currentFacingMode === 'user' ? 'environment' : 'user';
        startCamera();
    });
    
    // Capture button handler
    $('#captureBtn').click(function() {
        capturePhoto();
    });
    
    // Switch camera button in preview
    $('.switch-btn').click(function(e) {
        e.stopPropagation();
        const previewId = $(this).data('preview');
        const preview = $('#' + previewId);
        
        if (preview.find('img').length) {
            const img = preview.find('img');
            const inputId = $(this).siblings('.camera-btn').data('input');
            
            // Flip the image horizontally to simulate front camera
            if (img.css('transform') === 'matrix(-1, 0, 0, 1, 0, 0)') {
                img.css('transform', 'none');
            } else {
                img.css('transform', 'scaleX(-1)');
            }
            
            // Update the image data in the hidden input
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = img[0].naturalWidth;
            canvas.height = img[0].naturalHeight;
            
            if (img.css('transform') === 'matrix(-1, 0, 0, 1, 0, 0)') {
                ctx.translate(canvas.width, 0);
                ctx.scale(-1, 1);
            }
            
            ctx.drawImage(img[0], 0, 0, canvas.width, canvas.height);
            $('#' + inputId).val(canvas.toDataURL('image/jpeg', 0.8));
        }
    });
    
    // Clean up when modal is closed
    $('#cameraModal').on('hidden.bs.modal', function() {
        stopCamera();
    });
});

function startCamera() {
    const constraints = {
        video: {
            facingMode: currentFacingMode,
            width: { ideal: 1280 },
            height: { ideal: 720 }
        },
        audio: false
    };
    
    navigator.mediaDevices.getUserMedia(constraints)
        .then(function(stream) {
            currentStream = stream;
            const video = document.getElementById('cameraFeed');
            video.srcObject = stream;
            
            // Flip video if using front camera
            if (currentFacingMode === 'user') {
                video.style.transform = 'scaleX(-1)';
            } else {
                video.style.transform = 'none';
            }
        })
        .catch(function(err) {
            console.error("Error accessing camera: ", err);
            alert('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.');
        });
}

function stopCamera() {
    if (currentStream) {
        currentStream.getTracks().forEach(function(track) {
            track.stop();
        });
        currentStream = null;
    }
}

function capturePhoto() {
    const video = document.getElementById('cameraFeed');
    const canvas = document.getElementById('cameraCanvas');
    const preview = document.getElementById(currentPreview);
    
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    
    const ctx = canvas.getContext('2d');
    
    // Flip image if using front camera
    if (currentFacingMode === 'user') {
        ctx.translate(canvas.width, 0);
        ctx.scale(-1, 1);
    }
    
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    
    // Convert to data URL and display in preview
    const imageData = canvas.toDataURL('image/jpeg', 0.8);
    preview.innerHTML = `<img src="${imageData}" class="img-fluid">`;
    
    // Store in hidden input
    $(`#${currentInput}`).val(imageData);
    
    // Close modal
    $('#cameraModal').modal('hide');
}