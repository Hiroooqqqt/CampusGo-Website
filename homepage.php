<?php
session_start();
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : 'student';
$userName = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Screen</title>
    <link rel="stylesheet" href="CSS/homepage.css">
</head>
<body>
    <div class="logo-section">
        <img src="background/Logo.png" alt="Logo" class="logo">
    </div>

    <div class="container">
        <div class="greeting">
    <h1>Hello, <?php echo htmlspecialchars($userRole); ?></h1>
    <h3><?php echo htmlspecialchars($userName); ?></h3>
    <p id="date-time"></p>
</div>

    </div>

    <div class="icons-section">
        <div class="icon navv" onclick="window.location.href='Map.php'"><img src="Icons/help.png" alt="Navigation Icon"></div>
        <div class="icon qrr" onclick="window.location.href='qr_code.php'"><img src="Icons/profile_pic.png" alt="QR Code Icon"></div>

        <?php if ($userRole == 'teacher'): ?>
            <div class="icon sri" onclick="window.location.href='roomManagerUI.php'"><img src="Icons/searchRoomIcon.png" alt="Search Icon"></div>
        <?php else: ?>
            <div class="icon sri" onclick="window.location.href='roomStatus.php'"><img src="Icons/searchRoomIcon.png" alt="Search Icon"></div>
        <?php endif; ?>
    </div>

    <div class="hamburger-menu">
        <div class="hamburger" onclick="toggleMenu()">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <div class="menu" id="menu">
          <a href="calendar.php" class="calendar">Calendar</a><br>
            <a href="logout.php" class="logout">Log out</a><br>
            
        </div>
    </div>

    <script>
        function updateDateTime() {
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric', weekday: 'long', hour: '2-digit', minute: '2-digit', hour12: true };
            const dateTimeString = now.toLocaleString('en-US', options);
            document.getElementById('date-time').innerText = dateTimeString;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime(); 

        function toggleMenu() {
            var menu = document.getElementById('menu');
            menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
        }
    </script>
</body>
</html>
