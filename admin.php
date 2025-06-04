<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id']) && $_SESSION['role'] !== 'admin') {
    header('Location: loginScreen.php');
    exit();
}

$email = $_SESSION['email'];
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

$usersSql = "SELECT * FROM users";
$usersResult = $conn->query($usersSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Welcome, Admin <?php echo htmlspecialchars($user['name'] ?? 'Admin'); ?>!</h1>
        <p>You have access to the admin panel.</p>

        <h2>Users List:</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>ID Number</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $usersResult->fetch_assoc()) { ?>
            <tr data-id="<?php echo $row['id']; ?>">
                <td><?php echo $row['id']; ?></td>
                <td contenteditable="true" onblur="updateUser(this, 'id_number')"><?php echo htmlspecialchars($row['id_number']); ?></td>
                <td contenteditable="true" onblur="updateUser(this, 'name')"><?php echo htmlspecialchars($row['name']); ?></td>
                <td contenteditable="true" onblur="updateUser(this, 'email')"><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                    <select onchange="updateUserSelect(this, 'role')">
                        <option value="admin" <?php if($row['role'] === 'admin') echo 'selected'; ?>>admin</option>
                        <option value="teacher" <?php if($row['role'] === 'teacher') echo 'selected'; ?>>teacher</option>
                        <option value="student" <?php if($row['role'] === 'student') echo 'selected'; ?>>student</option>
                    </select>
                </td>
                <td><a href="deleteUser.php?id=<?php echo $row['id']; ?>">Delete</a></td>
            </tr>
            <?php } ?>
        </table>

        <a href="logout.php">Logout</a>
        <br>
        <a href="homepage.php">Go to dashboard</a>
    </div>
</body>

<script>
function updateUser(cell, column) {
    const row = cell.parentElement;
    const id = row.getAttribute('data-id');
    const value = cell.innerText.trim();

    fetch('updateUser.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${id}&column=${column}&value=${encodeURIComponent(value)}`
    })
    .then(res => res.text())
    .then(data => {
        console.log('Update result:', data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function updateUserSelect(select, column) {
    const row = select.closest('tr');
    const id = row.getAttribute('data-id');
    const value = select.value;

    fetch('updateUser.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${id}&column=${column}&value=${encodeURIComponent(value)}`
    })
    .then(res => res.text())
    .then(data => {
        console.log('Update result:', data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
</html>
