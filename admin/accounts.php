<?php
require_once "../connections/connection.php";

if (isset($_POST["credit"])) {
    $userid = $_POST["userid"];
    $amount = $_POST["amount"];

    if ($userid == 'E') {
        $sql1 = "INSERT INTO accounts (UserID, TransactionType, Amount) VALUES (0, 'Credit', ?)";
        $sql2 = "UPDATE user SET amount = (amount + ?)";
    } else {
        $sql1 = "INSERT INTO accounts (UserID, TransactionType, Amount) VALUES (?, 'Credit', ?)";
        $sql2 = "UPDATE user SET amount = amount + ? WHERE UserID = ?";
    }

    // Prepare the first statement
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("ds", $userid, $amount);

    // Execute the first statement
    $stmt1->execute();

    // Prepare the second statement
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("ds", $amount, $userid);

    // Execute the second statement
    $stmt2->execute();

    // Check if both statements were successful
    if ($stmt1->affected_rows > 0 && $stmt2->affected_rows > 0) {
        echo "<script>
            location.href='dashboard.php';
            alert('UserID $userid has been given $amount');
        </script>";
    } else {
        echo "<script>
            location.href='dashboard.php';
            alert('Error: ' . $conn->error);
        </script>";
    }

    // Close the statements
    $stmt1->close();
    $stmt2->close();
} elseif (isset($_POST["debit"])) {
    $userid = $_POST["userid"];
    $amount = $_POST["amount"];

    $sql1 = "UPDATE user SET amount = amount - ? WHERE UserID = ?";
    $sql2 = "INSERT INTO accounts (UserID, TransactionType, Amount) VALUES (?, 'Debit', ?)";

    // Prepare the first statement
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("ds", $amount, $userid);

    // Execute the first statement
    $stmt1->execute();

    // Prepare the second statement
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("ds", $userid, $amount);

    // Execute the second statement
    $stmt2->execute();

    // Check if both statements were successful
    if ($stmt1->affected_rows > 0 && $stmt2->affected_rows > 0) {
        echo "<script>
            location.href='dashboard.php';
            alert('UserID $userid has been deducted $amount');
        </script>";
    } else {
        echo "<script>
            location.href='dashboard.php';
            alert('Error: ' . $conn->error);
        </script>";
    }

    // Close the statements
    $stmt1->close();
    $stmt2->close();
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
    <meta name="description" content="Experience the ultimate fantasy football paradise at Dream Team Arena. Join us to unleash your skills and compete with fellow managers. Join the arena and take your fantasy football to the earning level!" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Dream Team Arena - Unleash Your Fantasy Footballing Potential" />
    <meta property="og:description" content="Experience the ultimate fantasy football paradise at Dream Team Arena. Join us to unleash your skills and compete with fellow managers. Join the arena and take your fantasy football to the earning level!" />
    <meta property="og:url" content="https://www.dreamteamarena.com/" />
    <meta property="og:site_name" content="Dream Team Arena" />
    <meta property="og:image" content="https://www.dreamteamarena.com/images/DreamTeamArenaLogo.png" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="Experience the ultimate fantasy football paradise at Dream Team Arena. Join us to unleash your skills and compete with fellow managers. Join the arena and take your fantasy football to the earning level!" />
    <meta name="twitter:title" content="Dream Team Arena - Unleash Your Fantasy Footballing Potential" />
    <link rel="icon" type="image/png" href="https://www.dreamteamarena.com/images/DreamTeamArenaLogo.png">
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
