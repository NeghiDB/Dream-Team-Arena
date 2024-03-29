<?php
    require_once "connections/connection.php";
    session_start();

    if(empty($_SESSION['userid'])){
        header("Location: index.html");
        exit;
    }
?>

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
        <a href="withdrawal.html"><button type="submit" title="User"><i class="fa-solid fa-user"></i> <?= $_SESSION['username'] ?> <?= $_SESSION['amount'] ?></button></a>
        <ul class="menuul">
            <a href="connections/logout.php"><button class="linx" title="Log out"><li><i class="fa-solid fa-right-from-bracket"></i> Log out</li></button></a>
        </ul>
    </div>
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
                                <th>Check</th>
                                <th>Player Name</th>
                                <th title="Position">Pos.</th>
                                <th>Team Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Retrieve player data from the database
                            $sql = "SELECT a.playerid, a.FullName, a.Club, a.Position, b.GoalsScored, b.Assists, b.YellowCards, b.RedCards, b.CleanSheet, b.Minute 
                            FROM players AS a
                            JOIN playerperformance AS b ON a.playerid = b.PlayerID
                            JOIN player AS c ON a.playerid = c.playerid
                            WHERE c.available = 'Yes'";
                            $result = mysqli_query($conn, $sql);

                            // Generate rows for each player
                            while ($row = mysqli_fetch_assoc($result)) {
                                $playerID = $row['playerid'];
                                $playerName = $row['FullName'];
                                $teamName = $row['Club'];
                                $position = $row['Position'];

                                echo "<tr>
                                        <td><input type='checkbox' name='players[]' value='$playerID'></td>
                                        <td class='player-row'>$playerName</td>
                                        <td title='Position'>$position</td>
                                        <td>$teamName</td>
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