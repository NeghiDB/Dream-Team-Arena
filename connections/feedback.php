<?php
    require_once "connection.php";

    session_start();
    $userid = $_SESSION['userid'];
    $comments = $_GET["comments"];

    $sql = "INSERT INTO Feedback (Text, UserID) 
            VALUES ('$comments', '$userid')";

    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        die('Query execution failed: ' . mysqli_error($conn));
    }

    if (mysqli_multi_query($conn, $sql)) {
        echo "<script>alert('Your feedback has been received.');location.href='../feedback.html';</script>";
    }
    else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
?>