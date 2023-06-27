<?php
    require_once "connections/connection.php";

    session_start();

    if(empty($_SESSION['userid'])){
        header("Location: index.html");
    }
    else{
        $userid = $_SESSION['userid'];
        $username = $_SESSION['username'];
        $amount = $_SESSION['amount'];

        if($userid == 6){
            header("Location: admin/dashboard.php");
        }else{
            echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
                integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                <link rel="stylesheet" type="text/css" href="styles/mainstyle.css">
                <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
                <script type="text/javascript" src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
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
            <body id="body">
                <div class="menu" id="menu">
                    <img src="images/DreamTeamArenaLogo.png">
                    <span class="menubars" id="closemenubars" onclick="hideMenu()"><img src="images/icons8-close-24.png" alt="" srcset=""></span>
                    <hr>
                    <ul class="menuul">
                        <a href="home.php"><button class="linx" title="Home" id="active"><li><i class="fa-solid fa-house"></i> Home</li></button></a>
                        <a href="matches.php"><button class="linx" title="Matches"><li><i class="fa-solid fa-scroll"></i> Matches</li></button></a>
                        <a href="https://paystack.com/pay/yqfni0l88j"><button class="linx" title="Deposit"><li><i class="fa-solid fa-money-bill-transfer"></i> Deposit</li></button></a>
                    </ul>
                    <hr>
                    <ul class="menuul">
                        <a href="league.php"><button class="linx" title="League"><li><i class="fa-solid fa-users-rectangle"></i> League</li></button></a>
                    </ul>
                    <hr>
                    <ul class="menuul">
                        <a href="settings.php"><button class="linx" title="Settings"><li><i class="fa-solid fa-gear"></i> Settings</li></button></a>
                        <a href="help.html"><button class="linx" title="Help"><li><i class="fa-sharp fa-solid fa-circle-info"></i> Help</li></button></a>
                        <a href="feedback.html"><button class="linx" title="Feedback"><li><i class="fa-solid fa-comment"></i> Feedback</li></button></a>
                    </ul>
                    <hr>
                    <a href="withdrawal.html"><button type="submit" title="User"><i class="fa-solid fa-user"></i> '.$username.' '.$amount.'</button></a>
                    <ul class="menuul">
                        <a href="connections/logout.php"><button class="linx" title="Log out"><li><i class="fa-solid fa-right-from-bracket"></i> Log out</li></button></a>
                    </ul>
                </div>
                <div class="maincontents">
                    <nav>
                        <button class="navlinx" id="active" disabled>Team Details</button>
                    </nav>
                    <span class="menubars" id="menubars" onclick="showMenu()"><img src="images/icons8-menu-24.png" alt="" srcset=""></span>
                    <main>
                        <hr> <br> <br>
                        <span class="tablespan">
                            <table>
                                <thead>
                                    <th>S/N</th>
                                    <th>Player Name</th>
                                    <th>Club</th>
                                </thead>';
                                /*Trying to link up to the player list*/
                                    $sql = "SELECT a.FullName, a.Club 
                                    FROM players AS a 
                                    JOIN team AS b
                                    ON a.PlayerID = b.PlayerID1
                                    JOIN user AS c ON b.OwnerID = c.UserID 
                                    WHERE c.UserID = $userid;

                                    SELECT a.FullName, a.Club 
                                    FROM players AS a 
                                    JOIN team AS b
                                    ON a.PlayerID = b.PlayerID2
                                    JOIN user AS c ON b.OwnerID = c.UserID 
                                    WHERE c.UserID = $userid;
                                    
                                    SELECT a.FullName, a.Club 
                                    FROM players AS a 
                                    JOIN team AS b
                                    ON a.PlayerID = b.PlayerID3
                                    JOIN user AS c ON b.OwnerID = c.UserID 
                                    WHERE c.UserID = $userid;
                                    
                                    SELECT a.FullName, a.Club 
                                    FROM players AS a 
                                    JOIN team AS b
                                    ON a.PlayerID = b.PlayerID4
                                    JOIN user AS c ON b.OwnerID = c.UserID 
                                    WHERE c.UserID = $userid;

                                    SELECT a.FullName, a.Club 
                                    FROM players AS a 
                                    JOIN team AS b
                                    ON a.PlayerID = b.PlayerID5
                                    JOIN user AS c ON b.OwnerID = c.UserID 
                                    WHERE c.UserID = $userid;

                                    SELECT a.FullName, a.Club 
                                    FROM players AS a 
                                    JOIN team AS b
                                    ON a.PlayerID = b.PlayerID6
                                    JOIN user AS c ON b.OwnerID = c.UserID 
                                    WHERE c.UserID = $userid;

                                    SELECT a.FullName, a.Club 
                                    FROM players AS a 
                                    JOIN team AS b
                                    ON a.PlayerID = b.PlayerID7
                                    JOIN user AS c ON b.OwnerID = c.UserID 
                                    WHERE c.UserID = $userid;
                                    
                                    SELECT a.FullName, a.Club 
                                    FROM players AS a 
                                    JOIN team AS b
                                    ON a.PlayerID = b.PlayerID8
                                    JOIN user AS c ON b.OwnerID = c.UserID 
                                    WHERE c.UserID = $userid;
                                    
                                    SELECT a.FullName, a.Club 
                                    FROM players AS a 
                                    JOIN team AS b
                                    ON a.PlayerID = b.PlayerID9
                                    JOIN user AS c ON b.OwnerID = c.UserID 
                                    WHERE c.UserID = $userid;

                                    SELECT a.FullName, a.Club 
                                    FROM players AS a 
                                    JOIN team AS b
                                    ON a.PlayerID = b.PlayerID10
                                    JOIN user AS c ON b.OwnerID = c.UserID 
                                    WHERE c.UserID = $userid;
                                    
                                    SELECT a.FullName, a.Club 
                                    FROM players AS a 
                                    JOIN team AS b
                                    ON a.PlayerID = b.PlayerID11
                                    JOIN user AS c ON b.OwnerID = c.UserID 
                                    WHERE c.UserID = $userid;
                                    ";


                                    if ($conn->multi_query($sql)) {
                                        $resultSets = [];
                                        $resultIndex = 0;

                                        do {
                                            // Retrieve each result set
                                            if ($result = $conn->store_result()) {
                                                $resultSets[$resultIndex] = [];

                                                while ($row = $result->fetch_assoc()) {
                                                    // Process the rows
                                                    $resultSets[$resultIndex][] = $row;
                                                }

                                                $result->free();
                                            }

                                            $resultIndex++;
                                        } while ($conn->next_result());

                                        // Process the result sets
                                        $serialNumber = 1;
                                        foreach ($resultSets as $resultIndex => $resultSet) {
                                            foreach ($resultSet as $row) {
                                                // Process each row
                                                echo '<tr>
                                                    <td>' . $serialNumber . '</td>
                                                    <td>' . $row['FullName'] . '</td>
                                                    <td>' . $row['Club'] . '</td>
                                                </tr>';
                                                $serialNumber++;
                                            }
                                        }
                                    } else {
                                        echo "Error: " . $sql . "<br>" . $conn->error;
                                    }
                                echo'
                            </table>
                        </span>
                        <br><hr>
                        <form action="connections/players.php" method="post">
                            <input type="submit" name="play" value="Play" style="margin-right: 20px;">
                            <input type="submit" name="choose" value="Choose Player">
                        </form>
                    </main>
                </div>
                <script src="javascript/index.js"></script>
            </body>
            </html>
            ';
        }
    }
?>