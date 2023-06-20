<?php
    require_once "connections/connection.php";

    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/regstyle.css">
    <title>Dream Team Arena</title>
</head>
<body>
    <div id="settingsDiv">
        <img src="images/DreamTeamArenaLogo.png">
        <form action="connections/signup.php" method="post">
            <input type="text" name="userID" id="userID" placeholder="User ID: <?= $_SESSION['userid'] ?>" disabled>
            <input type="text" name="username" id="userName" placeholder="<?= $_SESSION['username'] ?>" required>
            <input type="email" name="email" id="email" placeholder="<?= $_SESSION['email'] ?>" required>
            <input type="tel" name="phonenumber" id="phonenumber" placeholder="<?= $_SESSION['phonenumber'] ?>" required>
            <input type="text" name="amount" id="amount" placeholder="Amount: <?= $_SESSION['amount'] ?>" disabled>
            <input type="text" name="accountnumber" id="accountNumber" placeholder="Enter Account Number">
            <input type="text" name="bankname" id="bankname" placeholder="Enter Bank Name">
            <input type="password" name="newpassword" id="newpassword" placeholder="Enter New Password" maxlength="10">
            <input type="password" name="confpassword" id="confpassword" placeholder="Confirm New Password" maxlength="10">
            <input type="submit" name="update" value="Update">
        </form>
    </div>
</body>
</html>
