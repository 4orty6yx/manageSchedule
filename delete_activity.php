<?php
// Check if the activity ID is provided in the URL
if (isset($_GET['id'])) {
    // Retrieve the activity ID from the URL
    $activityId = $_GET['id'];
    
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'manages');
    if ($conn->connect_error) {
        die('Failed to connect: ' . $conn->connect_error);
    }
    
    // SQL query to delete the activity with the given ID
    $sql = "DELETE FROM activities WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $activityId);
    
    // Execute the delete query
    if ($stmt->execute()) {
        // Redirect back to the activity report page after deletion
        header("Location: gen_report.php");
        exit();
    } else {
        echo "Error deleting activity: " . $conn->error;
    }
    
    // Close database connection
    $conn->close();
} else {
    echo "Activity ID not provided.";
}
?>
