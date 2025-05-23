<?php
session_start();
$role = $_SESSION['role'] ?? 'student';

// Connect to DB to fetch events for the sidebar
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'campusgodb';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

// Fetch upcoming events for sidebar (next 5 events)
$now = date('Y-m-d H:i:s');
$sql = "SELECT title, start, end FROM events WHERE end >= ? ORDER BY start ASC LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $now);
$stmt->execute();
$result = $stmt->get_result();

$sidebarEvents = [];
while ($row = $result->fetch_assoc()) {
    $sidebarEvents[] = $row;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Schedule Page</title>

  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: url('background/background_log_in.png') no-repeat center center fixed;
      background-color: rgb(228, 223, 208);
      background-size: cover;
      color: white;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .layout {
      display: flex;
      gap: 20px;
      max-width: 1200px;
      width: 100%;
      padding: 20px;
      box-sizing: border-box;
    }

    .calendar-section {
      flex: 1;
      max-width: 800px;
      display: flex;
      flex-direction: column;
    }

    .schedule-section {
      width: 300px;
      background-color: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.4);
      color: white;
      overflow-y: auto;
      max-height: 80vh;
    }

    #calendar {
      flex: 1;
      padding: 10px;
      background-color: rgba(255, 182, 193, 0.4);
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    .fc-theme-standard td,
    .fc-theme-standard th,
    .fc .fc-scrollgrid {
      background-color: rgba(255, 182, 193, 0.4);
    }

    /* Back button styling */
    .back-button {
      margin-bottom: 10px;
      padding: 8px 15px;
      border-radius: 5px;
      border: none;
      background-color: #ff69b4;
      color: white;
      cursor: pointer;
      width: fit-content;
      font-size: 16px;
    }

    .event-item {
      margin-bottom: 10px;
    }

    .event-title {
      font-weight: bold;
    }

    /* Modal styling */
    #eventModal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0,0,0,0.6);
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
    #eventModal form {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      color: #000;
      width: 300px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    #eventModal label {
      display: flex;
      flex-direction: column;
      font-weight: 600;
      font-size: 14px;
    }
    #eventModal input[type="text"],
    #eventModal input[type="datetime-local"] {
      padding: 6px;
      margin-top: 4px;
      font-size: 14px;
    }
    #eventModal button {
      padding: 8px 12px;
      font-size: 14px;
      cursor: pointer;
      border-radius: 5px;
      border: none;
    }
    #cancelBtn {
      background-color: #ccc;
      color: #000;
    }
    #eventModal button[type="submit"] {
      background-color: #ff69b4;
      color: white;
    }
    #eventModal div.buttons {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }
  </style>
</head>
<body data-role="<?= htmlspecialchars($role) ?>">
  <div class="layout">
    <div class="calendar-section">
      <button class="back-button" onclick="window.location.href='homepage.php'">
        ← Back to Homepage
      </button>
      <h1>Schedule Page</h1>
      <div id="calendar"></div>
    </div>

    <div class="schedule-section">
      <h2>Upcoming Events</h2>
      <ul>
        <?php if (empty($sidebarEvents)): ?>
          <li>No upcoming events</li>
        <?php else: ?>
          <?php foreach ($sidebarEvents as $event): ?>
            <?php
              $startTime = date('g:i A', strtotime($event['start']));
              $endTime = date('g:i A', strtotime($event['end']));
            ?>
            <li class="event-item">
              <span class="event-title"><?= htmlspecialchars($event['title']) ?></span>: <?= $startTime ?> - <?= $endTime ?>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>
  </div>

  <!-- Modal form for adding event -->
  <div id="eventModal">
    <form id="eventForm">
      <h3>Add New Event</h3>
      <label>
        Title:
        <input type="text" name="title" required />
      </label>
      <label>
        Start:
        <input type="datetime-local" name="start" required />
      </label>
      <label>
        End:
        <input type="datetime-local" name="end" required />
      </label>
      <div class="buttons">
        <button type="button" id="cancelBtn">Cancel</button>
        <button type="submit">Add Event</button>
      </div>
    </form>
  </div>

  <!-- FullCalendar JS -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const role = document.body.getAttribute('data-role');
      const calendarEl = document.getElementById('calendar');
      const modal = document.getElementById('eventModal');
      const form = document.getElementById('eventForm');
      const cancelBtn = document.getElementById('cancelBtn');

      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: 'fetch_sched_events.php',
        dateClick: function(info) {
          if (role !== 'teacher') return;

          // Show modal and prefill start/end datetime-local inputs with clicked date + default times
          modal.style.display = 'flex';

          const startInput = form.elements['start'];
          const endInput = form.elements['end'];

          // Format date for datetime-local input: YYYY-MM-DDTHH:mm (e.g. 2025-05-23T09:00)
          const dateStr = info.dateStr; // e.g. 2025-05-23
          const startDateTime = dateStr + 'T09:00'; // default start 9AM
          const endDateTime = dateStr + 'T10:00';   // default end 10AM

          startInput.value = startDateTime;
          endInput.value = endDateTime;

          form.elements['title'].value = '';
          form.elements['title'].focus();
        }
      });

      cancelBtn.onclick = () => {
        modal.style.display = 'none';
      };

      form.onsubmit = (e) => {
        e.preventDefault();

        const formData = {
          title: form.elements['title'].value.trim(),
          start: form.elements['start'].value,
          end: form.elements['end'].value
        };

        if (formData.end <= formData.start) {
          alert('End date/time must be after start date/time.');
          return;
        }

        fetch('add_events.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            calendar.refetchEvents();
            location.reload();
            modal.style.display = 'none';
          } else {
            alert('Failed to add event: ' + (data.message || 'Unknown error'));
          }
        })
        .catch(error => {
          console.error('Error adding event:', error);
          alert('Error adding event.');
        });
      };

      calendar.render();
    });
  </script>
</body>
</html>
