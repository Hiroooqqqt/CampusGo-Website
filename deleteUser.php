<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmDelete'])) {
    $userId = $_POST['userId'];
    $deleteSql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Delete User</title>
    <style>
        body {
            background-image: url(Assets/admin.jpg);
            background-size: cover;
            font-family: Poppins, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .delete-container {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0,0,0,0.2);
            text-align: center;
            width: 80%;
            max-width: 500px;
        }
        h1 {
            color: #c0392b;
        }
        p {
            font-size: 18px;
            margin: 20px 0;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }
        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }
        .btn-cancel {
            background-color: #bdc3c7;
            color: #2c3e50;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #3498db;
        }
    </style>
</head>
<body>
    <div class="delete-container">
        <h1>Confirm Deletion</h1>
        <p>Are you sure you want to delete user: <strong><?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></strong>?</p>
        <form method="POST">
            <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
            <button type="submit" name="confirmDelete" class="btn-delete">Yes, Delete</button>
            <a href="admin.php"><button type="button" class="btn-cancel">Cancel</button></a>
        </form>
    </div>
</body>
</html>
