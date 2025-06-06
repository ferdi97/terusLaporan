<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #ff9a8b, #ff6a88);
            overflow: hidden;
            position: relative;
        }
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
            transition: opacity 0.5s, visibility 0.5s;
        }
        .loading-screen.hidden {
            opacity: 0;
            visibility: hidden;
        }
        .cube {
            width: 50px;
            height: 50px;
            position: relative;
            transform-style: preserve-3d;
            animation: rotateCube 1.5s infinite linear;
        }
        .cube div {
            position: absolute;
            width: 50px;
            height: 50px;
            background: linear-gradient(45deg, #ff9a8b, #ff6a88);
            border: 2px solid rgba(255, 255, 255, 0.5);
        }
        .cube .front  { transform: translateZ(25px); }
        .cube .back   { transform: rotateY(180deg) translateZ(25px); }
        .cube .left   { transform: rotateY(-90deg) translateZ(25px); }
        .cube .right  { transform: rotateY(90deg) translateZ(25px); }
        .cube .top    { transform: rotateX(90deg) translateZ(25px); }
        .cube .bottom { transform: rotateX(-90deg) translateZ(25px); }
        @keyframes rotateCube {
            from { transform: rotateX(0) rotateY(0); }
            to { transform: rotateX(360deg) rotateY(360deg); }
        }  
        .register-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 350px;
            animation: floatUp 1s ease-in-out infinite alternate;
            transform-style: preserve-3d;
        }
        @keyframes floatUp {
            from { transform: translateY(0px); }
            to { transform: translateY(-10px); }
        }
        h2 {
            font-size: 28px;
            font-weight: bold;
            color: #ff3b5c;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.2);
        }
        .input-group {
            display: flex;
            align-items: center;
            background: #f1f1f1;
            padding: 12px;
            margin: 15px 0;
            border-radius: 10px;
            box-shadow: inset 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
            position: relative;
        }
        .input-group:hover {
            background: #e0e0e0;
        }
        .input-group i {
            color: #ff3b5c;
            font-size: 18px;
            margin-right: 10px;
        }
        .input-group input {
            border: none;
            outline: none;
            background: none;
            width: 100%;
            font-size: 16px;
            padding-left: 10px;
        }
        .register-btn {
            background: linear-gradient(45deg, #ff3b5c, #ff6a88);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(255, 59, 92, 0.4);
        }
        .register-btn:hover {
            background: linear-gradient(45deg, #ff6a88, #ff9a8b);
            transform: translateY(-3px) scale(1.05);
        }
        .error-message {
            color: red;
            font-size: 12px;
            position: absolute;
            bottom: -18px;
            left: 50px;
            display: none;
        }
        .input-error {
            box-shadow: 0 0 0 2px rgba(255, 0, 0, 0.2);
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
        .shake {
            animation: shake 0.5s;
        }
    </style>
</head>
<body>
    <div class="loading-screen" id="loading-screen">
        <div class="cube">
            <div class="front"></div>
            <div class="back"></div>
            <div class="left"></div>
            <div class="right"></div>
            <div class="top"></div>
            <div class="bottom"></div>
        </div>
    </div>
    <div class="register-container" id="register-container">
        <h2>Register</h2>
        <form action="end_register.php" method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="nama_csr" placeholder="Nama CSR" required>
            </div>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="confirm_password" name="konfirmasi_password" placeholder="Konfirmasi Password" required>
                <span id="password_error" class="error-message">Password tidak sama!</span>
            </div>
            <div class="input-group" style="margin-top: 30px;">
                <i class="fas fa-map-marker-alt"></i>
                <input type="text" name="lokasi_grapari" placeholder="Lokasi Grapari" required>
            </div>
            <button type="submit" class="register-btn">Register</button>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Loading screen logic
            setTimeout(() => {
                document.getElementById("loading-screen").classList.add("hidden");
                document.getElementById("register-container").style.display = "block";
            }, 1500);

            // Password validation
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            const passwordError = document.getElementById('password_error');
            const form = document.querySelector('form');

            function validatePassword() {
                if (password.value !== confirmPassword.value && confirmPassword.value !== '') {
                    confirmPassword.classList.add('input-error');
                    passwordError.style.display = 'block';
                    return false;
                } else {
                    confirmPassword.classList.remove('input-error');
                    passwordError.style.display = 'none';
                    return true;
                }
            }

            // Real-time validation
            confirmPassword.addEventListener('input', validatePassword);
            password.addEventListener('input', validatePassword);

            // Form submission
            form.addEventListener('submit', function(e) {
                if (!validatePassword()) {
                    e.preventDefault();
                    // Animasi shake untuk memberi feedback visual
                    confirmPassword.classList.add('shake');
                    setTimeout(() => {
                        confirmPassword.classList.remove('shake');
                    }, 500);
                }
            });
        });
    </script>
</body>
</html>