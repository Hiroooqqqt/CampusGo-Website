<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Manager - CampusGo</title>
    <style>
        .class-info {
            font-size: 0.9em;
            color: #555;
            margin-top: 5px;
            line-height: 1.4em;
        }

        .class-duration,
        .class-instructor {
            display: block;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-image: url('background/background_home.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-color: #f4f7fa;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 2em;
            margin-bottom: 20px;
        }

        ul.room-list {
            list-style: none;
            padding: 0;
        }

        li.room-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #ccc;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        li.room-item:hover {
            background-color: #f1f1f1;
        }

        .room-name {
            font-weight: bold;
            font-size: 1.1em;
            color: #333;
        }

        .toggle-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0;
            right: 0; bottom: 0;
            background-color: #28a745;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px; width: 26px;
            left: 4px; bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #dc3545;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .slider.occupied {
            background-color: #dc3545 !important;
        }

        .slider.available {
            background-color: #28a745 !important;
        }

        .status-label {
            font-weight: bold;
            color: #555;
            font-size: 1.1em;
        }

        .back-button {
            margin-top: 30px;
            display: block;
            padding: 12px 24px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        .duration-input {
            padding: 3px 6px;
            font-size: 0.9em;
            margin-top: 4px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body data-role="<?php echo $_SESSION['role']; ?>">
<div class="container">
    <h1>Manage Room Status</h1>
    <ul class="room-list" id="room-list"></ul>
    <button class="back-button" onclick="window.location.href='homepage.php'">Back</button>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const roomList = document.getElementById('room-list');
        const role = document.body.getAttribute('data-role');

        fetch('get_rooms.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(rooms => {
                rooms.forEach(room => {
                    const roomItem = createRoomItem(room, role);
                    roomList.appendChild(roomItem);
                });
            })
            .catch(error => {
                console.error("Error fetching rooms:", error);
                roomList.innerHTML = '<li style="color: red;">Error loading rooms. Please try again later.</li>';
            });
    });

    function createRoomItem(room, role) {
        const li = document.createElement('li');
        li.className = 'room-item';

        const leftSide = document.createElement('div');

        const roomName = document.createElement('span');
        roomName.className = 'room-name';
        roomName.textContent = room.name;

        const classInfo = document.createElement('div');
        classInfo.className = 'class-info';

        const instructorSpan = document.createElement('span');
        instructorSpan.className = 'class-instructor';
        instructorSpan.textContent = `Instructor: ${room.instructor || 'N/A'}`;

        const durationWrapper = document.createElement('span');
        durationWrapper.className = 'class-duration';

        if (role === 'teacher' || role === 'admin') {
            const input = document.createElement('input');
            input.type = 'text';
            input.value = room.duration || '';
            input.className = 'duration-input';
            input.addEventListener('blur', () => {
                room.duration = input.value;
                updateRoom(room);
            });
            durationWrapper.textContent = 'Duration: ';
            durationWrapper.appendChild(input);
        } else {
            durationWrapper.textContent = `Duration: ${room.duration || 'N/A'}`;
        }

        classInfo.appendChild(instructorSpan);
        classInfo.appendChild(durationWrapper);

        leftSide.appendChild(roomName);
        leftSide.appendChild(classInfo);

        const toggle = createToggleWrapper(room, role);

        li.appendChild(leftSide);
        li.appendChild(toggle);

        return li;
    }

    function createToggleWrapper(room, role) {
        const wrapper = document.createElement('div');
        wrapper.className = 'toggle-wrapper';

        const statusLabel = document.createElement('span');
        statusLabel.className = 'status-label';
        statusLabel.textContent = room.status;

        const switchLabel = document.createElement('label');
        switchLabel.className = 'switch';

        const toggleInput = document.createElement('input');
        toggleInput.type = 'checkbox';
        toggleInput.checked = room.status === 'Occupied';

        const slider = document.createElement('span');
        slider.className = 'slider';
        slider.classList.add(room.status === 'Occupied' ? 'occupied' : 'available');

        toggleInput.addEventListener('change', () => {
            const newStatus = toggleInput.checked ? 'Occupied' : 'Available';
            if ((role === 'teacher' || role === 'admin') && newStatus === 'Available') {
                room.instructor = prompt('Enter your name as the instructor:', room.instructor || '') || room.instructor;
            }
            room.status = newStatus;
            updateRoom(room, toggleInput, slider, statusLabel);
        });

        switchLabel.appendChild(toggleInput);
        switchLabel.appendChild(slider);
        wrapper.appendChild(statusLabel);
        wrapper.appendChild(switchLabel);

        return wrapper;
    }

    function updateRoom(room, toggleInput = null, slider = null, statusLabel = null) {
        fetch('get_rooms.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `room_id=${room.id}&status=${room.status}&instructor=${encodeURIComponent(room.instructor || '')}&duration=${encodeURIComponent(room.duration || '')}`
        })
            .then(res => res.json())
            .then(result => {
                if (result.status === 'success') {
                    if (statusLabel) statusLabel.textContent = room.status;
                    if (slider) {
                        slider.className = 'slider';
                        slider.classList.add(room.status === 'Occupied' ? 'occupied' : 'available');
                    }
                } else {
                    alert(`Error updating room: ${result.message}`);
                    if (toggleInput) toggleInput.checked = !toggleInput.checked;
                }
            })
            .catch(() => {
                alert('Network error. Please try again.');
                if (toggleInput) toggleInput.checked = !toggleInput.checked;
            });
    }
</script>
</body>
</html>
