<?php
require_once "../connections/connection.php";

if (isset($_POST["credit"])) {
    $userid = $_POST["userid"];
    $amount = $_POST["amount"];

    if ($userid == 'E') {
        $sql = "INSERT INTO accounts (UserID, TransactionType, Amount) VALUES (0, 'Credit', ?);
                UPDATE user SET amount = (amount + ?);";
    } else {
        $sql = "INSERT INTO accounts (UserID, TransactionType, Amount) VALUES (?, 'Credit', ?);
                UPDATE user SET amount = amount + ? WHERE UserID = ?;";
    }

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters
    if ($userid == 'E') {
        $stmt->bind_param("dd", $amount, $amount);
    } else {
        $stmt->bind_param("sdds", $userid, $amount, $amount, $userid);
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
            location.href='dashboard.php';
            alert('UserID $userid has been given $amount');
        </script>";
    } else {
        echo "<script>
            location.href='dashboard.php';
            alert('Error: ' . $stmt->error);
        </script>";
    }

    // Close the statement
    $stmt->close();
} elseif (isset($_POST["debit"])) {
    $userid = $_POST["userid"];
    $amount = $_POST["amount"];

    $sql = "UPDATE user SET amount = amount - ? WHERE UserID = ?;
            INSERT INTO accounts (UserID, TransactionType, Amount) VALUES (?, 'Debit', ?);";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters
    $stmt->bind_param("dsss", $amount, $userid, $userid, $amount);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
            location.href='dashboard.php';
            alert('UserID $userid has been deducted $amount');
        </script>";
    } else {
        echo "<script>
            location.href='dashboard.php';
            alert('Error: ' . $stmt->error);
        </script>";
    }

    // Close the statement
    $stmt->close();
}

require_once "../connections/disconnection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/regstyle.css">
    <title>Dream Team Arena</title>
</head>

<body>
    <div id="settingsDiv">
        <img src="../images/DreamTeamArenaLogo.png">
        <form action="accounts.php" method="post">
            <input type="text" name="userid" id="userId" placeholder="UserID" required>
            <input type="text" name="amount" id="amount" placeholder="Amount" required>
            <input style="margin-bottom: 2%;" type="submit" name="credit" value="Credit User">
            <input type="submit" name="debit" value="Debit User">
        </form>
    </div>
</body>

</html>
