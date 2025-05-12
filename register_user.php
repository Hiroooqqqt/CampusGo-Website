<?php
include 'connect.php';

$name = $_POST['name'] ?? '';
$id_number = $_POST['Identification'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
if (mysqli_num_rows($check) > 0) {
    echo "Email already exists";
    exit;
}

$query = "INSERT INTO users (name, id_number, email, password, role) VALUES ('$name', '$id_number', '$email', '$password', 'student')";

if (mysqli_query($conn, $query)) {
    echo "success";
} else {
    echo "error: " . mysqli_error($conn);
}
?>
