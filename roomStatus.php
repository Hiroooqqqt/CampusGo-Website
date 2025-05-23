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

if ($roomsResult === false) {
    die("Error fetching room data: " . $conn->error);
}
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

        .back-button, .refresh-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            margin-right: 10px;
        }

        .back-button:hover,
        .refresh-button:hover {
            background-color: #0056b3;
        }

        #loading-indicator {
            margin-top: 10px;
            text-align: center;
            color: #007bff;
            display: none;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function refreshTable() {
            $('#loading-indicator').show();
            $.ajax({
                url: 'refresh_room.php',
                type: 'GET',
                success: function(data) {
                    $('#room-table-body').html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error refreshing table:", error);
                    $('#room-table-body').html(
                        '<tr><td colspan="5" style="color: red;">Error loading data. Please try again later.</td></tr>'
                    );
                },
                complete: function() {
                    $('#loading-indicator').hide();
                }
            });
        }

        // Optional: uncomment this to auto-refresh every 5 seconds
        // setInterval(refreshTable, 5000);
    </script>
</head>

<body data-role="<?php echo $role; ?>">
    <div class="box">
        <h1 class="head">Room Status</h1>

        <table>
            <thead>
                <tr>
                    <th>Room ID</th>
                    <th>Room Name</th>
                    <th>Status</th>
                    <th>Instructor</th>
                    <th>Class Duration</th>
                </tr>
            </thead>
            <tbody id="room-table-body">
                <?php while ($row = $roomsResult->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td>
                        <span class="status-pill <?php echo strtolower($row['status']) === 'occupied' ? 'occupied' : 'available'; ?>">
                            <?php echo ucfirst($row['status']); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($row['instructor'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($row['duration'] ?? 'N/A'); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <div id="loading-indicator">Loading...</div>

        <button class="refresh-button" onclick="refreshTable()">Refresh</button>
        <button class="back-button" onclick="window.location.href='homepage.php'">Back</button>
    </div>
</body>
</html>
