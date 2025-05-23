<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Schedule Page</title>

  <!-- FullCalendar CSS -->
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
  justify-content: center; 
  align-items: stretch;       
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
    margin-left: 20px;
    background-color: rgba(255, 255, 255, 0.1);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.4);
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    height: calendar-section;
  }

.schedule-section h2, 
.schedule-section ul {
  color: white;
  text-align: left;
}

#calendar {
  flex: 1;
  width: 100%;
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
</style>
</head>
<body>
  <div class="layout">
    <div class="calendar-section">
      <h1>Schedule Page</h1>
      <div id="calendar"></div>
    </div>

    <div class="schedule-section">
      <h2>Schedule</h2>
      <ul>
        <li>Event 1: 10:00 AM - 11:00 AM</li>
        <li>Event 2: 11:30 AM - 12:30 PM</li>
        <li>Event 3: 1:00 PM - 2:00 PM</li>
      </ul>
    </div>
  </div>

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

            fetch('add-event.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify(eventData)
            })
            .then(response => {
              if (!response.ok) throw new Error('Network response was not ok');
              return response.json();
            })
            .then(data => {
              if (data.success) {
                calendar.refetchEvents();
              } else {
                alert('Failed to add event.');
              }
            })
            .catch(error => {
              console.error('Fetch error:', error);
              alert('Error adding event.');
            });
          }
        }
      });

      calendar.render();
    });
  </script>
</body>
</html>
