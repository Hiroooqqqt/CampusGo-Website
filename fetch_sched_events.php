<?php
header('Content-Type: application/json');

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'campusgodb';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

$start = $_GET['start'] ?? null;
$end = $_GET['end'] ?? null;

if ($start && $end) {
    $sql = "SELECT id, title, start, end FROM events WHERE start >= ? AND end <= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $start, $end);
} else {
    $sql = "SELECT id, title, start, end FROM events";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'id'    => $row['id'],
        'title' => $row['title'],
        'start' => $row['start'],
        'end'   => $row['end']
    ];
}

echo json_encode($events);

$stmt->close();
$conn->close();
