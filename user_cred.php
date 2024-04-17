<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background-color:lawngreen;">
    
<?php

$username = $_POST['username'];
$email = $_POST['email'];
$password = md5($_POST['password']); // Hashing the password using MD5

// database connection
$conn = new mysqli('localhost', 'root', '', 'manages');
if ($conn->connect_error) {
    die('Failed to connect: ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();
    header("Location: login_r.html");
    $stmt->close();
    $conn->close();
    exit();
}
?>


</body>
</html>