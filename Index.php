<!DOCTYPE html>
<html lang="en">
<head>
    <title>CampusGo</title>
    <link rel="stylesheet" href="CSS/startingPage.css">
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelector(".btn-login").addEventListener("click", () => {
                window.location.href = "loginScreen.php";
            });

            document.querySelector(".btn-signup").addEventListener("click", () => {
                window.location.href = "regUser.php";
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="background/Logo_with_name.png" alt="logoimg">
        </div>
    </div>
    <div class="button-container">
        <button class="btn-login">Log In</button>
        <button class="btn-signup">Sign Up</button>
    </div>
</body>
</html>
