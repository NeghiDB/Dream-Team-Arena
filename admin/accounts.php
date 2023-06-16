<?php
require_once "../connections/connection.php";

if (isset($_POST["credit"])) {
    $userid = $_POST["userid"];
    $amount = $_POST["amount"];

    if ($userid == 'E') {
        $sql = "INSERT INTO accounts (UserID, TransactionType, Amount) VALUES (0, 'Credit', '$amount');
                UPDATE user SET amount = (amount + $amount);";
    } else {
        $sql = "INSERT INTO accounts (UserID, TransactionType, Amount) VALUES ('$userid', 'Credit', '$amount');
                UPDATE user SET amount = amount + $amount WHERE UserID = '$userid';";
    }

    if (mysqli_multi_query($conn, $sql)) {
        echo "<script>
            location.href='dashboard.php';
            alert('UserID $userid has been given $amount');
            </script>";
    } else {
        echo "<script>
            location.href='dashboard.php';
            alert('Error: ' . mysqli_error($conn));
            </script>";
    }
} elseif (isset($_POST["debit"])) {
    $userid = $_POST["userid"];
    $amount = $_POST["amount"];

    $sql = "UPDATE user SET amount = amount - $amount WHERE UserID = '$userid';
            INSERT INTO accounts (UserID, TransactionType, Amount) VALUES ('$userid', 'Debit', '$amount');";

    if (mysqli_multi_query($conn, $sql)) {
        echo "<script>
            location.href='dashboard.php';
            alert('UserID $userid has been deducted $amount');
            </script>";
    } else {
        echo "<script>
            location.href='dashboard.php';
            alert('Error: ' . mysqli_error($conn));
            </script>";
    }
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
