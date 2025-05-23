<?php
include 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomId = $_POST['roomId'];
    $userName = $_SESSION['name'];  // Ensure this is stored at login

    // Check if this user is the instructor
    $stmt = $conn->prepare("SELECT instructor FROM rooms WHERE id = ?");
    $stmt->bind_param("i", $roomId);
    $stmt->execute();
    $stmt->bind_result($instructor);
    $stmt->fetch();
    $stmt->close();

    if ($instructor === $userName) {
        // Allow update if user is instructor
        $update = $conn->prepare("UPDATE rooms SET status = 'available', instructor = '', duration = '' WHERE id = ?");
        $update->bind_param("i", $roomId);
        if ($update->execute()) {
            echo "success";
        } else {
            echo "error";
        }
        $update->close();
    } else {
        echo "unauthorized";
    }
}
?>
