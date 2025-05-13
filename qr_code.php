<?php
session_start();
include 'connect.php';

$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($result);
?>

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
            <img 
                src="data:image/png;base64,<?php echo $user['profile_image'] ?: base64_encode(file_get_contents('Icons/humanIcon.png')); ?>" 
                alt="Profile Picture" 
                width="150"
            >

            <form id="uploadForm" enctype="multipart/form-data">
                <input type="file" name="profile_picture" id="profile_picture" accept="image/*" required>
                <button type="submit">Upload Picture</button>
            </form>

            <div class="profile-text">
                <p><?php echo $user['name']; ?></p>
                <p><?php echo $user['id_number']; ?></p>
               <form id="updateForm">
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                <input type="text" id="password" name="password" value="<?php echo $user['password']; ?>" required>
                <button type="submit">Save Changes</button>
            </form>

            </div>
        </div>

    </div>

    <div class="back"><button class="back-button" onclick="history.back();">Back</button></div>

    <script>
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const fileInput = document.getElementById('profile_picture');
        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.onload = function() {
            const base64Image = reader.result.split(',')[1];

            fetch('upload_image.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ image: base64Image })
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
        };

        reader.readAsDataURL(file);
    });
    document.getElementById('updateForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    fetch('update_profile.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email, password })
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        location.reload();
    });
});
    </script>
</body>
</html>
