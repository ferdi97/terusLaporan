<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Gangguan IndiHome</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #E30613;
            --primary-dark: #C10511;
            --primary-light: #ffcdd2;
            --secondary: #2D3748;
            --accent: #F6AD55;
            --light: #F7FAFC;
            --dark: #1A202C;
            --gray: #E2E8F0;
            --gray-dark: #CBD5E0;
            --success: #48BB78;
            --warning: #ED8936;
            --error: #F56565;
            --border-radius: 12px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        [data-theme="dark"] {
            --primary: #ff5a5f;
            --primary-dark: #e04a4f;
            --primary-light: #ffcdd2;
            --secondary: #A0AEC0;
            --light: #2D3748;
            --dark: #F7FAFC;
            --gray: #4A5568;
            --gray-dark: #718096;
            --success: #68D391;
            --warning: #F6AD55;
            --error: #FC8181;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px;
            color: var(--dark);
            line-height: 1.6;
            transition: var(--transition);
        }

        body[data-theme="dark"] {
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
        }

        .app-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            display: flex;
            min-height: 600px;
            animation: fadeInUp 0.6s ease-out;
            transition: var(--transition);
        }

        body[data-theme="dark"] .app-container {
            background: #2D3748;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        /* Sidebar */
        .sidebar {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .sidebar::after {
            content: '';
            position: absolute;
            bottom: -80px;
            right: -80px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            z-index: 1;
        }

        .logo img {
            height: 40px;
            margin-right: 10px;
        }

        .sidebar-content {
            z-index: 1;
        }

        .sidebar h2 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .sidebar p {
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .sidebar-image {
            text-align: center;
            margin-top: 20px;
            z-index: 1;
        }

        .sidebar-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.5s ease;
        }

        .sidebar-image:hover img {
            transform: scale(1.05);
        }

        /* Theme Toggle */
        .theme-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            z-index: 10;
            transition: var(--transition);
        }

        .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Form Container */
        .form-container {
            flex: 1.5;
            padding: 40px;
            overflow-y: auto;
            max-height: 700px;
            transition: var(--transition);
        }

        body[data-theme="dark"] .form-container {
            background: #2D3748;
        }

        .form-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .form-header h1 {
            font-size: 28px;
            color: var(--primary);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .form-header p {
            color: var(--secondary);
            opacity: 0.8;
        }

        /* Progress Steps */
        .progress-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }

        .progress-steps::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--gray);
            z-index: 0;
            transition: var(--transition);
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 1;
        }

        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--gray);
            color: var(--secondary);
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 600;
            margin-bottom: 5px;
            transition: var(--transition);
        }

        .step.active .step-number {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        .step.completed .step-number {
            background: var(--success);
            color: white;
        }

        .step-label {
            font-size: 12px;
            font-weight: 500;
            color: var(--secondary);
            opacity: 0.7;
            transition: var(--transition);
        }

        .step.active .step-label {
            opacity: 1;
            font-weight: 600;
            color: var(--dark);
        }

        /* Form Sections */
        .form-section {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }

        .form-section.active {
            display: block;
        }

        /* Floating Labels */
        .float-label {
            position: relative;
            margin-bottom: 20px;
        }

        .float-label input,
        .float-label textarea,
        .float-label select {
            width: 100%;
            padding: 16px 15px 10px;
            border: 2px solid var(--gray);
            border-radius: 8px;
            font-size: 14px;
            transition: var(--transition);
            background: var(--light);
            color: var(--dark);
        }

        body[data-theme="dark"] .float-label input,
        body[data-theme="dark"] .float-label textarea,
        body[data-theme="dark"] .float-label select {
            background: #4A5568;
            color: white;
        }

        .float-label label {
            position: absolute;
            top: 18px;
            left: 15px;
            color: var(--secondary);
            opacity: 0.7;
            font-size: 14px;
            font-weight: 400;
            transition: var(--transition);
            pointer-events: none;
            background: var(--light);
            border-radius: 5px;
            border: 5px;
            border-color: #38a169;
            padding: 0 5px;
        }

        body[data-theme="dark"] .float-label label {
            background: #4A5568;
        }

        .float-label input:focus + label,
        .float-label textarea:focus + label,
        .float-label select:focus + label,
        .float-label input:not(:placeholder-shown) + label,
        .float-label textarea:not(:placeholder-shown) + label,
        .float-label select:not(:placeholder-shown) + label {
            top: -8px;
            left: 10px;
            font-size: 12px;
            opacity: 1;
            color: var(--primary);
            font-weight: 500;
        }

        .float-label input:focus,
        .float-label textarea:focus,
        .float-label select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(227, 6, 19, 0.2);
        }

        .float-label input.error,
        .float-label textarea.error,
        .float-label select.error {
            border-color: var(--error);
        }

        .float-label input.error:focus,
        .float-label textarea.error:focus,
        .float-label select.error:focus {
            box-shadow: 0 0 0 3px rgba(245, 101, 101, 0.2);
        }

        .error-message {
            color: var(--error);
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            font-size: 14px;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(227, 6, 19, 0.2);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: rgba(227, 6, 19, 0.05);
            transform: translateY(-2px);
        }

        body[data-theme="dark"] .btn-secondary {
            background: #4A5568;
            color: white;
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-success:hover {
            background: #38a169;
            transform: translateY(-2px);
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        /* Form Navigation */
        .form-navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        /* Success Message */
        .success-message {
            text-align: center;
            padding: 40px;
            display: none;
        }

        .success-message.active {
            display: block;
            animation: fadeIn 0.5s ease-out;
        }

        .success-icon {
            font-size: 80px;
            color: var(--success);
            margin-bottom: 20px;
            animation: bounce 1s;
        }

        .success-message h2 {
            font-size: 28px;
            color: var(--success);
            margin-bottom: 15px;
        }

        .success-message p {
            margin-bottom: 25px;
            color: var(--secondary);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-out;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: fadeInUp 0.3s ease-out;
            transition: var(--transition);
        }

        body[data-theme="dark"] .modal-content {
            background: #2D3748;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 22px;
            font-weight: 600;
            color: var(--primary);
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--secondary);
        }

        .modal-body {
            margin-bottom: 25px;
        }

        .data-row {
            display: flex;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--gray);
        }

        .data-label {
            font-weight: 600;
            color: var(--secondary);
            min-width: 120px;
        }

        .data-value {
            color: var(--dark);
            flex: 1;
            word-break: break-word;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Loading Spinner */
        .spinner {
            display: none;
            width: 40px;
            height: 40px;
            margin: 20px auto;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }

        /* Tooltip */
        .tooltip {
            position: relative;
            display: inline-block;
            margin-left: 5px;
            cursor: pointer;
        }

        .tooltip-icon {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 18px;
            height: 18px;
            background: var(--gray);
            color: var(--secondary);
            border-radius: 50%;
            font-size: 12px;
            font-weight: bold;
            transition: var(--transition);
        }

        .tooltip:hover .tooltip-icon {
            background: var(--primary);
            color: white;
        }

        .tooltip-text {
            visibility: hidden;
            width: 200px;
            background: var(--dark);
            color: white;
            text-align: center;
            border-radius: 6px;
            padding: 8px;
            position: absolute;
            z-index: 1000;
            bottom: auto;
            top: 125%;
            left: 450%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 12px;
            font-weight: normal;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .app-container {
                flex-direction: column;
                min-height: auto;
            }

            .sidebar {
                padding: 30px 20px;
            }

            .sidebar-image {
                display: none;
            }

            .form-container {
                padding: 30px 20px;
                max-height: none;
            }

            .progress-steps {
                margin-bottom: 20px;
            }

            .step-label {
                display: none;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeInUp {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-20px);}
            60% {transform: translateY(-10px);}
        }

        /* Notification */
        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--success);
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            z-index: 1001;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .notification.show {
            transform: translateY(0);
            opacity: 1;
        }

        .notification i {
            margin-right: 10px;
            font-size: 20px;
        }

        .notification.error {
            background: var(--error);
        }

        /* Location Display */
        .location-display {
            background: var(--light);
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
            border: 1px solid var(--gray);
        }

        .location-display p {
            margin: 5px 0;
        }

        /* Ad Modal */
        .ad-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-out;
        }

        .ad-content {
            background: white;
            padding: 25px;
            border-radius: var(--border-radius);
            max-width: 500px;
            width: 90%;
            text-align: center;
            box-shadow: var(--box-shadow);
        }

        .ad-content img {
            max-width: 100%;
            border-radius: 8px;
            margin: 10px 0;
        }

        .close-ad {
            margin-top: 15px;
            padding: 10px 20px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
        }

        .close-ad:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <button class="theme-toggle" id="themeToggle">
                <i class="fas fa-moon"></i>
            </button>
            <div class="logo">
                <span>IndiHome</span>
            </div>
            <div class="sidebar-content">
                <h2>Laporkan Gangguan Anda</h2>
                <p>Isi formulir berikut untuk melaporkan gangguan layanan IndiHome Anda. Tim kami akan segera menindaklanjuti laporan Anda.</p>
            </div>
            <div class="sidebar-image">
                <img src="img/indi.png" alt="Customer Support">
            </div>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <div class="form-header">
                <h1>Laporan Gangguan</h1>
                <p>Mohon lengkapi data berikut dengan benar</p>
            </div>

            <!-- Progress Steps -->
            <div class="progress-steps">
                <div class="step active" data-step="1">
                    <div class="step-number">1</div>
                    <div class="step-label">Informasi Pelanggan</div>
                </div>
                <div class="step" data-step="2">
                    <div class="step-number">2</div>
                    <div class="step-label">Alamat</div>
                </div>
                <div class="step" data-step="3">
                    <div class="step-number">3</div>
                    <div class="step-label">Keluhan</div>
                </div>
                <div class="step" data-step="4">
                    <div class="step-number">4</div>
                    <div class="step-label">Konfirmasi</div>
                </div>
            </div>

            <!-- Form Sections -->
            <form id="reportForm">
                <!-- Step 1: Customer Information -->
                <div class="form-section active" data-section="1">
                    <div class="float-label">
                        <input type="text" id="nomor-internet" name="nomor_internet" placeholder=" " required pattern="^(05\d{7,8}|16\d{10,11})$" title="Nomor Internet harus diawali dengan 05 (9-10 digit) atau 16 (12-13 digit)">
                        <label for="nomor-internet">Nomor Internet</label>
                        <div class="tooltip">
                            <span class="tooltip-icon">?</span>
                            <span class="tooltip-text">Contoh: 05xxxx (9-10 digit) atau 16xxxxxxxx (12-13 digit)</span>
                        </div>
                        <div class="error-message" id="nomor-internet-error">Format nomor internet tidak valid</div>
                    </div>

                    <div class="float-label">
                        <input type="text" id="nama-pelapor" name="nama_pelapor" placeholder=" " required minlength="3">
                        <label for="nama-pelapor">Nama Lengkap</label>
                        <div class="error-message" id="nama-pelapor-error">Nama harus minimal 3 karakter</div>
                    </div>

                    <div class="float-label">
                        <input type="tel" id="no-hp-pelapor" name="no_hp_pelapor" placeholder=" " required pattern="^[0-9]{10,13}$" title="Nomor HP harus 10-13 digit angka">
                        <label for="no-hp-pelapor">Nomor HP</label>
                        <div class="error-message" id="no-hp-pelapor-error">Nomor HP harus 10-13 digit angka</div>
                    </div>

                    <div class="form-navigation">
                        <button type="button" class="btn btn-secondary btn-prev" disabled>
                            <i class="fas fa-arrow-left"></i> Sebelumnya
                        </button>
                        <button type="button" class="btn btn-primary btn-next">
                            Selanjutnya <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Address -->
                <div class="form-section" data-section="2">
                    <div class="float-label">
                        <input type="text" id="jalan" name="jalan" placeholder=" " required>
                        <label for="jalan">Jalan</label>
                        <div class="error-message" id="jalan-error">Mohon isi nama jalan</div>
                    </div>

                    <div class="float-label">
                        <input type="text" id="rt-rw" name="rt_rw" placeholder=" " required pattern="^\d{1,3}/\d{1,3}$" title="Format RT/RW (contoh: 001/002)">
                        <label for="rt-rw">RT/RW</label>
                        <div class="error-message" id="rt-rw-error">Format RT/RW tidak valid (contoh: 001/002)</div>
                    </div>

                    <div class="float-label">
                        <input type="text" id="kelurahan" name="kelurahan" placeholder=" " required>
                        <label for="kelurahan">Kelurahan</label>
                        <div class="error-message" id="kelurahan-error">Mohon isi nama kelurahan</div>
                    </div>

                    <div class="float-label">
                        <input type="text" id="kecamatan" name="kecamatan" placeholder=" " required>
                        <label for="kecamatan">Kecamatan</label>
                        <div class="error-message" id="kecamatan-error">Mohon isi nama kecamatan</div>
                    </div>

                    <div class="float-label">
                        <input type="text" id="kota-kabupaten" name="kota_kabupaten" placeholder=" " required>
                        <label for="kota-kabupaten">Kota/Kabupaten</label>
                        <div class="error-message" id="kota-kabupaten-error">Mohon isi nama kota/kabupaten</div>
                    </div>

                    <div class="form-navigation">
                        <button type="button" class="btn btn-secondary btn-prev">
                            <i class="fas fa-arrow-left"></i> Sebelumnya
                        </button>
                        <button type="button" class="btn btn-primary btn-next">
                            Selanjutnya <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Complaint -->
                <div class="form-section" data-section="3">
                    <div class="float-label">
                        <textarea id="keluhan-gangguan" name="keluhan" placeholder=" " required minlength="3"></textarea>
                        <label for="keluhan-gangguan">Deskripsi Keluhan</label>
                        <div class="error-message" id="keluhan-gangguan-error">Deskripsi keluhan minimal 3 karakter</div>
                    </div>

                    <div class="form-group">
                        <button type="button" id="shareButton" class="btn btn-secondary">
                            <i class="fas fa-location-arrow"></i> Deteksi Lokasi Saya
                        </button>
                        <input type="hidden" id="share-location" name="share_location" required>
                        <div class="error-message" id="location-error">Mohon tentukan lokasi Anda</div>
                        <div id="location-info" class="location-display" style="display: none;">
                            <p><strong>Koordinat:</strong> <span id="coordinates"></span></p>
                            <p><strong>Alamat:</strong> <span id="address"></span></p>
                        </div>
                    </div>

                    <div class="form-navigation">
                        <button type="button" class="btn btn-secondary btn-prev">
                            <i class="fas fa-arrow-left"></i> Sebelumnya
                        </button>
                        <button type="button" class="btn btn-primary btn-next">
                            Tinjau <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 4: Confirmation -->
                <div class="form-section" data-section="4">
                    <div class="form-group">
                        <h3 style="margin-bottom: 20px; color: var(--primary);">Konfirmasi Data Anda</h3>
                        <div id="confirmation-data" style="background: var(--light); padding: 20px; border-radius: 8px;"></div>
                    </div>

                    <div class="form-navigation">
                        <button type="button" class="btn btn-secondary btn-prev">
                            <i class="fas fa-arrow-left"></i> Sebelumnya
                        </button>
                        <button type="submit" class="btn btn-success" id="submit-btn">
                            <i class="fas fa-paper-plane"></i> Kirim Laporan
                        </button>
                    </div>
                </div>
            </form>

            <!-- Success Message -->
            <div class="success-message">
                <div class="success-icon">✓</div>
                <h2>Laporan Berhasil Dikirim!</h2>
                <p>Terima kasih telah melaporkan gangguan. Tim kami akan segera menghubungi Anda.</p>
                <div id="ticket-info" style="text-align: left; background: var(--light); padding: 15px; border-radius: 8px; margin-bottom: 20px;"></div>
                <button type="button" class="btn btn-primary" id="new-report-btn">
                    <i class="fas fa-plus"></i> Buat Laporan Baru
                </button>
            </div>

            <!-- Loading Spinner -->
            <div class="spinner" id="loading-spinner"></div>
        </div>
    </div>

    <!-- Ad Modal -->
    <div class="ad-modal" id="adModal">
        <div class="ad-content">
            <h2>🛎️ ---- 🛎️</h2>
            <img src="img/anim2.gif" alt="Promo IndiHome" id="adImage">
            <p><strong></strong><strong></strong></p>
            <button class="close-ad" id="closeAd">Tutup</button>
        </div>
    </div>

    <!-- Summary Modal -->
    <div class="modal" id="summaryModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Detail Laporan</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body" id="modal-body-content">
                <!-- Content will be inserted here -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary close-modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
                <button class="btn btn-primary" id="copy-btn">
                    <i class="fas fa-copy"></i> Salin Data
                </button>
            </div>
        </div>
    </div>

    <!-- Notification -->
    <div class="notification" id="notification">
        <i class="fas fa-check-circle"></i>
        <span>Data berhasil disalin ke clipboard!</span>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize variables
            let currentStep = 1;
            const totalSteps = 4;
            let ticketNumber = generateTicketNumber();

            // Initialize form
            initForm();

            // Theme toggle
            const themeToggle = document.getElementById('themeToggle');
            themeToggle.addEventListener('click', toggleTheme);

            // Check for saved theme preference
            if (localStorage.getItem('theme') === 'dark') {
                document.body.setAttribute('data-theme', 'dark');
                themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            }

            // Form navigation
            document.querySelectorAll('.btn-next').forEach(button => {
                button.addEventListener('click', nextStep);
            });

            document.querySelectorAll('.btn-prev').forEach(button => {
                button.addEventListener('click', prevStep);
            });

            // Share location button
            document.getElementById('shareButton').addEventListener('click', getCurrentLocation);

            // Form submission
            document.getElementById('reportForm').addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm();
            });

            // New report button
            document.getElementById('new-report-btn').addEventListener('click', resetForm);

            // Modal close buttons
            document.querySelectorAll('.close-modal').forEach(button => {
                button.addEventListener('click', () => {
                    document.getElementById('summaryModal').classList.remove('active');
                });
            });

            // Copy button
            document.getElementById('copy-btn').addEventListener('click', copyReportData);

            // Close ad button
            document.getElementById('closeAd').addEventListener('click', () => {
                document.getElementById('adModal').style.display = 'none';
            });

            // Real-time validation
            document.getElementById('nomor-internet').addEventListener('input', validateInternetNumber);
            document.getElementById('nama-pelapor').addEventListener('input', validateName);
            document.getElementById('no-hp-pelapor').addEventListener('input', validatePhoneNumber);
            document.getElementById('rt-rw').addEventListener('input', validateRTRW);
            document.getElementById('keluhan-gangguan').addEventListener('input', validateComplaint);

            // Show ad on every page reload
            setTimeout(() => {
                document.getElementById('adModal').style.display = 'flex';
            }, 2000);

            // Initialize form function
            function initForm() {
                updateStepIndicator();
                document.getElementById('nomor-internet').focus();
            }

            // Toggle theme function
            function toggleTheme() {
                if (document.body.getAttribute('data-theme') === 'dark') {
                    document.body.removeAttribute('data-theme');
                    localStorage.setItem('theme', 'light');
                    themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                } else {
                    document.body.setAttribute('data-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                    themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                }
            }

            // Get current location function
            function getCurrentLocation() {
                if (navigator.geolocation) {
                    document.getElementById('shareButton').disabled = true;
                    document.getElementById('shareButton').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mendeteksi Lokasi...';
                    
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const userLat = position.coords.latitude;
                            const userLng = position.coords.longitude;
                            
                            // Update location field
                            document.getElementById('share-location').value = `${userLat}, ${userLng}`;
                            document.getElementById('location-error').style.display = 'none';
                            
                            // Show coordinates
                            document.getElementById('coordinates').textContent = `${userLat}, ${userLng}`;
                            
                            // Reverse geocode to get address
                            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${userLat}&lon=${userLng}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.display_name) {
                                        document.getElementById('address').textContent = data.display_name;
                                    } else {
                                        document.getElementById('address').textContent = 'Alamat tidak ditemukan';
                                    }
                                    
                                    // Show location info
                                    document.getElementById('location-info').style.display = 'block';
                                    
                                    document.getElementById('shareButton').disabled = false;
                                    document.getElementById('shareButton').innerHTML = '<i class="fas fa-location-arrow"></i> Perbarui Lokasi';
                                })
                                .catch(error => {
                                    console.error('Error getting address:', error);
                                    document.getElementById('address').textContent = 'Gagal mendapatkan alamat';
                                    document.getElementById('location-info').style.display = 'block';
                                    document.getElementById('shareButton').disabled = false;
                                    document.getElementById('shareButton').innerHTML = '<i class="fas fa-location-arrow"></i> Perbarui Lokasi';
                                });
                        },
                        function(error) {
                            console.error('Error getting location:', error);
                            showNotification('Gagal mendapatkan lokasi: ' + error.message, false);
                            document.getElementById('shareButton').disabled = false;
                            document.getElementById('shareButton').innerHTML = '<i class="fas fa-location-arrow"></i> Deteksi Lokasi Saya';
                        }
                    );
                } else {
                    alert('Browser Anda tidak mendukung geolokasi.');
                }
            }

            // Validation functions
            function validateInternetNumber() {
                const field = document.getElementById('nomor-internet');
                const error = document.getElementById('nomor-internet-error');
                const value = field.value.trim();
                
                if (!value) {
                    field.classList.remove('error');
                    error.style.display = 'none';
                    return false;
                }
                
                const isValid = /^(05\d{7,8}|16\d{10,11})$/.test(value);
                
                if (!isValid) {
                    field.classList.add('error');
                    error.style.display = 'block';
                } else {
                    field.classList.remove('error');
                    error.style.display = 'none';
                }
                
                return isValid;
            }
            
            function validateName() {
                const field = document.getElementById('nama-pelapor');
                const error = document.getElementById('nama-pelapor-error');
                const value = field.value.trim();
                
                if (!value) {
                    field.classList.remove('error');
                    error.style.display = 'none';
                    return false;
                }
                
                const isValid = value.length >= 3;
                
                if (!isValid) {
                    field.classList.add('error');
                    error.style.display = 'block';
                } else {
                    field.classList.remove('error');
                    error.style.display = 'none';
                }
                
                return isValid;
            }
            
            function validatePhoneNumber() {
                const field = document.getElementById('no-hp-pelapor');
                const error = document.getElementById('no-hp-pelapor-error');
                const value = field.value.trim();
                
                if (!value) {
                    field.classList.remove('error');
                    error.style.display = 'none';
                    return false;
                }
                
                const isValid = /^[0-9]{10,13}$/.test(value);
                
                if (!isValid) {
                    field.classList.add('error');
                    error.style.display = 'block';
                } else {
                    field.classList.remove('error');
                    error.style.display = 'none';
                }
                
                return isValid;
            }
            
            function validateRTRW() {
                const field = document.getElementById('rt-rw');
                const error = document.getElementById('rt-rw-error');
                const value = field.value.trim();
                
                if (!value) {
                    field.classList.remove('error');
                    error.style.display = 'none';
                    return false;
                }
                
                const isValid = /^\d{1,3}\/\d{1,3}$/.test(value);
                
                if (!isValid) {
                    field.classList.add('error');
                    error.style.display = 'block';
                } else {
                    field.classList.remove('error');
                    error.style.display = 'none';
                }
                
                return isValid;
            }
            
            function validateComplaint() {
                const field = document.getElementById('keluhan-gangguan');
                const error = document.getElementById('keluhan-gangguan-error');
                const value = field.value.trim();
                
                if (!value) {
                    field.classList.remove('error');
                    error.style.display = 'none';
                    return false;
                }
                
                const isValid = value.length >= 3;
                
                if (!isValid) {
                    field.classList.add('error');
                    error.style.display = 'block';
                } else {
                    field.classList.remove('error');
                    error.style.display = 'none';
                }
                
                return isValid;
            }

            // Next step function
            function nextStep() {
                if (validateCurrentStep()) {
                    // Hide current section with animation
                    const currentSection = document.querySelector(`.form-section[data-section="${currentStep}"]`);
                    currentSection.classList.remove('active');
                    currentSection.style.animation = 'fadeOut 0.3s ease-out';
                    
                    setTimeout(() => {
                        currentSection.style.animation = '';
                        document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
                        
                        // Move to next step
                        currentStep++;
                        
                        // If last step, show confirmation
                        if (currentStep === totalSteps) {
                            showConfirmation();
                        }
                        
                        // Show next section with animation
                        const nextSection = document.querySelector(`.form-section[data-section="${currentStep}"]`);
                        nextSection.classList.add('active');
                        document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('active');
                        
                        // Update step indicator
                        updateStepIndicator();
                    }, 300);
                }
            }

            // Previous step function
            function prevStep() {
                // Hide current section with animation
                const currentSection = document.querySelector(`.form-section[data-section="${currentStep}"]`);
                currentSection.classList.remove('active');
                currentSection.style.animation = 'fadeOut 0.3s ease-out';
                
                setTimeout(() => {
                    currentSection.style.animation = '';
                    document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
                    
                    // Move to previous step
                    currentStep--;
                    
                    // Show previous section with animation
                    const prevSection = document.querySelector(`.form-section[data-section="${currentStep}"]`);
                    prevSection.classList.add('active');
                    document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('active');
                    
                    // Update step indicator
                    updateStepIndicator();
                }, 300);
            }

            // Update step indicator function
            function updateStepIndicator() {
                document.querySelectorAll('.step').forEach((step, index) => {
                    if (index + 1 < currentStep) {
                        step.classList.add('completed');
                        step.classList.remove('active');
                    } else if (index + 1 === currentStep) {
                        step.classList.add('active');
                        step.classList.remove('completed');
                    } else {
                        step.classList.remove('active', 'completed');
                    }
                });

                // Update navigation buttons
                document.querySelectorAll('.btn-prev').forEach(button => {
                    button.disabled = currentStep === 1;
                });

                document.querySelectorAll('.btn-next').forEach(button => {
                    button.textContent = currentStep === totalSteps - 1 ? 'Tinjau' : 'Selanjutnya';
                    if (currentStep === totalSteps - 1) {
                        button.innerHTML = 'Tinjau <i class="fas fa-search"></i>';
                    } else {
                        button.innerHTML = 'Selanjutnya <i class="fas fa-arrow-right"></i>';
                    }
                });
            }

            // Validate current step function
            function validateCurrentStep() {
                let isValid = true;
                const currentSection = document.querySelector(`.form-section[data-section="${currentStep}"]`);

                // Validate all required fields in current section
                currentSection.querySelectorAll('[required]').forEach(field => {
                    if (!field.value.trim()) {
                        field.style.borderColor = 'var(--error)';
                        setTimeout(() => {
                            field.style.borderColor = '';
                        }, 2000);
                        
                        // Show error message if available
                        const errorId = field.id + '-error';
                        const errorElement = document.getElementById(errorId);
                        if (errorElement) {
                            errorElement.style.display = 'block';
                        }
                        
                        isValid = false;
                    }
                });

                // Special validation for step 1
                if (currentStep === 1) {
                    if (!validateInternetNumber() || !validateName() || !validatePhoneNumber()) {
                        isValid = false;
                    }
                }
                
                // Special validation for step 2
                if (currentStep === 2) {
                    if (!validateRTRW()) {
                        isValid = false;
                    }
                }
                
                // Special validation for step 3
                if (currentStep === 3) {
                    if (!validateComplaint()) {
                        isValid = false;
                    }
                    
                    // Validate location
                    const locationField = document.getElementById('share-location');
                    if (!locationField.value.trim()) {
                        document.getElementById('location-error').style.display = 'block';
                        isValid = false;
                    } else {
                        document.getElementById('location-error').style.display = 'none';
                    }
                }

                if (!isValid) {
                    // Add shake animation to invalid section
                    currentSection.classList.add('animate__animated', 'animate__headShake');
                    setTimeout(() => {
                        currentSection.classList.remove('animate__animated', 'animate__headShake');
                    }, 1000);
                    
                    // Scroll to first error
                    const firstError = currentSection.querySelector('.error');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }

                return isValid;
            }

            // Show confirmation function
            function showConfirmation() {
                const formData = new FormData(document.getElementById('reportForm'));
                const confirmationDiv = document.getElementById('confirmation-data');
                
                // Combine address parts
                const alamatLengkap = `
                    ${formData.get('jalan')}, 
                    RT/RW ${formData.get('rt_rw')}, 
                    Kel. ${formData.get('kelurahan')}, 
                    Kec. ${formData.get('kecamatan')}, 
                    ${formData.get('kota_kabupaten')}
                `;

                confirmationDiv.innerHTML = `
                    <p><strong>Nomor Internet:</strong> ${formData.get('nomor_internet')}</p>
                    <p><strong>Nama Pelapor:</strong> ${formData.get('nama_pelapor')}</p>
                    <p><strong>Nomor HP:</strong> ${formData.get('no_hp_pelapor')}</p>
                    <p><strong>Alamat Lengkap:</strong> ${alamatLengkap}</p>
                    <p><strong>Keluhan:</strong> ${formData.get('keluhan')}</p>
                    <p><strong>Lokasi:</strong> ${formData.get('share_location')}</p>
                `;
            }

            // Generate ticket number function
            function generateTicketNumber() {
                const randomNum = Math.floor(1000000000 + Math.random() * 9000000000);
                return `IND${randomNum}`;
            }

            // Submit form function
            function submitForm() {
                // Show loading spinner
                document.getElementById('loading-spinner').style.display = 'block';
                document.getElementById('submit-btn').disabled = true;
                
                // Get form data
                const formData = new FormData(document.getElementById('reportForm'));
                
                // Combine address parts
                const alamatLengkap = `
                    ${formData.get('jalan')}, 
                    RT/RW ${formData.get('rt_rw')}, 
                    Kel. ${formData.get('kelurahan')}, 
                    Kec. ${formData.get('kecamatan')}, 
                    ${formData.get('kota_kabupaten')}
                `;
                
                // Prepare data for submission
                const data = {
                    nomor_internet: formData.get('nomor_internet'),
                    nama_pelapor: formData.get('nama_pelapor'),
                    no_hp_pelapor: formData.get('no_hp_pelapor'),
                    jalan: formData.get('jalan'),
                    rt_rw: formData.get('rt_rw'),
                    kelurahan: formData.get('kelurahan'),
                    kecamatan: formData.get('kecamatan'),
                    kota_kabupaten: formData.get('kota_kabupaten'),
                    keluhan: formData.get('keluhan'),
                    share_location: formData.get('share_location')
                };

                // Send data to server using fetch to save_data.php
                fetch('save_data.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Hide form and show success message
                        document.getElementById('reportForm').style.display = 'none';
                        document.querySelector('.success-message').classList.add('active');
                        
                        // Display ticket info
                        document.getElementById('ticket-info').innerHTML = `
                            <p><strong>Nomor Tiket:</strong> ${data.data.kd_tiket}</p>
                            <p><strong>Tanggal Laporan:</strong> ${new Date().toLocaleString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            })}</p>
                        `;
                        
                        // Show modal with summary
                        document.getElementById('modal-body-content').innerHTML = `
                            <div class="data-row">
                                <div class="data-label">Nomor Tiket</div>
                                <div class="data-value">${data.data.kd_tiket}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">Nomor Internet</div>
                                <div class="data-value">${data.data.nomor_internet}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">Nama Pelapor</div>
                                <div class="data-value">${data.data.nama_pelapor}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">Nomor HP</div>
                                <div class="data-value">${data.data.no_hp_pelapor}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">Alamat</div>
                                <div class="data-value">${data.data.alamat_lengkap.replace(/\|/g, ', ')}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">Keluhan</div>
                                <div class="data-value">${data.data.keluhan}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">Lokasi</div>
                                <div class="data-value">${data.data.share_location}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">Tanggal</div>
                                <div class="data-value">${new Date().toLocaleString('id-ID', {
                                    weekday: 'long',
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                })}</div>
                            </div>
                        `;
                        
                        document.getElementById('summaryModal').classList.add('active');
                    } else {
                        showNotification('Gagal mengirim laporan: ' + data.message, false);
                    }
                })
                .catch((error) => {
                    showNotification('Terjadi kesalahan jaringan', false);
                    console.error('Error:', error);
                })
                .finally(() => {
                    document.getElementById('loading-spinner').style.display = 'none';
                    document.getElementById('submit-btn').disabled = false;
                });
            }

            // Copy report data function
            function copyReportData() {
                const modalContent = document.getElementById('modal-body-content');
                const rows = modalContent.querySelectorAll('.data-row');
                
                let textToCopy = "LAPORAN GANGGUAN INDIHOME\n";
                textToCopy += "=============================\n";
                
                rows.forEach(row => {
                    const label = row.querySelector('.data-label').textContent;
                    const value = row.querySelector('.data-value').textContent;
                    textToCopy += `${label}: ${value}\n`;
                });
                
                navigator.clipboard.writeText(textToCopy)
                    .then(() => {
                        showNotification('Data berhasil disalin ke clipboard!');
                    })
                    .catch(err => {
                        console.error('Failed to copy:', err);
                        showNotification('Gagal menyalin data', false);
                    });
            }

            // Show notification function
            function showNotification(message, isSuccess = true) {
                const notification = document.getElementById('notification');
                notification.innerHTML = `<i class="fas ${isSuccess ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i> <span>${message}</span>`;
                notification.className = isSuccess ? 'notification show' : 'notification show error';
                
                setTimeout(() => {
                    notification.classList.remove('show');
                }, 3000);
            }

            // Reset form function
            function resetForm() {
                // Reset form fields
                document.getElementById('reportForm').reset();
                
                // Reset validation errors
                document.querySelectorAll('.error-message').forEach(el => {
                    el.style.display = 'none';
                });
                
                document.querySelectorAll('.float-label input, .float-label textarea, .float-label select').forEach(el => {
                    el.classList.remove('error');
                });
                
                // Reset location info
                document.getElementById('share-location').value = '';
                document.getElementById('location-info').style.display = 'none';
                
                // Hide success message and show form
                document.querySelector('.success-message').classList.remove('active');
                document.getElementById('reportForm').style.display = 'block';
                
                // Reset to first step
                document.querySelectorAll('.form-section').forEach(section => {
                    section.classList.remove('active');
                });
                document.querySelector('.form-section[data-section="1"]').classList.add('active');
                
                // Reset steps
                currentStep = 1;
                updateStepIndicator();
                
                // Generate new ticket number
                ticketNumber = generateTicketNumber();
                
                // Focus on first field
                document.getElementById('nomor-internet').focus();
            }
        });
    </script>
</body>
</html>