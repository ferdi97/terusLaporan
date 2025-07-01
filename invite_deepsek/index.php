<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxury Wedding Invitation | Sarah & Michael</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;500;700&family=Dancing+Script:wght@700&family=Great+Vibes&family=Cinzel:wght@700&display=swap">
    <style>
        :root {
            --gold: #D4AF37;
            --gold-light: #E8C99B;
            --gold-dark: #B88A4A;
            --ivory: #F9F5F0;
            --charcoal: #333333;
            --slate: #555555;
            --shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
            --transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--ivory);
            color: var(--charcoal);
            overflow-x: hidden;
            line-height: 1.6;
        }
        
        /* Luxury Loading Screen */
        .luxury-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--ivory);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            transition: opacity 1s ease-out;
        }
        
        .monogram {
            font-family: 'Cinzel', serif;
            font-size: 3rem;
            color: var(--gold);
            margin-bottom: 2rem;
            position: relative;
        }
        
        .monogram::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 2px;
            background: var(--gold);
        }
        
        .progress-bar {
            width: 200px;
            height: 3px;
            background: rgba(212, 175, 55, 0.2);
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .progress {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--gold), var(--gold-dark));
            transition: width 0.5s ease;
        }
        
        .loading-text {
            font-size: 0.9rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--slate);
        }
        
        /* Luxury Cover */
        .invitation-cover {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('assets/images/luxury-bg.jpg') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            z-index: 900;
            transition: transform 1.5s cubic-bezier(0.77, 0, 0.175, 1);
        }
        
        .cover-content {
            text-align: center;
            transform: translateY(20px);
            opacity: 0;
            transition: var(--transition);
        }
        
        .cover-title {
            font-family: 'Cinzel', serif;
            font-size: 3rem;
            margin-bottom: 1rem;
            letter-spacing: 5px;
            color: var(--gold);
        }
        
        .cover-subtitle {
            font-family: 'Dancing Script', cursive;
            font-size: 2rem;
            margin-bottom: 2rem;
            color: var(--gold-light);
        }
        
        .open-invitation {
            background: transparent;
            border: 2px solid var(--gold);
            color: white;
            padding: 12px 30px;
            font-size: 1rem;
            letter-spacing: 2px;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }
        
        .open-invitation::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.3), transparent);
            transition: 0.5s;
        }
        
        .open-invitation:hover::before {
            left: 100%;
        }
        
        .open-invitation:hover {
            background: rgba(212, 175, 55, 0.2);
        }
        
        /* Main Invitation */
        .invitation-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            opacity: 0;
            transform: translateY(50px);
            transition: var(--transition);
        }
        
        /* Header Section */
        .invitation-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }
        
        .header-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: var(--gold);
            margin-bottom: 1rem;
            letter-spacing: 3px;
        }
        
        .ornamental-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2rem 0;
        }
        
        .divider-line {
            width: 80px;
            height: 1px;
            background: var(--gold);
        }
        
        .divider-icon {
            margin: 0 1rem;
            color: var(--gold);
            font-size: 1.2rem;
        }
        
        /* Couple Section */
        .couple-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 4rem 0;
        }
        
        .portrait-card {
            flex: 1;
            max-width: 300px;
            perspective: 1000px;
        }
        
        .portrait-inner {
            position: relative;
            width: 100%;
            height: 400px;
            transition: transform 0.8s;
            transform-style: preserve-3d;
        }
        
        .portrait-card:hover .portrait-inner {
            transform: rotateY(180deg);
        }
        
        .portrait-front, .portrait-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }
        
        .portrait-front {
            background-size: cover;
            background-position: center;
        }
        
        .groom .portrait-front {
            background-image: url('assets/images/groom.jpg');
        }
        
        .bride .portrait-front {
            background-image: url('assets/images/bride.jpg');
        }
        
        .portrait-back {
            background: white;
            transform: rotateY(180deg);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            text-align: center;
        }
        
        .portrait-back h3 {
            font-family: 'Playfair Display', serif;
            color: var(--gold);
            margin-bottom: 1rem;
        }
        
        .social-links {
            display: flex;
            margin-top: 1rem;
        }
        
        .social-links a {
            color: var(--slate);
            margin: 0 0.5rem;
            font-size: 1.2rem;
            transition: color 0.3s;
        }
        
        .social-links a:hover {
            color: var(--gold);
        }
        
        .couple-names {
            flex: 2;
            text-align: center;
            padding: 0 2rem;
        }
        
        .couple-names h2 {
            font-family: 'Great Vibes', cursive;
            font-size: 4.5rem;
            color: var(--gold);
            margin-bottom: 1rem;
            line-height: 1;
        }
        
        .couple-names p {
            font-family: 'Dancing Script', cursive;
            font-size: 1.8rem;
            color: var(--slate);
        }
        
        /* Date Section */
        .date-section {
            background: white;
            padding: 3rem;
            border-radius: 10px;
            box-shadow: var(--shadow);
            margin: 3rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .date-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--gold), var(--gold-dark), var(--gold));
        }
        
        .date-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: var(--gold);
            margin-bottom: 1.5rem;
        }
        
        .date-display {
            display: inline-flex;
            align-items: center;
            background: var(--ivory);
            padding: 1.5rem 2rem;
            border-radius: 8px;
            margin: 1rem 0;
        }
        
        .calendar-icon {
            width: 60px;
            height: 60px;
            background: var(--gold);
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-right: 1.5rem;
            color: white;
            font-weight: bold;
        }
        
        .month {
            font-size: 0.8rem;
            text-transform: uppercase;
            background: rgba(0, 0, 0, 0.2);
            width: 100%;
            text-align: center;
            padding: 2px 0;
        }
        
        .day {
            font-size: 1.5rem;
        }
        
        .date-text {
            text-align: left;
        }
        
        .date, .time {
            font-size: 1.2rem;
            font-weight: 500;
        }
        
        /* Location Section */
        .location-section {
            display: flex;
            margin: 4rem 0;
            height: 500px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }
        
        .location-map {
            flex: 1;
            height: 100%;
            background: #eee;
            position: relative;
        }
        
        .map-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(0,0,0,0.2), transparent);
            pointer-events: none;
        }
        
        .location-info {
            flex: 0 0 350px;
            background: white;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .location-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: var(--gold);
            margin-bottom: 1.5rem;
        }
        
        .venue-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .venue-address {
            color: var(--slate);
            margin-bottom: 2rem;
        }
        
        .direction-btn {
            background: var(--gold);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 1rem;
        }
        
        .direction-btn i {
            margin-right: 8px;
        }
        
        .direction-btn:hover {
            background: var(--gold-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(184, 138, 74, 0.3);
        }
        
        /* Gallery Section */
        .gallery-section {
            margin: 4rem 0;
        }
        
        .gallery-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            text-align: center;
            color: var(--gold);
            margin-bottom: 2rem;
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .gallery-item {
            height: 300px;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s;
        }
        
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        
        .gallery-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 1rem;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
            color: white;
            transform: translateY(100%);
            transition: var(--transition);
        }
        
        .gallery-item:hover .gallery-caption {
            transform: translateY(0);
        }
        
        /* Countdown Section */
        .countdown-section {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            padding: 4rem 2rem;
            border-radius: 10px;
            margin: 4rem 0;
            text-align: center;
            color: white;
            box-shadow: var(--shadow);
        }
        
        .countdown-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            margin-bottom: 2rem;
            letter-spacing: 2px;
        }
        
        .countdown-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .countdown-box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            padding: 1.5rem;
            border-radius: 8px;
            min-width: 100px;
            transition: var(--transition);
        }
        
        .countdown-box:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.25);
        }
        
        .countdown-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .countdown-label {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        /* RSVP Section */
        .rsvp-section {
            background: white;
            padding: 4rem;
            border-radius: 10px;
            box-shadow: var(--shadow);
            margin: 4rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .rsvp-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--gold), var(--gold-dark), var(--gold));
        }
        
        .rsvp-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--gold);
            margin-bottom: 1rem;
        }
        
        .rsvp-subtitle {
            color: var(--slate);
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }
        
        .rsvp-form {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-control {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
            background: var(--ivory);
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        }
        
        .form-label {
            position: absolute;
            top: 15px;
            left: 15px;
            color: var(--slate);
            transition: var(--transition);
            pointer-events: none;
            background: var(--ivory);
            padding: 0 5px;
        }
        
        .form-control:focus + .form-label,
        .form-control:not(:placeholder-shown) + .form-label {
            top: -10px;
            left: 10px;
            font-size: 0.8rem;
            color: var(--gold);
        }
        
        .submit-btn {
            background: var(--gold);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 1rem;
            letter-spacing: 1px;
        }
        
        .submit-btn:hover {
            background: var(--gold-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(184, 138, 74, 0.3);
        }
        
        /* Footer */
        .invitation-footer {
            text-align: center;
            padding: 2rem;
            color: var(--slate);
            font-size: 0.9rem;
        }
        
        /* Luxury Elements */
        .gold-ornament {
            position: absolute;
            width: 100px;
            height: 100px;
            opacity: 0.1;
            pointer-events: none;
        }
        
        .ornament-1 {
            top: 50px;
            left: 50px;
            background: radial-gradient(circle, var(--gold) 0%, transparent 70%);
        }
        
        .ornament-2 {
            bottom: 50px;
            right: 50px;
            background: radial-gradient(circle, var(--gold) 0%, transparent 70%);
        }
        
        /* Floating Elements */
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }
        
        .floating-element {
            position: absolute;
            color: var(--gold);
            opacity: 0.1;
            font-size: 1.5rem;
            animation: float 15s linear infinite;
        }
        
        @keyframes float {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }
            100% {
                transform: translate(100px, -100vh) rotate(360deg);
            }
        }
        
        /* Confetti */
        .confetti-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1000;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .couple-section {
                flex-direction: column;
            }
            
            .portrait-card {
                max-width: 250px;
                margin-bottom: 2rem;
            }
            
            .couple-names {
                order: -1;
                margin-bottom: 2rem;
            }
            
            .location-section {
                flex-direction: column;
                height: auto;
            }
            
            .location-info {
                padding: 2rem;
            }
        }
        
        @media (max-width: 768px) {
            .header-title {
                font-size: 2rem;
            }
            
            .couple-names h2 {
                font-size: 3.5rem;
            }
            
            .date-section, .rsvp-section {
                padding: 2rem;
            }
            
            .countdown-box {
                min-width: 80px;
                padding: 1rem;
            }
            
            .countdown-number {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 576px) {
            .invitation-container {
                padding: 1rem;
            }
            
            .cover-title {
                font-size: 2rem;
            }
            
            .cover-subtitle {
                font-size: 1.5rem;
            }
            
            .couple-names h2 {
                font-size: 2.5rem;
            }
            
            .date-display {
                flex-direction: column;
            }
            
            .calendar-icon {
                margin-right: 0;
                margin-bottom: 1rem;
            }
            
            .countdown-box {
                min-width: 60px;
                padding: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Luxury Loading Screen -->
    <div class="luxury-loader">
        <div class="monogram">S&M</div>
        <div class="progress-bar">
            <div class="progress" id="progress"></div>
        </div>
        <p class="loading-text">Loading the Celebration</p>
    </div>
    
    <!-- Luxury Cover -->
    <div class="invitation-cover" id="invitationCover">
        <div class="cover-content" id="coverContent">
            <h1 class="cover-title">Sarah & Michael</h1>
            <p class="cover-subtitle">Our Wedding Celebration</p>
            <button class="open-invitation" id="openInvitation">Open Invitation</button>
        </div>
    </div>
    
    <!-- Main Invitation Content -->
    <div class="invitation-container" id="invitationContainer">
        <!-- Decorative Elements -->
        <div class="gold-ornament ornament-1"></div>
        <div class="gold-ornament ornament-2"></div>
        
        <!-- Header -->
        <header class="invitation-header">
            <h1 class="header-title">Wedding Celebration</h1>
            <div class="ornamental-divider">
                <div class="divider-line"></div>
                <i class="fas fa-heart divider-icon"></i>
                <div class="divider-line"></div>
            </div>
            <p>Together with their families</p>
        </header>
        
        <!-- Couple Section -->
        <section class="couple-section">
            <div class="portrait-card groom">
                <div class="portrait-inner">
                    <div class="portrait-front"></div>
                    <div class="portrait-back">
                        <h3>Michael James</h3>
                        <p>Groom</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="couple-names">
                <h2>Sarah & Michael</h2>
                <p>Invite you to celebrate their union</p>
            </div>
            
            <div class="portrait-card bride">
                <div class="portrait-inner">
                    <div class="portrait-front"></div>
                    <div class="portrait-back">
                        <h3>Sarah Johnson</h3>
                        <p>Bride</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Date Section -->
        <section class="date-section">
            <h2 class="date-title">Save the Date</h2>
            <div class="date-display">
                <div class="calendar-icon">
                    <div class="month">Jun</div>
                    <div class="day">15</div>
                </div>
                <div class="date-text">
                    <p class="date">Saturday, June 15, 2024</p>
                    <p class="time">4:00 in the afternoon</p>
                </div>
            </div>
        </section>
        
        <!-- Location Section -->
        <section class="location-section">
            <div class="location-map" id="locationMap">
                <div class="map-overlay"></div>
                <!-- Map will be loaded via JavaScript -->
            </div>
            <div class="location-info">
                <h3 class="location-title">Location</h3>
                <p class="venue-name">Grand Ballroom</p>
                <p class="venue-address">The Ritz Hotel<br>123 Luxury Avenue<br>New York, NY 10001</p>
                <button class="direction-btn">
                    <i class="fas fa-map-marker-alt"></i> Get Directions
                </button>
            </div>
        </section>
        
        <!-- Gallery Section -->
        <section class="gallery-section">
            <h2 class="gallery-title">Our Journey Together</h2>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="../img/raka.jpg" alt="Couple photo 1">
                    <div class="gallery-caption">Our First Date</div>
                </div>
                <div class="gallery-item">
                    <img src="../img/raka.jpg" alt="Couple photo 2">
                    <div class="gallery-caption">Vacation in Paris</div>
                </div>
                <div class="gallery-item">
                    <img src="../img/raka.jpg" alt="Couple photo 3">
                    <div class="gallery-caption">Engagement Day</div>
                </div>
                <div class="gallery-item">
                    <img src="../img/raka.jpg" alt="Couple photo 4">
                    <div class="gallery-caption">Wedding Planning</div>
                </div>
            </div>
        </section>
        
        <!-- Countdown Section -->
        <section class="countdown-section">
            <h2 class="countdown-title">Counting Down to Our Special Day</h2>
            <div class="countdown-container">
                <div class="countdown-box">
                    <div class="countdown-number" id="days">00</div>
                    <div class="countdown-label">Days</div>
                </div>
                <div class="countdown-box">
                    <div class="countdown-number" id="hours">00</div>
                    <div class="countdown-label">Hours</div>
                </div>
                <div class="countdown-box">
                    <div class="countdown-number" id="minutes">00</div>
                    <div class="countdown-label">Minutes</div>
                </div>
                <div class="countdown-box">
                    <div class="countdown-number" id="seconds">00</div>
                    <div class="countdown-label">Seconds</div>
                </div>
            </div>
        </section>
        
        <!-- RSVP Section -->
        <section class="rsvp-section">
            <h2 class="rsvp-title">Will You Join Us?</h2>
            <p class="rsvp-subtitle">Kindly respond by June 10, 2024</p>
            
            <form class="rsvp-form" id="rsvpForm">
                <div class="form-group">
                    <input type="text" class="form-control" id="name" placeholder=" " required>
                    <label for="name" class="form-label">Your Name</label>
                </div>
                
                <div class="form-group">
                    <input type="email" class="form-control" id="email" placeholder=" " required>
                    <label for="email" class="form-label">Email Address</label>
                </div>
                
                <div class="form-group">
                    <select class="form-control" id="attendance" required>
                        <option value="" disabled selected> </option>
                        <option value="accept">Joyfully Accept</option>
                        <option value="decline">Regretfully Decline</option>
                    </select>
                    <label for="attendance" class="form-label">Will You Attend?</label>
                </div>
                
                <div class="form-group">
                    <input type="number" class="form-control" id="guests" min="1" value="1" placeholder=" " required>
                    <label for="guests" class="form-label">Number of Guests</label>
                </div>
                
                <div class="form-group">
                    <textarea class="form-control" id="message" rows="3" placeholder=" "></textarea>
                    <label for="message" class="form-label">Special Requests</label>
                </div>
                
                <button type="submit" class="submit-btn">Send RSVP</button>
            </form>
        </section>
        
        <!-- Footer -->
        <footer class="invitation-footer">
            <p>We look forward to celebrating with you!</p>
            <p>Sarah & Michael</p>
        </footer>
    </div>
    
    <!-- Floating Decorative Elements -->
    <div class="floating-elements" id="floatingElements"></div>
    
    <!-- Confetti Container -->
    <div class="confetti-container" id="confettiContainer"></div>
    
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simulate loading progress
            let progress = 0;
            const progressInterval = setInterval(function() {
                progress += Math.random() * 10;
                document.getElementById('progress').style.width = `${Math.min(progress, 100)}%`;
                
                if (progress >= 100) {
                    clearInterval(progressInterval);
                    
                    // Hide loader and show cover
                    gsap.to('.luxury-loader', {
                        opacity: 0,
                        duration: 0.8,
                        onComplete: function() {
                            document.querySelector('.luxury-loader').style.display = 'none';
                            
                            // Animate cover content in
                            gsap.to('#coverContent', {
                                y: 0,
                                opacity: 1,
                                duration: 1,
                                ease: 'power3.out'
                            });
                        }
                    });
                }
            }, 200);
            
            // Open invitation button
            document.getElementById('openInvitation').addEventListener('click', function() {
                // Animate cover out
                gsap.to('#invitationCover', {
                    y: '-100%',
                    duration: 1.5,
                    ease: 'power3.inOut'
                });
                
                // Show main invitation
                gsap.to('#invitationContainer', {
                    y: 0,
                    opacity: 1,
                    duration: 1,
                    delay: 0.5,
                    ease: 'power3.out'
                });
                
                // Create floating elements
                createFloatingElements();
                
                // Initialize countdown
                initializeCountdown();
                
                // Initialize map
                initializeMap();
                
                // Setup form submission
                setupRSVPForm();
                
                // Add scroll animations
                setupScrollAnimations();
            });
            
            // Create floating decorative elements
            function createFloatingElements() {
                const container = document.getElementById('floatingElements');
                const elements = ['✧', '❀', '✿', '✦', '✶', '✺', '✼', '❁'];
                
                for (let i = 0; i < 20; i++) {
                    const element = document.createElement('div');
                    element.className = 'floating-element';
                    element.textContent = elements[Math.floor(Math.random() * elements.length)];
                    
                    // Random position
                    element.style.left = `${Math.random() * 100}%`;
                    element.style.top = `${Math.random() * 100}%`;
                    
                    // Random animation duration and delay
                    element.style.animationDuration = `${15 + Math.random() * 20}s`;
                    element.style.animationDelay = `${Math.random() * 5}s`;
                    
                    container.appendChild(element);
                }
            }
            
            // Initialize countdown timer
            function initializeCountdown() {
                const weddingDate = new Date('June 15, 2024 16:00:00').getTime();
                
                const countdown = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = weddingDate - now;
                    
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    document.getElementById('days').textContent = days.toString().padStart(2, '0');
                    document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
                    document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
                    document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
                    
                    if (distance < 0) {
                        clearInterval(countdown);
                        document.querySelector('.countdown-section').innerHTML = `
                            <h2 class="countdown-title">Our Special Day Has Arrived!</h2>
                            <p>See you at the ceremony!</p>
                        `;
                    }
                }, 1000);
            }
            
            // Initialize map
            function initializeMap() {
                // In a real implementation, you would initialize Google Maps here
                // For this example, we'll just set a background image
                document.getElementById('locationMap').style.backgroundImage = "url('assets/images/map-placeholder.jpg')";
                document.getElementById('locationMap').style.backgroundSize = "cover";
                document.getElementById('locationMap').style.backgroundPosition = "center";
            }
            
            // Setup RSVP form
            function setupRSVPForm() {
                const form = document.getElementById('rsvpForm');
                
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Get form values
                    const name = document.getElementById('name').value;
                    const email = document.getElementById('email').value;
                    const attendance = document.getElementById('attendance').value;
                    const guests = document.getElementById('guests').value;
                    const message = document.getElementById('message').value;
                    
                    // In a real implementation, you would send this data to a server
                    console.log('RSVP Submitted:', {
                        name,
                        email,
                        attendance,
                        guests,
                        message
                    });
                    
                    // Show success message
                    showConfetti();
                    
                    // Reset form
                    form.reset();
                    
                    // Show thank you message
                    alert(`Thank you, ${name}, for your RSVP! We look forward to seeing you!`);
                });
            }
            
            // Create confetti effect
            function showConfetti() {
                const container = document.getElementById('confettiContainer');
                container.innerHTML = '';
                
                // Create confetti elements
                for (let i = 0; i < 100; i++) {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    
                    // Random shape
                    const shapes = ['circle', 'square', 'triangle'];
                    const randomShape = shapes[Math.floor(Math.random() * shapes.length)];
                    
                    // Random color
                    const colors = ['#D4AF37', '#E8C99B', '#B88A4A', '#FFFFFF'];
                    const randomColor = colors[Math.floor(Math.random() * colors.length)];
                    
                    // Set styles
                    confetti.style.width = `${5 + Math.random() * 10}px`;
                    confetti.style.height = `${5 + Math.random() * 10}px`;
                    confetti.style.backgroundColor = randomColor;
                    confetti.style.position = 'absolute';
                    confetti.style.left = `${Math.random() * 100}%`;
                    confetti.style.top = '-10px';
                    confetti.style.opacity = '0.8';
                    
                    // Animation
                    const animationDuration = `${2 + Math.random() * 3}s`;
                    
                    if (randomShape === 'circle') {
                        confetti.style.borderRadius = '50%';
                    } else if (randomShape === 'triangle') {
                        confetti.style.width = '0';
                        confetti.style.height = '0';
                        confetti.style.backgroundColor = 'transparent';
                        confetti.style.borderLeft = '5px solid transparent';
                        confetti.style.borderRight = '5px solid transparent';
                        confetti.style.borderBottom = `10px solid ${randomColor}`;
                    }
                    
                    // Animate
                    gsap.to(confetti, {
                        y: window.innerHeight + 10,
                        rotation: Math.random() * 360,
                        x: `+=${(Math.random() - 0.5) * 100}`,
                        duration: animationDuration,
                        ease: 'power1.out',
                        onComplete: function() {
                            container.removeChild(confetti);
                        }
                    });
                    
                    container.appendChild(confetti);
                }
            }
            
            // Setup scroll animations
            function setupScrollAnimations() {
                // Animate sections on scroll
                gsap.utils.toArray('section').forEach(section => {
                    gsap.from(section, {
                        scrollTrigger: {
                            trigger: section,
                            start: 'top 80%',
                            toggleActions: 'play none none none'
                        },
                        y: 50,
                        opacity: 0,
                        duration: 1,
                        ease: 'power3.out'
                    });
                });
                
                // Parallax effect for portrait cards
                gsap.to('.groom .portrait-inner', {
                    scrollTrigger: {
                        trigger: '.couple-section',
                        scrub: true
                    },
                    rotationY: -10,
                    ease: 'none'
                });
                
                gsap.to('.bride .portrait-inner', {
                    scrollTrigger: {
                        trigger: '.couple-section',
                        scrub: true
                    },
                    rotationY: 10,
                    ease: 'none'
                });
                
                // Animate gallery items sequentially
                gsap.utils.toArray('.gallery-item').forEach((item, i) => {
                    gsap.from(item, {
                        scrollTrigger: {
                            trigger: item,
                            start: 'top 80%',
                            toggleActions: 'play none none none'
                        },
                        y: 50,
                        opacity: 0,
                        duration: 0.8,
                        delay: i * 0.1,
                        ease: 'power3.out'
                    });
                });
            }
        });
    </script>
</body>
</html>