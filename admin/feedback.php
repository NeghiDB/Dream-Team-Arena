<?php
    require_once "../connections/connection.php";

    session_start();

    if(empty($_SESSION['userid'])){
        header("Location: index.html");
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
                    <a href="home.php"><button class="linx" title="Home"><li><i class="fa-solid fa-house"></i> Home</li></button></a>
                    <a href="matches.php"><button class="linx" title="Matches"><li><i class="fa-solid fa-scroll"></i> Matches</li></button></a>
                    <a href="../subscription.html"><button class="linx" title="Deposit"><li><i class="fa-solid fa-money-bill-transfer"></i> Deposit</li></button></a>
                </ul>
                <hr>
                <ul class="menuul">
                    <a href="league.php"><button class="linx" title="League"><li><i class="fa-solid fa-users-rectangle"></i> League</li></button></a>
                </ul>
                <hr>
                <ul class="menuul">
                    <a href="settings.php"><button class="linx" title="Settings"><li><i class="fa-solid fa-gear"></i> Settings</li></button></a>
                    <a href="../help.html"><button class="linx" title="Help"><li><i class="fa-sharp fa-solid fa-circle-info"></i> Help</li></button></a>
                    <a href="feedback.php"><button class="linx" title="Feedback" id="active"><li><i class="fa-solid fa-comment"></i> Feedbacks</li></button></a>
                </ul>
                <hr>
                <a href="withdrawal.html"><button type="submit" title="User"><i class="fa-solid fa-user"></i> '.$username.'</button></a>
                <ul class="menuul">
                    <a href="../connections/logout.php"><button class="linx" title="Log out"><li><i class="fa-solid fa-right-from-bracket"></i> Log out</li></button></a>
                </ul>
            </div>
            <div class="maincontents">
                <nav>
                    <button class="navlinx" id="active" disabled>Feedbacks</button>
                </nav>
                <span class="menubars" id="menubars" onclick="showMenu()"><img src="../images/icons8-menu-24.png" alt="" srcset=""></span>
                <main>
                    <hr> <br> <br>
                    <span class="tablespan">
                        <table>
                            <thead>
                                <th>Feedback ID</th>
                                <th>Date</th>
                                <th>Text</th>
                                <th>User ID</th>
                            </thead>';
                                $sql = "SELECT * from Feedback ORDER BY FeedbackID";

                                $result = $conn -> query($sql);
                                if ($result === false) {
                                    die('Query execution failed: ' . mysqli_error($conn));
                                }
                                
                                while ($row = mysqli_fetch_array($result)){
                                    echo'<tr>
                                        <td>'.$row["FeedbackID"].'</td>
                                        <td>'.$row["Date"].'</td>
                                        <td>'.$row["Text"].'</td>
                                        <td>'.$row["UserID"].'</td>
                                    </tr>';
                                }
                            echo'
                        </table>
                    </span>
                    <br><hr>
                    <form action="../connections/players.php" method="post">
                        <input type="submit" name="clearFeedback" value="Clear Feedback">
                    </form>
                </main>
            </div>
            <script src="../javascript/index.js"></script>
        </body>
        </html>
        ';
    }
?>