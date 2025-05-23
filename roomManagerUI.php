<?php
include 'connect.php';
session_start();
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'Unknown';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Manager - CampusGo</title>
    <style>
        body {
     font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    background-image: url('background/background_home.png');
    background-size: cover;
    background-attachment: fixed;
}

.sidebar {
    width: 300px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    background: rgba(30, 30, 30, 0.95);
    color: #fff;
    padding: 25px;
    box-sizing: border-box;
    box-shadow: 4px 0 15px rgba(0,0,0,0.2);
    overflow-y: auto;
}

.sidebar h3 {
    margin-top: 0;
    font-size: 1.5em;
    border-bottom: 2px solid #555;
    padding-bottom: 5px;
}

.sidebar p, .sidebar label {
    margin: 10px 0 5px;
    font-size: 1em;
}

.sidebar input {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    margin-bottom: 10px;
    font-size: 1em;
}

.sidebar button {
    width: 100%;
    margin-top: 10px;
    padding: 12px;
    border-radius: 8px;
    border: none;
    font-size: 1em;
    font-weight: bold;
    background-color: #28a745;
    color: white;
    transition: background-color 0.3s;
}

.sidebar button:hover {
    background-color: #218838;
}

.back-button {
    background-color: #007bff;
    margin-top: 10px;
}

.back-button:hover {
    background-color: #0056b3;
}

.container {
     margin-left: 300px;
    padding: 40px;
    overflow-y: auto;
    height: 100vh;
}

h1 {
    text-align: center;
    color: #fff;
    margin-bottom: 30px;
}

ul.room-list {
    list-style: none;
    padding: 0;
    margin: 0 auto;
    max-width: 800px;
}

li.room-item {
    padding: 20px;
    margin-bottom: 15px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: all 0.3s ease;
}

li.room-item:hover {
    background-color: #f5f5f5;
    transform: translateY(-2px);
}

.room-name {
    font-weight: bold;
    font-size: 1.2em;
    margin-bottom: 5px;
}

.room-meta div {
    margin-top: 4px;
    font-size: 0.95em;
    color: #555;
}

.status-label {
    font-weight: bold;
}

.status-available {
    color: #28a745;
}

.status-occupied {
    color: #dc3545;
}

.locked {
    background-color: #f8d7da;
    cursor: not-allowed;
}

    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Welcome</h3>
        <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
        <p><strong>Role:</strong> <?= htmlspecialchars($role) ?></p>

        <label>Room:</label>
        <input type="text" id="roomNameInput" readonly>
        <label>Duration:</label>
        <input type="text" id="durationInput" placeholder="e.g. 2 hours">
        <label>Instructor:</label>
        <input type="text" id="instructorInput" value="<?= htmlspecialchars($name) ?>">
        <input type="hidden" id="roomIdInput">

        <button id="saveButton">Save to Selected Room</button>
        <button class="back-button" onclick="makeRoomAvailable()">Set Available</button>
        <button class="back-button" onclick="window.location.href='homepage.php'">Back</button>
    </div>

    <div class="container">
        <h1>Manage Room Status</h1>
        <ul class="room-list" id="room-list"></ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let selectedRoomId = null;

        document.addEventListener("DOMContentLoaded", function () {
            fetch('get_rooms.php')
                .then(res => res.json())
                .then(rooms => {
                    const roomList = document.getElementById('room-list');
                    rooms.forEach(room => {
                        const li = document.createElement('li');
                        li.className = 'room-item';
                        li.dataset.roomId = room.id;
                        li.dataset.roomName = room.name;
                        li.dataset.status = room.status;
                        li.dataset.instructor = room.instructor;
                        li.dataset.duration = room.duration;

                        const nameSpan = document.createElement('div');
                        nameSpan.className = 'room-name';
                        nameSpan.textContent = room.name;

                        const metaDiv = document.createElement('div');
                        metaDiv.className = 'room-meta';
                        metaDiv.innerHTML = `
                            <div><strong>Status:</strong> <span class="${room.status.toLowerCase() === 'occupied' ? 'status-occupied' : 'status-available'}">${room.status}</span></div>
                            <div><strong>Instructor in use:</strong> ${room.instructor || '—'}</div>
                            <div><strong>Duration:</strong> ${room.duration || '—'}</div>
                        `;

                        li.appendChild(nameSpan);
                        li.appendChild(metaDiv);

                        li.addEventListener('click', () => {
                            if (room.status.toLowerCase() === 'occupied') {
                                alert('Room is currently occupied.');
                            }

                            selectedRoomId = room.id;
                            document.getElementById('roomNameInput').value = room.name;
                            document.getElementById('roomIdInput').value = room.id;
                            document.getElementById('durationInput').value = room.duration || '';
                            document.getElementById('instructorInput').value = room.instructor || '<?= htmlspecialchars($name) ?>';
                        });

                        if (room.status.toLowerCase() === 'occupied') {
                            li.classList.add('locked');
                        }

                        roomList.appendChild(li);
                    });
                });
        });

        document.getElementById('saveButton').addEventListener('click', () => {
            const roomId = document.getElementById('roomIdInput').value;
            const duration = document.getElementById('durationInput').value.trim();
            const instructor = document.getElementById('instructorInput').value.trim();

            if (!roomId) {
                alert("Select a room first.");
                return;
            }

            if (!duration) {
                alert("Please enter a duration.");
                return;
            }

            fetch('update_room.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `room_id=${roomId}&status=Occupied&instructor=${encodeURIComponent(instructor)}&duration=${encodeURIComponent(duration)}`
            })
            .then(res => res.text())
            .then(response => {
                if (response.trim() === 'success') {
                    alert("Room updated!");
                    window.location.reload();
                } else {
                    alert("Update failed: " + response);
                }
            });
        });

        function makeRoomAvailable() {
            const roomId = document.getElementById('roomIdInput').value;

            if (!roomId) {
                alert("Select a room first.");
                return;
            }

            $.ajax({
                url: 'update_status.php',
                type: 'POST',
                data: { roomId },
                success: function(response) {
                    if (response.trim() === 'success') {
                        alert("Room set to available.");
                        location.reload();
                    } else if (response.trim() === 'unauthorized') {
                        alert("Unauthorized to clear this room.");
                    } else {
                        alert("Failed to update status.");
                    }
                }
            });
        }
    </script>
</body>
</html>
