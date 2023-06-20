<?php
    require_once "connection.php";

    session_start();

    if (isset($_SESSION['userid']) && isset($_GET['comments'])) {
        $userid = $_SESSION['userid'];
        $comments = $_GET['comments'];

        // Prepare the SQL statement to prevent SQL injection
        $sql = "INSERT INTO feedback (Text, UserID) 
                VALUES (?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $comments, $userid);
        
        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "<script>alert('Your feedback has been received.');location.href='../feedback.html';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Invalid request";
    }

    // Close the database connection
    $conn->close();
?>
