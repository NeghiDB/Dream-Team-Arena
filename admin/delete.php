<?php
require_once "../connections/connection.php";

// Check if the userid parameter is provided
if (isset($_GET["userid"])) {
    // Retrieve the userid from the URL parameter
    $userid = $_GET["userid"];
    
    // Prepare the deletion query using a prepared statement
    $sql = "DELETE FROM user WHERE UserID = ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Bind the userid parameter
    $stmt->bind_param("i", $userid);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Deletion successful
        echo "<script>
            location.href='dashboard.php';
            alert('Account deleted successfully.');
        </script>";
    } else {
        // Deletion failed
        echo "Error: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();
} else {
    // If the userid parameter is not provided, handle the error appropriately
    echo "Invalid request.";
}

require_once "../connections/disconnection.php";
?>
