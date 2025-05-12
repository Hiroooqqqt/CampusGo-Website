<?php
session_start();
include 'connect.php';

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin.php');
        exit();
    } elseif ($_SESSION['role'] === 'teacher') {
        header('Location: roomManagerUI.php');
        exit();
    } elseif ($_SESSION['role'] === 'student') {
        header('Location: roomStatus.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusGo</title>
    <link rel="stylesheet" href="CSS/loginScreen.css">
    <script>
        function loginUser(e) {
            e.preventDefault();

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const remember = document.getElementById('remember').checked;

            if (!email || !password) {
                alert('Please fill in both email and password.');
                return;
            }

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "login_user.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = xhr.responseText.trim();
                    if (response === "student") {
                        window.location.href = "homepage.php"; 
                    } else if (response === "teacher") {
                        window.location.href = "homepage.php"; 
                    } else if (response === "admin") {
                        window.location.href = "admin.php"; 
                    } else {
                        alert("Login failed: " + response); 
                    }
                } else {
                    alert("Server error: " + xhr.status); 
                }
            };

            xhr.send(`email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}&remember=${remember}`);
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="background/Logo_with_name.png" alt="CampusGo Logo">
        </div>
    </div>

    <div class="info-container">
        <div class="form-box">
            <form onsubmit="loginUser(event)">
                <input type="text" id="email" placeholder="ID number or Email" required><br>
                <input type="password" id="password" placeholder="Password" required><br>
                
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember Me</label>
                </div>
                
                <br>
                
                <button class="btn-login">Log In</button>
                
                <br><br><br>
                
                <div class="link">
                    No account? <a class="SignUp" href="regUser.php" style="cursor: pointer;"> Click here </a> to sign up.
                </div>
            </form>
        </div>
    </div>
</body>
</html>
