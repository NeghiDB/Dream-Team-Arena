<?php
    require_once "connections/connection.php";
?>
<?php
    session_start();

    if(empty($_SESSION['userid'])){
        header("Location: index.html");
    }
    else{
        $userid = $_SESSION['userid'];
        $username = $_SESSION['username'];
        $amount = $_SESSION['amount'];
    }

echo'
<!DOCTYPE html>
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
</head>
<body id="body">
    <div class="menu" id="menu">
        <img src="images/DreamTeamArenaLogo.png">
        <hr>
        <ul class="menuul">
            <a href="home.php"><button class="linx" title="Home"><li><i class="fa-solid fa-house"></i> Home</li></button></a>
            <a href="matches.php"><button class="linx" title="Matches" id="active"><li><i class="fa-solid fa-scroll"></i> Matches</li></button></a>
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
            <button class="navlinx" title="Recommended Groups" id="active" disabled>Your Match</button>
        </nav>
        <span class="menubars" id="menubars" onclick="showMenu()"><img src="images/icons8-menu-24.png" alt="" srcset=""></span>
        <main>
            <br> <hr> <br>
            <span class="tablespan">
                <table>
                    <thead>
                        <th>Player Name</th>
                        <th>Points</th>
                        <th>Points</th>
                        <th>Player Name</th>
                    </thead>';
                
                    // Query to fetch home and away team players and points
                    $sql = "";
                    for ($i = 1; $i <= 11; $i++) {
                        $sql .= "SELECT h.FullName AS HomePlayerName, h.PlayerPoint AS HomePlayerPoint, a.FullName AS AwayPlayerName, a.PlayerPoint AS AwayPlayerPoint
                                FROM Matches AS m
                                JOIN Team AS ht ON m.HomeTeamID = ht.TeamID
                                JOIN Team AS at ON m.AwayTeamID = at.TeamID
                                JOIN Players AS h ON ht.PlayerID$i = h.PlayerID
                                JOIN Players AS a ON at.PlayerID$i = a.PlayerID
                                WHERE m.HomeTeamID = ht.TeamID
                                AND m.AwayTeamID = at.TeamID
                                AND (ht.OwnerID = $userid OR at.OwnerID = $userid)
                                ORDER BY m.MatchID DESC
                                LIMIT 1;";
                    }

                    $result2 = mysqli_multi_query($conn, $sql);
                    if ($result2 === false) {
                    die('Query execution failed: ' . mysqli_error($conn));
                    }

                    if (mysqli_more_results($conn)) {
                    $count = 0;
                    $totalHomePlayerPoints = 0;
                    $totalAwayPlayerPoints = 0;
                    do {
                        $count++;
                        if ($result = mysqli_store_result($conn)) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '
                                <tr>
                                    <td>' . $row['HomePlayerName'] . '</td>
                                    <td>' . $row['HomePlayerPoint'] . '</td>
                                    <td>' . $row['AwayPlayerPoint'] . '</td>
                                    <td>' . $row['AwayPlayerName'] . '</td>
                                </tr>';
                                $totalHomePlayerPoints += $row['HomePlayerPoint'];
                                $totalAwayPlayerPoints += $row['AwayPlayerPoint'];
                            }
                            mysqli_free_result($result);
                        }
                    } while (mysqli_next_result($conn));

                    if ($count === 0) {
                        echo "No matches found.";
                    }
                    } else {
                    echo "No matches found.";
                    }
            echo'
                </table>
            </span>
            <br> <hr> <br>
            <form action="" method="get">';
            $sql = "SELECT m.HomeTeamID, m.AwayTeamID, t.OwnerID, 
            (SELECT t1.TeamName FROM Team AS t1 WHERE m.HomeTeamID = t1.TeamID) AS HomeTeamName,
            (SELECT t2.TeamName FROM Team AS t2 WHERE m.AwayTeamID = t2.TeamID) AS AwayTeamName
            FROM Team AS t
            JOIN Matches AS m ON t.TeamID = m.HomeTeamID OR t.TeamID = m.AwayTeamID
            WHERE t.OwnerID = $userid
            ORDER BY m.MatchID DESC
            LIMIT 1";
    

                $result = mysqli_query($conn, $sql);
                if ($result === false) {
                    die('Query execution failed: ' . mysqli_error($conn));
                }

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<input type="submit" value="' . $row["HomeTeamName"] . ' : '.$totalHomePlayerPoints.'"> VS <input type="submit" name="opposition" value="' . $row["AwayTeamName"] . ' : '.$totalAwayPlayerPoints.'">';
                    }
                } else {
                    echo "No matches found.";
                }

                
            echo'
            </form>
        </main>
    </div>
    <script src="javascript/index.js"></script>
</body>
</html>';
?>