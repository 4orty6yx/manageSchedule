<?php
// Establish database connection
$conn = new mysqli('localhost', 'root', '', 'manages');

// Check connection
if ($conn->connect_error) {
    die('Failed to connect: ' . $conn->connect_error);
} else {
    // Query to fetch the next activity based on time
    $sql = "SELECT activity, date, time FROM activities WHERE date >= CURDATE() AND time >= CURTIME() ORDER BY date, time LIMIT 1";
    
    // Execute the query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of the next activity
        $row = $result->fetch_assoc();
        $activity = $row["activity"];
        $date = $row["date"];
        $time = $row["time"];
        
        // Close the database connection
        $conn->close();
    } else {
        $activity = "No upcoming activity";
        $date = "";
        $time = "";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>manageS.com</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


</head>
<body class="main" >

  <div class="container">

        <div class="header">
            
            <img src="logo.png" alt="Logo" class="logo">

     
        <div class="day-beauty" style="font-family:sans-serif;">
            <div id="currentDate"></div>
            <div id="currentTime" ></div>

          </div>

          <div class="ml-auto logout-icon">
            <a href="logout.html">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
         
    </div>



<!-- Form to capture activities, date, and time -->

<h1  style="color:lawngreen">add new activity</h1>
<hr>
<form  class="row" action="activities.php" method="POST">
  <div class="col-md-4">
      <div class="form-group">
          <label for="activity"><h2>Activity:</h2></label>
          <input type="text" class="form-control"  placeholder="Enter activity" name="activity" required>
      </div>
  </div>
  <div class="col-md-4">
      <div class="form-group">
          <label for="activityDate"><h2>Date:</h2></label>
          <input type="date" class="form-control" name="date" required>
      </div>
  </div>
  <div class="col-md-4">
      <div class="form-group">
          <label for="activityTime"><h2>Time:</h2></label>
          <input type="time" class="form-control" name="time" required>
      </div>
  </div>
  <div class="col-md-6">
      <button type="submit" class="btn btn-primary" onclick="showAlert()">Add Activity</button>
  </div>
</form>

<br>

<!-- generating a report of activities -->

<h1   style="color:lawngreen">Get Reports</h1>
<hr>
<form id="activityForm" class="row"  method="POST" action="gen_report.php" >
    <div class="col-md-4">
        <div class="form-group">
            <label for="startDate"><h2>Start Date:</h2></label>
            <input type="date" class="form-control" name="startDate" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="endDate"><h2>End Date:</h2></label>
            <input type="date" class="form-control" name="endDate" required>
        </div>
    </div>

    <div class="col-md-6">
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </div>
    
</form>


<br>

 <!-- Display upcoming activities and reminders -->
<h1  style="color:lawngreen">Next upcoming activity</h1>
<hr>
<div id="activityList">

<div  style="color:white;font-family: sans-serif;">
        <h4>Activity: <?php echo $activity; ?></h4>
        <h4>Date: <?php echo $date; ?></h4>
        <h4>Time: <?php echo $time; ?></h4>
        <h4 id="countdown"></h4>
    </div>
</div>


 </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    // Function to display current date
    function displayDate() {
      var currentDate = new Date().toLocaleDateString();
      $('#currentDate').text(currentDate);
    }

    // Function to display current time
    function displayTime() {
      var currentTime = new Date().toLocaleTimeString();
      $('#currentTime').text(currentTime);
    }

    // Call displayDate and displayTime functions on page load
    $(document).ready(function() {
      displayDate();
      displayTime();
      //interval to update time every second
      setInterval(displayTime, 1000);
    });

    // function do give an alert when new activity is added

    function showAlert() {
            alert("Activity added successfully!");
        }


        function updateCountdown() {
        var currentTime = new Date().getTime();
        var activityDateTime = new Date("<?php echo $date ?>T<?php echo $time ?>").getTime();
        var timeRemaining = activityDateTime - currentTime;

        var days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
        var hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

        document.getElementById("countdown").innerHTML = "Time remaining: " + days + " days, " + hours + " hours, " + minutes + " minutes, " + seconds + " seconds";

        // Update countdown every second
        setTimeout(updateCountdown, 1000);
    }

    // Call updateCountdown when the page loads
    window.onload = function() {
        updateCountdown(); // Start the countdown and check for popup
    };

</script>


  </script>
</body>
</html>
