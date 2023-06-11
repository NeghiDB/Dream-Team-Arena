<?php
    require_once "connection.php";

    session_start();
    $userid = $_SESSION['userid'];
    $amount = $_GET["Amount"];

    $sql = "SELECT * FROM user
            WHERE userid = '$userid'
            AND amount >= '$amount'";

    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        die('Query execution failed: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $sql1 = "UPDATE user SET amount = (amount - '$amount') WHERE UserID = '$userid';
                INSERT INTO withdrawal(UserID, Amount)
                VALUES ('$userid','$amount');";
        
        if (mysqli_multi_query($conn, $sql1)) {
            echo "<script>alert('Your account would be credited within 48 hours.');
                window.open('../withdrawal.html','_self');</script>";
        }
        else {
            echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
        }
    }
    else {
        echo "<script>alert('Insufficient Funds');
        window.open('../withdrawal.html','_self');</script>";
    }
?>