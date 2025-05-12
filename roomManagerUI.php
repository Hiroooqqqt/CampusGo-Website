<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Manager - CampusGo</title>
   <style>
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
        background-color: #28a745; /* Available = green */
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
        background-color: #dc3545; /* Occupied = red */
    }

    input:checked + .slider:before {
        transform: translateX(26px);
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

  
    .slider.occupied {
        background-color: #dc3545 !important; 
    }

    .slider.available {
        background-color: #28a745 !important;
    }
</style>

</head>
<body>
<div class="container">
    <h1>Manage Room Status</h1>
    <ul class="room-list" id="room-list">
    </ul>
    <button class="back-button" onclick="window.location.href='homepage.php'">Back</button>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const roomList = document.getElementById('room-list');

    fetch('get_rooms.php') 
        .then(response => response.json()) 
        .then(rooms => {
            rooms.forEach(room => {
                const li = document.createElement('li');
                li.className = 'room-item';

                const roomName = document.createElement('span');
                roomName.className = 'room-name';
                roomName.textContent = room.name;

                const wrapper = document.createElement('div');
                wrapper.className = 'toggle-wrapper';

                const statusLabel = document.createElement('span');
                statusLabel.className = 'status-label';
                statusLabel.textContent = room.status;

                const switchLabel = document.createElement('label');
                switchLabel.className = 'switch';

                const toggleInput = document.createElement('input');
                toggleInput.type = 'checkbox';

                
                if (room.status === 'Occupied') {
                    toggleInput.checked = true; 
                } else {
                    toggleInput.checked = false; 
                }

                const slider = document.createElement('span');
                slider.className = 'slider';

           
                if (room.status === 'Occupied') {
                    slider.classList.add('Occupied');
                } else {
                    slider.classList.add('available');
                }

                toggleInput.addEventListener('change', () => {
                    const newStatus = toggleInput.checked ? 'Occupied' : 'Available';

                    fetch('get_rooms.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `room_id=${room.id}&status=${newStatus}`
                    })
                        .then(res => res.text())
                        .then(result => {
                            if (result.trim() === 'success') {
                                statusLabel.textContent = newStatus; 

                                if (newStatus === 'Occupied') {
                                    slider.classList.remove('available');
                                    slider.classList.add('Occupied');
                                } else {
                                    slider.classList.remove('Occupied');
                                    slider.classList.add('available');
                                }
                            } else {
                                alert('Error updating room status');
                                toggleInput.checked = !toggleInput.checked; 
                            }
                        });
                });

               
                switchLabel.appendChild(toggleInput);
                switchLabel.appendChild(slider);
                wrapper.appendChild(statusLabel);
                wrapper.appendChild(switchLabel);

                li.appendChild(roomName);
                li.appendChild(wrapper);
                roomList.appendChild(li);
            });
        });
});


</script>
</body>
</html>
