document.addEventListener('DOMContentLoaded', function () {
    const role = document.body.dataset.role;
    const list = document.getElementById('room-list');

    fetch('rooms.php')
        .then(res => res.json())
        .then(rooms => {
            list.innerHTML = `
                <li class="heading">
                    Ground Floor
                    <div class="status-indicators">
                        <div class="status">
                            <input type="checkbox" class="fixed-toggle" disabled>
                            <span>Free Room</span>
                        </div>
                        <div class="status">
                            <input type="checkbox" class="fixed-toggle" checked disabled>
                            <span>In Use</span>
                        </div>
                    </div>
                </li>
            `;

            rooms.forEach(room => {
                const isChecked = room.status === 'occupied' ? 'checked' : '';
                const disabled = role !== 'teacher' ? 'disabled' : '';
                const li = document.createElement('li');
                li.innerHTML = `
                    <span>${room.name}</span>
                    <input type="checkbox" class="toggle-switch" data-id="${room.id}" ${isChecked} ${disabled}>
                `;
                list.appendChild(li);
            });

            if (role === 'teacher') {
                document.querySelectorAll('.toggle-switch').forEach(toggle => {
                    toggle.addEventListener('change', function () {
                        const roomId = this.dataset.id;
                        const newStatus = this.checked ? 'occupied' : 'available';

                        fetch('rooms.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `room_id=${roomId}&status=${newStatus}`
                        })
                        .then(res => res.text())
                        .then(response => {
                            if (response !== 'success') {
                                alert('Failed to update status');
                            }
                        });
                    });
                });
            }
        });
});
