<?php
require_once "../connections/connection.php";

session_start();

if(empty($_SESSION['userid'])){
    header("Location: ../index.html");
}
else{
    $userid = $_SESSION['userid'];
    $username = $_SESSION['username'];
    $amount = $_SESSION['amount'];

    // Rest of the code for displaying the form
    echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
            integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="stylesheet" type="text/css" href="../styles/mainstyle.css">
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
            <script type="text/javascript" src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
            <title>Dream Team Arena</title>
        </head>
        <body id="body">
            <div class="menu" id="menu">
                <img src="../images/DreamTeamArenaLogo.png">
                <span class="menubars" id="closemenubars" onclick="hideMenu()"><img src="../images/icons8-close-24.png" alt="" srcset=""></span>
                <hr>
                <ul class="menuul">
                    <a href="users.php"><button class="linx" title="Users"><li><i class="fa-solid fa-user"></i> Users</li></button></a>
                    <a href="accounts.php"><button class="linx" title="Accounts"><li><i class="fa-solid fa-money-bill-transfer"></i> Accounts</li></button></a>
                    <a href="matches.html"><button class="linx" title="Matches"><li><i class="fa-solid fa-scroll"></i> Matches</li></button></a>
                </ul>
                <hr>
                <ul class="menuul">
                    <a href="teamsList.php"><button class="linx" title="Teams"><li><i class="fa-sharp fa-solid fa-people-group"></i> Teams</li></button></a>
                    <a href="playersList.php"><button class="linx" title="Players"><li><i class="fa-solid fa-person"></i> Players</li></button></a>
                </ul>
                <hr>
                <ul class="menuul">
                    <a href="notification.php"><button class="linx" title="Notification" id="active"><li><i class="fa-solid fa-bell"></i> Notifications</li></button></a>
                </ul>
                <hr>
                <ul class="menuul">
                    <a href="settings.php"><button class="linx" title="Settings"><li><i class="fa-solid fa-gear"></i> Settings</li></button></a>
                    <a href="../connections/logout.php"><button class="linx" title="Log out"><li><i class="fa-solid fa-right-from-bracket"></i> Log out</li></button></a>
                </ul>
            </div>';
}
?>
    <div class="maincontents">
        <span class="menubars" id="menubars" onclick="showMenu()"><img src="../images/icons8-menu-24.png" alt="" srcset=""></span><br>
        <main>
            <span class="tablespan">
                <!-- HTML form for downloading notifications -->
                <form action="../connections/notifications.php" method="POST"><br><br>
                    <input type="submit" name="withdrawal" value="Withdrawal" style="margin-bottom: 20px;"><br>
                    <input type="submit" name="feedback" value="Feedback" style="margin-bottom: 20px;"><br>
                    <input type="submit" name="otp" value="OTP" style="margin-bottom: 20px;"><br>
                </form>
            </span>
        </main>
    </div>
    <script src="../javascript/index.js"></script>
</body>
</html>