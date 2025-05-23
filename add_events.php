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

if (!isset($data['title'], $data['start'], $data['end'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$title = $conn->real_escape_string($data['title']);
$start = $data['start'];
$end   = $data['end'];

// Convert ISO datetime (with 'T') to MySQL format "YYYY-MM-DD HH:MM:SS"
function convertToMySQLDateTime($datetimeStr) {
    if (strpos($datetimeStr, 'T') !== false) {
        $datetimeStr = str_replace('T', ' ', $datetimeStr);
        if (strlen($datetimeStr) == 16) { // e.g. "2025-05-23 09:00"
            $datetimeStr .= ':00';
        }
    }
    return $datetimeStr;
}

$start = convertToMySQLDateTime($start);
$end = convertToMySQLDateTime($end);

// Validate datetime format YYYY-MM-DD HH:MM:SS
$dateRegex = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';
if (!preg_match($dateRegex, $start) || !preg_match($dateRegex, $end)) {
    echo json_encode(['success' => false, 'message' => 'Invalid datetime format']);
    exit;
}

$start = $conn->real_escape_string($start);
$end = $conn->real_escape_string($end);

$sql = "INSERT INTO events (title, start, end) VALUES ('$title', '$start', '$end')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}

$conn->close();
