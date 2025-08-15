$(document).ready(function() {
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Add animation to table rows
    $('#tiketTable tbody tr').each(function(i) {
        $(this).delay(i * 100).fadeIn(300);
    });
    
    // Form validation
    $('#tiketForm').submit(function(e) {
        let isValid = true;
        
        // Validate required fields
        $(this).find('[required]').each(function() {
            if ($(this).val() === '') {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        // Validate at least one photo
        let hasPhoto = false;
        for (let i = 1; i <= 4; i++) {
            if ($('#swafoto' + i).val() !== '') {
                hasPhoto = true;
                break;
            }
        }
        
        if (!hasPhoto) {
            $('.camera-container').css('border-color', 'var(--danger-color)');
            isValid = false;
        } else {
            $('.camera-container').css('border-color', '');
        }
        
        if (!isValid) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 100
            }, 500);
            
            // Add shake animation to invalid fields
            $('.is-invalid').addClass('animated shake');
            setTimeout(function() {
                $('.is-invalid').removeClass('animated shake');
            }, 1000);
        }
    });
    
    // Add hover effects to buttons
    $('.btn').addClass('btn-hover-animate');
    
    // Add hover effects to icons
    $('.fa-icon').addClass('icon-hover-animate');
    
    // Auto-focus first field
    $('form').find('input, textarea, select').first().focus();
    
    // Show success message if exists
    if ($('.alert-success').length) {
        setTimeout(function() {
            $('.alert-success').fadeOut(500);
        }, 5000);
    }
});