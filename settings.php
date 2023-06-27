<?php
    require_once "connections/connection.php";

    session_start();
    
    if(empty($_SESSION['userid'])){
        header("Location: index.html");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/regstyle.css">
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
