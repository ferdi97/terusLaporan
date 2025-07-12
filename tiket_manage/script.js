document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Camera functionality
    const cameraModals = document.querySelectorAll('.camera-modal');
    cameraModals.forEach(modal => {
        const modalId = modal.getAttribute('data-target');
        const modalElement = document.getElementById(modalId);
        const closeBtn = modalElement.querySelector('.close-btn');
        const cameraView = modalElement.querySelector('#camera-view');
        const cameraSwitch = modalElement.querySelector('.camera-switch');
        const cameraCapture = modalElement.querySelector('.camera-capture');
        const cameraOutput = modalElement.querySelector('#camera-output');
        const cameraField = modalElement.querySelector('#camera-field');
        
        let stream = null;
        let facingMode = "user"; // front camera by default
        
        // Open modal
        modal.addEventListener('click', function() {
            modalElement.style.display = 'block';
            startCamera();
        });
        
        // Close modal
        closeBtn.addEventListener('click', function() {
            modalElement.style.display = 'none';
            stopCamera();
        });
        
        // Switch camera
        cameraSwitch.addEventListener('click', function() {
            facingMode = facingMode === "user" ? "environment" : "user";
            stopCamera();
            startCamera();
        });
        
        // Capture photo
        cameraCapture.addEventListener('click', function() {
            const canvas = document.createElement('canvas');
            canvas.width = cameraView.videoWidth;
            canvas.height = cameraView.videoHeight;
            canvas.getContext('2d').drawImage(cameraView, 0, 0);
            
            const imageData = canvas.toDataURL('image/jpeg');
            cameraOutput.src = imageData;
            cameraOutput.style.display = 'block';
            cameraField.value = imageData;
            
            // Hide camera view after capture
            cameraView.style.display = 'none';
            cameraSwitch.style.display = 'none';
            cameraCapture.textContent = 'Retake';
            
            // Change capture button behavior
            cameraCapture.onclick = function() {
                cameraView.style.display = 'block';
                cameraOutput.style.display = 'none';
                cameraSwitch.style.display = 'block';
                cameraCapture.textContent = 'Capture';
                cameraCapture.onclick = capturePhoto;
            };
        });
        
        function startCamera() {
            navigator.mediaDevices.getUserMedia({
                video: { facingMode: facingMode },
                audio: false
            }).then(function(s) {
                stream = s;
                cameraView.srcObject = stream;
                cameraView.style.display = 'block';
                cameraOutput.style.display = 'none';
            }).catch(function(err) {
                console.error("Camera error: ", err);
                alert("Could not access the camera. Please make sure you have granted camera permissions.");
            });
        }
        
        function stopCamera() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
        }
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === modalElement) {
                modalElement.style.display = 'none';
                stopCamera();
            }
        });
    });
    
    // Form validation
    const forms = document.querySelectorAll('form.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
    
    // Multi-row form handling
    const addRowButtons = document.querySelectorAll('.add-row-btn');
    addRowButtons.forEach(button => {
        button.addEventListener('click', function() {
            const container = this.closest('.multi-row-container');
            const template = container.querySelector('.row-template');
            const clone = template.cloneNode(true);
            clone.classList.remove('row-template');
            clone.style.display = 'flex';
            
            // Clear input values in the cloned row
            const inputs = clone.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.value = '';
                if (input.type === 'checkbox' || input.type === 'radio') {
                    input.checked = false;
                }
            });
            
            // Add remove button
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-danger btn-sm';
            removeBtn.innerHTML = '<i class="fas fa-trash"></i>';
            removeBtn.addEventListener('click', function() {
                clone.remove();
            });
            
            const actionsDiv = document.createElement('div');
            actionsDiv.className = 'form-group';
            actionsDiv.style.display = 'flex';
            actionsDiv.style.alignItems = 'flex-end';
            actionsDiv.appendChild(removeBtn);
            
            clone.appendChild(actionsDiv);
            container.insertBefore(clone, this);
        });
    });
    
    // Telegram send functionality
    const sendTelegramButtons = document.querySelectorAll('.send-telegram');
    sendTelegramButtons.forEach(button => {
        button.addEventListener('click', function() {
            const ticketId = this.getAttribute('data-ticket-id');
            const button = this;
            
            button.innerHTML = '<span class="spinner"></span> Sending...';
            button.disabled = true;
            
            // Simulate API call (replace with actual Telegram API call)
            setTimeout(function() {
                button.innerHTML = '<i class="fas fa-check"></i> Sent';
                button.classList.remove('btn-primary');
                button.classList.add('btn-success');
                
                // Update the status in the table
                const statusCell = button.closest('tr').querySelector('.telegram-status');
                if (statusCell) {
                    statusCell.textContent = 'Sent';
                    statusCell.classList.add('tele-sent');
                    statusCell.classList.remove('tele-not-sent');
                }
                
                // In a real implementation, you would:
                // 1. Make an AJAX call to your server
                // 2. Your server would send the message via Telegram Bot API
                // 3. Update your database with the sent status
            }, 1500);
        });
    });
    
    // Dynamic filter functionality
    const filterForms = document.querySelectorAll('.filter-form');
    filterForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            const filters = {};
            
            for (let [key, value] of formData.entries()) {
                if (value) filters[key] = value;
            }
            
            // In a real implementation, you would:
            // 1. Make an AJAX call to your server with the filters
            // 2. Your server would return filtered data
            // 3. Update the table with the filtered results
            
            console.log('Filters applied:', filters);
            alert('Filter functionality would be implemented here. Check console for filter values.');
        });
    });
    
    // Reset filters
    const resetFilterButtons = document.querySelectorAll('.reset-filters');
    resetFilterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            form.reset();
            
            // In a real implementation, you would reload the original data
            console.log('Filters reset');
            alert('Filter reset functionality would be implemented here.');
        });
    });
    
    // Pivot table functionality
    const pivotButtons = document.querySelectorAll('.pivot-btn');
    pivotButtons.forEach(button => {
        button.addEventListener('click', function() {
            const pivotType = this.getAttribute('data-pivot-type');
            
            // In a real implementation, you would:
            // 1. Make an AJAX call to your server with the pivot type
            // 2. Your server would return pivoted data
            // 3. Display the pivoted data in a modal or new view
            
            console.log('Pivot view requested:', pivotType);
            alert(`Pivot view for ${pivotType} would be displayed here. Check console for details.`);
        });
    });
});