<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: loginScreen.php");
    exit();
}

$role = $_SESSION['role'];
$roomsSql = "SELECT * FROM rooms";
$roomsResult = $conn->query($roomsSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Status</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/rooms.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            color: #fff;
            margin-top: 20px;
        }

        th, td {
            padding: 14px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: rgba(255, 255, 255, 0.2);
            font-size: 1.2rem;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .status-pill {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            color: white;
            display: inline-block;
        }

        .available {
            background-color: #28a745;
        }

        .occupied {
            background-color: #dc3545;
        }

        .input-container {
            margin-bottom: 20px;
        }

        .input-container label {
            color: white;
            font-weight: bold;
        }

        .input-container input {
            padding: 10px;
            width: 200px;
            border-radius: 5px;
            border: none;
            margin-top: 5px;
        }

        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function refreshTable() {
            $.ajax({
                url: 'refresh_room.php',
                type: 'GET',
                success: function(data) {
                    $('#room-table-body').html(data);
                }
            });
        }

        setInterval(refreshTable, 1000);
    </script>
</head>

<body data-role="<?php echo $role; ?>">
    <div class="box">
        <h1 class="head">Room Status</h1>

        <div class="input-container">
            <label for="roomIdInput">Enter Room ID:</label><br>
            <input type="number" id="roomIdInput" placeholder="Room ID">
        </div>

        <table>
            <thead>
                <tr>
                    <th>Room ID</th>
                    <th>Room Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="room-table-body">
                <?php while ($row = $roomsResult->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td>
                        <span class="status-pill <?php echo $row['status'] === 'occupied' ? 'occupied' : 'available'; ?>">
                            <?php echo $row['status'] === 'occupied' ? 'Occupied' : 'Available'; ?>
                        </span>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <button class="back-button" onclick="window.location.href='homepage.php'">Back</button>
    </div>
</body>
</html>
