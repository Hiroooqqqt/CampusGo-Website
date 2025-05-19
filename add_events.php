<?php
header('Content-Type: application/json');


$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'campusgodb';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB connection failed']);
    exit;
}


$data = json_decode(file_get_contents('php://input'), true);

$title = $conn->real_escape_string($data['title']);
$start = $conn->real_escape_string($data['start']);
$end   = $conn->real_escape_string($data['end']);

// Insert ba sa db
$sql = "INSERT INTO events (title, start, end) VALUES ('$title', '$start', '$end')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}

$conn->close();
?>
