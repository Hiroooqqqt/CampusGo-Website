<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $column = $_POST['column'];
    $value = $_POST['value'];

    $stmt = $conn->prepare("UPDATE users SET $column = ? WHERE id_number = ?");
    $stmt->bind_param("si", $value, $id); // Assuming id_number is an integer, adjust as necessary
    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>