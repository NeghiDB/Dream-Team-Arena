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
                    <a href="notification.php"><button class="linx" title="Notifications"><li><i class="fa-solid fa-bell"></i> Notifications</li></button></a>
                    <!--<a href="feedback.php"><button class="linx" title="Feedback"><li><i class="fa-solid fa-comment"></i> Feedbacks</li></button></a>
                    <a href="withdrawal.php"><button class="linx" title="Feedback"><li><i class="fa-solid fa-comment"></i> Withdrawals</li></button></a>
                    <a href="otp.php"><button class="linx" title="Feedback"><li><i class="fa-solid fa-comment"></i> OTP</li></button></a>-->
                </ul>
                <hr>
                <ul class="menuul">
                    <a href="settings.php"><button class="linx" title="Settings"><li><i class="fa-solid fa-gear"></i> Settings</li></button></a>
                    <a href="../connections/logout.php"><button class="linx" title="Log out"><li><i class="fa-solid fa-right-from-bracket"></i> Log out</li></button></a>
                </ul>
            </div>
            <div class="maincontents">
                <nav>
                    <button class="navlinx" id="active" disabled>Admin Dashboard</button>
                </nav>
                <span class="menubars" id="menubars" onclick="showMenu()"><img src="../images/icons8-menu-24.png" alt="" srcset=""></span><br>
                <main id="payperplaymain">';
                    $sql = "SELECT COUNT(UserID) AS TotalUsers FROM user;
                    SELECT COUNT(MatchID) AS TotalMatches FROM Matches;
                    SELECT COUNT(FeedbackID) AS TotalFeedbacks FROM Feedback;
                    SELECT COUNT(WithdrawalID) AS TotalWithdrawal FROM Withdrawal;";
                   
                   if ($conn->multi_query($sql)) {
                       $results = array(); // Array to store the results
                       // Fetch each result set and store it in the array
                       do {
                           if ($result = $conn->store_result()) {
                               $results[] = $result->fetch_assoc();
                               $result->free();
                           }
                       } while ($conn->more_results() && $conn->next_result());
                   
                       // Display the counts
                       echo '<span id="help"><h1>Admin Dashboard</h1><br/>
                             <h2>Total Users: ' . $results[0]["TotalUsers"] . '</h2><br/>
                             <h2>Total Matches: ' . $results[1]["TotalMatches"] . '</h2><br/>
                             <h2>Total Feedback: ' . $results[2]["TotalFeedbacks"] . '</h2><br/>
                             <h2>Pending Withdrawal Requests: ' . $results[3]["TotalWithdrawal"] . '</h2><br/></span>';
                   } else {
                       die('Query execution failed: ' . $conn->error);
                   }
                   
            echo'</main>
                </div>
                <script src="../javascript/index.js"></script>
            </body>
        </html>';
    }
?>