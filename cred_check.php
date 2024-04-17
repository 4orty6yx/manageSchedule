<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'manages');

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  // Get email and password from the form
  $email = $_POST["email"];
  $password = md5($_POST["password"]);//hashing the password entered using md5

  // Query to check if the credentials are correct
  $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
  $result = $conn->query($sql);

  // If user exists, grant access to manages.php
  if ($result->num_rows > 0) 
  {
    header("Location: manageS.php");
    exit;
    
  } else {
    header("Location: invalid_p.html");
    exit;
  }
}

// Close connection
$conn->close();
?>

    
</body>
</html>