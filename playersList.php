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


echo'<!DOCTYPE html>
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
            <a href="home.php"><button class="linx" title="Home" id="active"><li><i class="fa-solid fa-house"></i> Home</li></button></a>
            <a href="matches.php"><button class="linx" title="Matches"><li><i class="fa-solid fa-scroll"></i> Matches</li></button></a>
            <a href="subscription.html"><button class="linx" title="Deposit"><li><i class="fa-solid fa-money-bill-transfer"></i> Deposit</li></button></a>
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
    </div>';
?>
    <div class="maincontents">
        <span class="menubars" id="menubars" onclick="showMenu()"><img src="images/icons8-menu-24.png" alt="" srcset=""></span><br>
        <nav>
            <button class="navlinx" title="Recommended Groups" id="active" disabled>Choose Players</button>
        </nav>
        <main>
            <span class="tablespan">
                <!-- HTML form for selecting and swapping players -->
                <form action="connections/players.php" method="POST">
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Player Name</th>
                                <th title="Position">Pos.</th>
                                <th>Team Name</th>
                                <th>Opponent</th>
                                <th title="Goals Scored">GS</th>
                                <th title="Assists">A</th>
                                <th title="Yellow Card">YC</th>
                                <th title="Red Card">RC</th>
                                <th title="Clean Sheet">CS</th>
                                <th>Minute</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Retrieve player data from the database
                            $sql = "SELECT a.playerid, a.FullName, a.Club, a.Position, b.GoalsScored, b.Assists, b.YellowCards, b.RedCards, b.CleanSheet, b.Minute 
                            FROM players AS a
                            JOIN playerperformance AS b ON a.playerid = b.PlayerID
                            JOIN Player AS c ON a.playerid = c.playerid
                            WHERE c.available = 'Yes'";
                            $result = mysqli_query($conn, $sql);

                            // Generate rows for each player
                            while ($row = mysqli_fetch_assoc($result)) {
                                $playerID = $row['playerid'];
                                $playerName = $row['FullName'];
                                $teamName = $row['Club'];
                                $position = $row['Position'];
                                $gs = $row['GoalsScored'];
                                $asst = $row['Assists'];
                                $yc = $row['YellowCards'];
                                $rc = $row['RedCards'];
                                $cs = $row['CleanSheet'];
                                $min = $row['Minute'];

                                echo "<tr>
                                        <td><input type='checkbox' name='players[]' value='$playerID'></td>
                                        <td class='player-row'>$playerName</td>
                                        <td title='Position'>$position</td>
                                        <td>$teamName</td>
                                        <td>$position</td>
                                        <td title='Goals Scored'>$gs</td>
                                        <td title='Assists'>$asst</td>
                                        <td title='Yellow Card'>$yc</td>
                                        <td title='Red Card'>$rc</td>
                                        <td title='Clean Sheet'>$cs</td>
                                        <td>$min</td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <button type="submit" name="change">Choose Players</button>
                </form>
            </span>
        </main>
    </div>
    <script>
        // JavaScript code to handle player row selection
        var playerRows = document.getElementsByClassName("player-row");
        var selectedPlayers = 0;

        for (var i = 0; i < playerRows.length; i++) {
            playerRows[i].addEventListener("click", function() {
                var checkbox = this.parentNode.querySelector("input[type='checkbox']");

                if (selectedPlayers < 11 || checkbox.checked) {
                    checkbox.checked = !checkbox.checked;

                    if (checkbox.checked) {
                        selectedPlayers++;
                    } else {
                        selectedPlayers--;
                    }
                }
                else{
                    alert("You can't select more than 11 players.");
                }
            });
        }
    </script>
    <script src="javascript/index.js"></script>
</body>
</html>