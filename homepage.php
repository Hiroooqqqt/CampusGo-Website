<?php
session_start();
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : 'student';
$userName = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome Screen</title>
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />

  <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background: url(background/background_home.png) no-repeat center center;
        background-size: cover;
        height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        position: relative;
        color: white;
    }

    .logo-section {
        position: absolute;
        margin-left: 30px;
        margin-top: 25px;
    }

    .logo {
        width: 300px;
    }

    .container {
        width: 80%;
        max-width: 900px;
        border-radius: 20px;
        padding: 20px;
        color: white;
        margin-top: 300px;
        margin-left: 100px;
    }

    .greeting h1 {
        font-size: 100px;
        font-weight: bold;
    }

    .greeting h3 {
        font-size: 36px;
    }

    .greeting p {
        margin-left: 50px;
        font-size: 23px;
    }

    .icons-section {
        display: flex;
        justify-content: space-between;
        position: absolute;
        right: 20px;
        margin-top: 250px;
    }

    .icon {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: white;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        margin: 20px;
        transition: transform 0.3s ease;
    }

    .icon img {
        width: 100px;
        height: 100px;
    }

    .navv:hover, .qrr:hover, .sri:hover {
        transform: scale(1.3);
    }

    .hamburger-menu {
        position: absolute;
        top: 20px;
        right: 20px;
    }

    .hamburger {
        width: 35px;
        height: 30px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        cursor: pointer;
    }

    .hamburger .line {
        width: 100%;
        height: 5px;
        background-color: white;
        border-radius: 5px;
    }

    .menu {
        display: none;
        position: absolute;
        top: 50px;
        right: 0;
        background-color: white;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 130px;
    }

    .menu a {
        display: block;
        padding: 10px 20px;
        color: black;
        text-decoration: none;
        border-bottom: 1px solid #eee;
    }

    .menu a:last-child {
        border-bottom: none;
    }

    .menu a:hover {
        background-color: #f5f5f5;
    }
  </style>
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
      <div class="icon navv" onclick="window.location.href='Map.php'">
          <img src="Icons/help.png" alt="Navigation Icon">
      </div>
      <div class="icon qrr" onclick="window.location.href='qr_code.php'">
          <img src="Icons/profile_pic.png" alt="QR Code Icon">
      </div>
      <?php if ($userRole == 'teacher' || $userRole == 'admin'): ?>
          <div class="icon sri" onclick="window.location.href='roomManagerUI.php'">
              <img src="Icons/searchRoomIcon.png" alt="Search Icon">
          </div>
      <?php else: ?>
          <div class="icon sri" onclick="window.location.href='roomStatus.php'">
              <img src="Icons/searchRoomIcon.png" alt="Search Icon">
          </div>
      <?php endif; ?>
  </div>

  <div class="hamburger-menu">
      <div class="hamburger" onclick="toggleMenu()">
          <div class="line"></div>
          <div class="line"></div>
          <div class="line"></div>
      </div>
      <div class="menu" id="menu">
          <a href="calendar.php">Calendar</a>
          <a href="logout.php" class="logout">Log out</a>
      </div>
  </div>

  <script>
    function updateDateTime() {
        const now = new Date();
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            weekday: 'long',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        };
        const dateTimeString = now.toLocaleString('en-US', options);
        document.getElementById('date-time').innerText = dateTimeString;
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();

    function toggleMenu() {
        var menu = document.getElementById('menu');
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }
  </script>
</body>
</html>
