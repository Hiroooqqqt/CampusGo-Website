<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $column = $_POST['column'];
    $value = trim($_POST['value']);

    $allowed = ['name', 'is_number', 'email', 'role'];
    if (!in_array($column, $allowed)) {
        echo "Invalid column";
        exit();
    }

    $stmt = $conn->prepare("UPDATE users SET $column = ? WHERE id = ?");
    $stmt->bind_param("si", $value, $id);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error updating user";
    }

    $stmt->close();
}
?>
