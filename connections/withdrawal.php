<?php
    require_once "connection.php";

    if(empty($_SESSION['userid'])){
        header("Location: ../index.html");
    }

    session_start();
    $userid = $_SESSION['userid'];
    $amount = $_GET["Amount"];

    // 1. Validate and sanitize user inputs
    $amount = filter_var($amount, FILTER_VALIDATE_FLOAT);
    if ($amount === false || $amount <= 0) {
        die("Invalid withdrawal amount.");
    }

    // 2. Prepare and execute a parameterized SELECT statement
    $sql = "SELECT * FROM user WHERE userid = ? AND amount >= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $userid, $amount);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // 3. Begin a transaction for multiple queries
        $conn->begin_transaction();

        // 4. Prepare and execute an UPDATE statement
        $sql1 = "UPDATE user SET amount = (amount - ?) WHERE UserID = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("di", $amount, $userid);
        $stmt1->execute();

        // 5. Prepare and execute an INSERT statement
        $sql2 = "INSERT INTO withdrawal(UserID, Amount) VALUES (?, ?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("id", $userid, $amount);
        $stmt2->execute();

        // 6. Commit the transaction
        $conn->commit();

        echo "<script>alert('Your account would be credited within 48 hours.');";
        echo "window.open('../withdrawal.html','_self');</script>";
    } else {
        echo "<script>alert('Insufficient Funds');";
        echo "window.open('../withdrawal.html','_self');</script>";
    }
    
    // 7. Close prepared statements and database connection
    $stmt->close();
    $stmt1->close();
    $stmt2->close();
    $conn->close();
?>
