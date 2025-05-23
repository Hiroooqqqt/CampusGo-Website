<?php
include 'connect.php';
session_start();

// Allow both teacher and admin to access
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['teacher', 'admin'])) {
    header("Location: loginScreen.php");
    exit();
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = intval($_POST['room_id']);
    $new_status = $_POST['status'] ?? null;
    $instructor = $_POST['instructor'] ?? null;
    $duration = $_POST['duration'] ?? null;

    $stmt = $conn->prepare("UPDATE rooms SET status = ?, instructor = ?, duration = ? WHERE id = ?");
    $stmt->bind_param("sssi", $new_status, $instructor, $duration, $room_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    exit();
}

// GET request - Fetch room data
$result = $conn->query("SELECT id, name, status, instructor, duration FROM rooms");

if ($result) {
    $rooms = [];
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
    echo json_encode($rooms);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}
?>
