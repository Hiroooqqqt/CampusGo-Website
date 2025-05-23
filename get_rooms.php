<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: loginScreen.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $new_status = $_POST['status'];
    mysqli_query($conn, "UPDATE rooms SET status='$new_status' WHERE id=$room_id");
    echo "success";
    exit;
}

$rooms = mysqli_query($conn, "SELECT * FROM rooms");
$room_data = [];

while ($row = mysqli_fetch_assoc($rooms)) {
    $room_data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($room_data);
exit;
?>
