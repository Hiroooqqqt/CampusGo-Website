<?php
session_start();
include 'connect.php';

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $_SESSION['user_id'];
$email = $data['email'];
$password = $data['password'];

$query = "UPDATE users SET email = '$email', password = '$password' WHERE id = $user_id";

if (mysqli_query($conn, $query)) {
    echo "Profile updated successfully.";
} else {
    echo "Error updating profile: " . mysqli_error($conn);
}
?>
