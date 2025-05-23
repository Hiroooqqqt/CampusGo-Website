<?php
include 'connect.php';

$roomsSql = "SELECT * FROM rooms";
$roomsResult = $conn->query($roomsSql);

while ($row = $roomsResult->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td><span class='status-pill " . ($row['status'] === 'occupied' ? 'occupied' : 'available') . "'>";
    echo $row['status'] === 'occupied' ? 'Occupied' : 'Available';
    echo "</span></td>";
    echo "</tr>";
}
?>