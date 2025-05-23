<?php
include 'connect.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receive inputs
    $id = isset($_POST['room_id']) ? (int) $_POST['room_id'] : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $instructor = isset($_POST['instructor']) ? $_POST['instructor'] : '';
    $duration = isset($_POST['duration']) ? $_POST['duration'] : '';

    // Validate inputs
    if ($id <= 0) {
        echo "Invalid room ID.";
        exit;
    }
    if (empty($status)) {
        echo "Status is required.";
        exit;
    }
    if (empty($instructor)) {
        echo "Instructor is required.";
        exit;
    }
    if (empty($duration)) {
        echo "Duration is required.";
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE rooms SET status = ?, instructor = ?, duration = ? WHERE id = ?");
        if (!$stmt) {
            echo "Prepare failed: " . $conn->error;
            exit;
        }

        // Bind parameters: status, instructor, duration (strings), id (int)
        $stmt->bind_param("sssi", $status, $instructor, $duration, $id);

        if (!$stmt->execute()) {
            echo "Execute failed: " . $stmt->error;
            exit;
        }

        if ($stmt->affected_rows === 0) {
            echo "No rows updated. Check if room ID exists.";
            exit;
        }

        echo 'success';

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
