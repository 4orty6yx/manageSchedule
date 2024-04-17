<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background-color:lawngreen;">
    
<?php

$activity = $_POST['activity'];
$date = $_POST['date'];
$time = $_POST['time'];

// database connection.
$conn = new mysqli('localhost', 'root', '', 'manages');
if ($conn->connect_error) {
    die('Failed to connect: ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO activities (activity, date, time) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $activity, $date, $time);
    $stmt->execute();
    header("Location: manageS.php");   
    $stmt->close();
    $conn->close();
    exit();
}
?>

</body>
</html>