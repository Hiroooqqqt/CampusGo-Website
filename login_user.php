<?php

session_start();
include 'connect.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT * FROM users WHERE (email = ? OR id_number = ?) AND password = ?");
$stmt->bind_param("sss", $email, $email, $password);
$stmt->execute();

$result = $stmt->get_result();
if ($user = $result->fetch_assoc()) {
    $_SESSION['email'] = $user['email']; 
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    echo $user['role'];  
} else {
    echo "Invalid credentials";
}
?>


