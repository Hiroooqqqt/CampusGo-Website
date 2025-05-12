<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="CSS/qr_code.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>QR Code Design</title>
</head>
<body>
    <div class="card">
        <div class="profile">
            <img src="Icons/humanIcon.png" alt="Profile Picture">
            <div class="profile-text">
            <?php
                session_start();
                include 'connect.php';

                $user_id = $_SESSION['user_id'];
                $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
                $user = mysqli_fetch_assoc($result);
                ?>
                <p><?php echo $user['name']; ?></p>
                <p><?php echo $user['id_number']; ?></p>
            </div>
        </div>
        <div class="qr-code">
            <img src="Icons/Qr_Icon.png" alt="QR Code">
        </div>
    </div>
    <div class="back" onclick="history.back();"> <button class="back-button">Back</button></div>
</body>
</html>
