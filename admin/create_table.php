<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Simple Calendar</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }
    .calendar {
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
      border-collapse: collapse;
    }
    .calendar th {
      padding: 10px;
      background-color: #f5f5f5;
      text-align: left;
    }
    .calendar td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
    }
    .event {
      margin-bottom: 5px;
      padding-left: 10px;
    }
    .event-title {
      font-weight: bold;
    }
    .event-time {
      font-size: 12px;
      color: #999;
    }
  </style>
</head>
<body>
  <h2>Simple Calendar</h2>
  
  <div id="calendar"></div>

  <script>
    // Function to handle event creation and storing in the database
    function createEvent(date) {
      var title = prompt('Enter the event title:');
      var paymentDue = prompt('Enter the monthly payment due date:');
      
      if (title && paymentDue) {
        var eventData = {
          title: title,
          date: date,
          paymentDue: paymentDue
        };
        
        // Send the eventData to the server using AJAX or fetch API
        fetch('create_event.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(eventData)
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Event created successfully!');
            renderCalendar();
          } else {
            alert('Failed to create event. Please try again.');
          }
        })
        .catch(error => {
          alert('An error occurred. Please try again.');
          console.error(error);
        });
      }
    }

    // Function to render the calendar based on the current month and year
    function renderCalendar() {
      var today = new Date();
      var year = today.getFullYear();
      var month = today.getMonth();
      
      var calendarElement = document.getElementById('calendar');
      var calendarHTML = '<table class="calendar">';
      
      // Header - Month and Year
      calendarHTML += '<tr><th colspan="7">' + getMonthName(month) + ' ' + year + '</th></tr>';
      
      // Days of the Week
      calendarHTML += '<tr>';
      calendarHTML += '<th>Sun</th>';
      calendarHTML += '<th>Mon</th>';
      calendarHTML += '<th>Tue</th>';
      calendarHTML += '<th>Wed</th>';
      calendarHTML += '<th>Thu</th>';
      calendarHTML += '<th>Fri</th>';
      calendarHTML += '<th>Sat</th>';
      calendarHTML += '</tr>';
      
      // Days of the Month
      var firstDay = new Date(year, month, 1).getDay();
      var daysInMonth = new Date(year, month + 1, 0).getDate();
      var dayCounter = 1;
      
      for (var row = 0; row < 6; row++) {
        calendarHTML += '<tr>';
        
        for (var col = 0; col < 7; col++) {
          if ((row === 0 && col < firstDay) || dayCounter > daysInMonth) {
            calendarHTML += '<td></td>';
          } else {
            var date = year + '-' + formatNumber(month + 1) + '-' + formatNumber(dayCounter);
            var eventHTML = getEventHTML(date);
            
            calendarHTML += '<td>';
            calendarHTML += '<strong>' + dayCounter + '</strong>';
            calendarHTML += eventHTML;
            calendarHTML += '</td>';
            
            dayCounter++;
          }
        }
        
        calendarHTML += '</tr>';
        
        if (dayCounter > daysInMonth) {
          break;
        }
      }
      
      calendarHTML += '</table>';
      
      calendarElement.innerHTML = calendarHTML;
    }
    
    // Function to get the name of the month
    function getMonthName(month) {
      var monthNames = [
        'January', 'February', 'March', 'April',
        'May', 'June', 'July', 'August',
        'September', 'October', 'November', 'December'
      ];
      
      return monthNames[month];
    }
    
    // Function to format the number with leading zero
    function formatNumber(number) {
      return ('0' + number).slice(-2);
    }
    
    // Function to get HTML for events on a specific date
    function getEventHTML(date) {
      var eventHTML = '';
      
      for (var i = 0; i < events.length; i++) {
        if (events[i].date === date) {
          eventHTML += '<div class="event">';
          eventHTML += '<div class="event-title">' + events[i].title + '</div>';
          eventHTML += '<div class="event-time">' + events[i].time + '</div>';
          eventHTML += '</div>';
        }
      }
      
      // Add a button to create events on the selected date
      eventHTML += '<button onclick="createEvent(\'' + date + '\')">Add Event</button>';
      
      return eventHTML;
    }
    
    // Render the calendar
    renderCalendar();
  </script>
</body>
</html>
