<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
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
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 350px;
            display: none;
            transform: scale(0.8) translateY(-50px);
            opacity: 0;
            animation: float 3s infinite alternate ease-in-out, fadeIn 1s forwards 1.5s;
        }
        @keyframes fadeIn {
            to {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }
        @keyframes float {
            0% { transform: translateY(0); }
            100% { transform: translateY(10px); }
        }
        h2 {
            font-size: 28px;
            font-weight: bold;
            color: #ff3b5c;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        .input-group {
            display: flex;
            align-items: center;
            background: #f1f1f1;
            padding: 10px;
            margin: 10px 0;
            border-radius: 10px;
            transition: 0.3s;
            box-shadow: inset 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
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
            color: #333;
        }
        .input-group input::placeholder {
            color: #aaa;
            font-style: italic;
        }
        .show-password {
            margin-top: 10px;
            display: flex;
            align-items: center;
            cursor: pointer;
            position: relative;
            color: #ff3b5c;
            font-weight: bold;
        }
        .show-password input {
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 5px;
            background: linear-gradient(135deg, #ff5733, #ff7e5f);
            position: relative;
            cursor: pointer;
            margin-right: 10px;
            transition: 0.3s;
        }
        .show-password input:checked::before {
            content: '\2713';
            font-size: 16px;
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .login-btn {
            background: linear-gradient(45deg, #ff3b5c, #ff6a88);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            font-weight: bold;
            letter-spacing: 1px;
        }
        .login-btn:hover {
            background: linear-gradient(45deg, #ff6a88, #ff9a8b);
            transform: translateY(-3px) scale(1.05);
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
    <div class="login-container" id="login-container">
        <h2>Login</h2>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Username">
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" id="password" placeholder="Password">
        </div>
        <label class="show-password"><input type="checkbox" id="showPassword"> Show Password</label>
        <button class="login-btn">Login</button>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(() => {
                document.getElementById("loading-screen").classList.add("hidden");
                document.getElementById("login-container").style.display = "block";
            }, 1500);
        });
        document.getElementById("showPassword").addEventListener("change", function() {
            let passwordField = document.getElementById("password");
            passwordField.type = this.checked ? "text" : "password";
        });
    </script>
</body>
</html>
