<?php
require_once "../connections/connection.php";

// Check if the userid parameter is provided
if (isset($_GET["userid"])) {
    // Retrieve the userid from the URL parameter
    $userid = $_GET["userid"];
    
    // Perform the deletion query
    $sql = "DELETE FROM user WHERE UserID='$userid'";
    
    if (mysqli_query($conn, $sql)) {
        // Deletion successful
        echo "<script>
            location.href='dashboard.php';
            alert('Account deleted successfully.');
        </script>";
    } else {
        // Deletion failed
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    // If the userid parameter is not provided, handle the error appropriately
    echo "Invalid request.";
}

require_once "../connections/disconnection.php";
?>
