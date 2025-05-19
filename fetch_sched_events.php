<?php
// pang debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// konek ba, konek
$host = 'localhost';
$user = 'root';      
$pass = '';      
$dbname = 'campusgodb';    

// Connect den
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

// filter nganii
$start = isset($_GET['start']) ? $_GET['start'] : null;
$end = isset($_GET['end']) ? $_GET['end'] : null;

$sql = "SELECT id, title, start, end FROM events";
if ($start && $end) {
    $sql .= " WHERE (start >= ? AND end <= ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $start, $end);
} else {
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


header('Content-Type: application/json');
echo json_encode($events);

$stmt->close();
$conn->close();
