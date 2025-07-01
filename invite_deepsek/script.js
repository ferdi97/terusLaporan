document.addEventListener('DOMContentLoaded', function() {
    // Simulate loading
    setTimeout(function() {
        document.querySelector('.loading-screen').style.opacity = '0';
        setTimeout(function() {
            document.querySelector('.loading-screen').style.display = 'none';
            
            // Show envelope animation
            const envelope = document.querySelector('.envelope');
            
            // When envelope is clicked or after animation
            setTimeout(function() {
                envelope.classList.add('animate__zoomOut');
                
                setTimeout(function() {
                    envelope.style.display = 'none';
                    document.querySelector('.invitation-content').style.display = 'block';
                    
                    // Animate in the invitation content
                    animateInvitation();
                    
                    // Start confetti occasionally
                    setInterval(function() {
                        if(Math.random() > 0.7) {
                            createConfetti();
                        }
                    }, 10000);
                    
                    // Initialize countdown
                    initializeCountdown();
                    
                }, 500);
            }, 2000);
        }, 500);
    }, 1500);
    
    // RSVP Button Interactions
    document.querySelector('.rsvp-btn.accept').addEventListener('click', function() {
        this.textContent = 'Thank You!';
        this.style.backgroundColor = '#5cb85c';
        createConfetti();
    });
    
    document.querySelector('.rsvp-btn.decline').addEventListener('click', function() {
        this.textContent = 'We\'ll Miss You';
        this.style.backgroundColor = '#d9534f';
        this.style.color = 'white';
    });
    
    // Envelope hover effect
    const envelope = document.querySelector('.envelope');
    envelope.addEventListener('click', function() {
        this.classList.add('animate__zoomOut');
        
        setTimeout(function() {
            envelope.style.display = 'none';
            document.querySelector('.invitation-content').style.display = 'block';
            animateInvitation();
            initializeCountdown();
        }, 500);
    });
});

function animateInvitation() {
    // Animate each section sequentially
    const sections = document.querySelectorAll('.animate__animated');
    
    sections.forEach((section, index) => {
        setTimeout(() => {
            section.style.opacity = '1';
        }, index * 300);
    });
    
    // Special animation for couple names
    const coupleNames = document.querySelector('.couple-names h2');
    setTimeout(() => {
        coupleNames.style.animation = 'colorPulse 3s infinite';
    }, 1000);
}

function initializeCountdown() {
    // Set the date we're counting down to (from PHP)
    const eventDateStr = document.querySelector('.date').textContent;
    const eventDate = new Date(eventDateStr).getTime();
    
    // Update the countdown every 1 second
    const countdown = setInterval(function() {
        const now = new Date().getTime();
        const distance = eventDate - now;
        
        // Time calculations for days, hours, minutes and seconds
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Display the result
        document.getElementById('days').textContent = days.toString().padStart(2, '0');
        document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
        document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
        document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
        
        // If the countdown is finished, clear interval
        if (distance < 0) {
            clearInterval(countdown);
            document.querySelector('.countdown-timer').innerHTML = '<div class="event-arrived">The event has arrived!</div>';
        }
    }, 1000);
}

// Confetti effect
function createConfetti() {
    const canvas = document.getElementById('confetti-canvas');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    
    const ctx = canvas.getContext('2d');
    const particles = [];
    const colors = ['#f44336', '#e91e63', '#9c27b0', '#673ab7', '#3f51b5', '#2196f3', '#03a9f4', '#00bcd4', '#009688', '#4CAF50', '#8BC34A', '#CDDC39', '#FFEB3B', '#FFC107', '#FF9800', '#FF5722'];
    
    // Create particles
    for (let i = 0; i < 150; i++) {
        particles.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height - canvas.height,
            radius: Math.random() * 5 + 2,
            color: colors[Math.floor(Math.random() * colors.length)],
            speed: Math.random() * 3 + 2,
            angle: Math.random() * 360,
            rotation: Math.random() * 0.2 - 0.1
        });
    }
    
    // Animation loop
    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        particles.forEach(particle => {
            ctx.save();
            ctx.translate(particle.x, particle.y);
            ctx.rotate(particle.angle);
            
            ctx.fillStyle = particle.color;
            ctx.beginPath();
            ctx.arc(0, 0, particle.radius, 0, Math.PI * 2);
            ctx.fill();
            
            ctx.restore();
            
            particle.y += particle.speed;
            particle.angle += particle.rotation;
            
            if (particle.y > canvas.height) {
                particle.y = -particle.radius;
                particle.x = Math.random() * canvas.width;
            }
        });
        
        requestAnimationFrame(animate);
    }
    
    animate();
    
    // Stop after 3 seconds
    setTimeout(() => {
        const frames = particles.length * 2;
        let frameCount = 0;
        
        const fadeOut = setInterval(() => {
            frameCount++;
            if (frameCount >= frames) {
                clearInterval(fadeOut);
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            }
        }, 1000 / 60);
    }, 3000);
}

// Add color pulse animation for couple names
const style = document.createElement('style');
style.textContent = `
    @keyframes colorPulse {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
`;
document.head.appendChild(style);