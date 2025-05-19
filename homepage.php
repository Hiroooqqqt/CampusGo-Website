<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Schedule Page</title>

  <!-- FullCalendar CSS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />

  <style>
    #calendar {
      max-width: 800px;
      margin: 40px auto;
      padding: 10px;
      border: 1px solid #ccc;
    }
  </style>
</head>
<body>
  <h1>Schedule Page</h1>
  <p>This is the schedule page.</p>

  <div>
    <h2>Schedule</h2>
    <ul>
      <li>Event 1: 10:00 AM - 11:00 AM</li>
      <li>Event 2: 11:30 AM - 12:30 PM</li>
      <li>Event 3: 1:00 PM - 2:00 PM</li>
    </ul>
  </div>

  <!-- Calendar Container -->
  <div id="calendar"></div>

  <!-- FullCalendar JS -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const calendarEl = document.getElementById('calendar');

      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: 'fetch-events.php',

        dateClick: function(info) {
          const title = prompt('Enter event title:');
          if (title) {
            const eventData = {
              title: title,
              start: info.dateStr,
              end: info.dateStr
            };

            // Send event to backend
            fetch('add-event.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify(eventData)
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                calendar.refetchEvents(); // Refresh calendar
              } else {
                alert('Failed to add event.');
              }
            });
          }
        }
      });

      calendar.render();
    });
  </script>
</body>
</html>
