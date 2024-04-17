<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>activities</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body style="background-color:rgb(22, 75, 75);color:white">
<div class="container">

    <div class="header">
        
            <img src="logo.png" alt="Logo" class="logo">
    
    </div>
    
</div>
<br>
<center>
<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve start date and end date from the form
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'manages');
    if ($conn->connect_error) {
        die('Failed to connect: ' . $conn->connect_error);
    }
    // SQL query to retrieve activities between the selected dates
    $sql = "SELECT * FROM activities WHERE date BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if activities are found between the selected dates
    if ($result->num_rows > 0) {
        // Display activity report table if activities are found
        echo "<h2>Activity Report</h2>";
        echo "<br>";
        echo "<table border='1'>";
        echo "<tr><th><h3>Activity<h3></th><th><h3>Date<h3></th><th><h3>Time<h3></th><th><h3>Delete<h3></th></tr>";
        
        // Loop through the result set and display each activity
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["activity"]."</td><td>".$row["date"]."</td><td>".$row["time"]."</td>";
            echo "<td><button onclick=\"deleteActivity(".$row['id'].")\">Delete</button></td></tr>";
        }
        
        echo "</table>";
    } else {
        echo "<h2>No activities found between the selected dates.</h2>";
    }
    // Close database connection
    $conn->close();
}
?>
<br>

<form action="manageS.php" method="post">    
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">BACK</button>
    </div>
</form>
</center>

<script>
    function deleteActivity(id) {
        var confirmation = confirm("Are you sure you want to delete this activity?");
        if (confirmation) {
            // If the user confirms, redirect to a PHP script to handle the deletion
            window.location.href = "delete_activity.php?id=" + id;
        }
    }
</script>

</body>
</html>
