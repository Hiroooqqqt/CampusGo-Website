<?php
session_start();
include 'connect.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['image']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $image = $data['image'];

    $stmt = $conn->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
    $stmt->bind_param("si", $image, $user_id);

    if ($stmt->execute()) {
        echo "Profile picture updated successfully!";
    } else {
        echo "Error updating image.";
    }
} else {
    echo "No image or user session found.";
}
?>
