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
                <hr>
                <ul class="menuul">
                    <a href="users.php"><button class="linx" title="Users"><li><i class="fa-solid fa-user"></i> Users</li></button></a>
                    <a href="accounts.php"><button class="linx" title="Accounts"><li><i class="fa-solid fa-money-bill-transfer"></i> Accounts</li></button></a>
                    <a href="matches.html"><button class="linx" title="Matches"><li><i class="fa-solid fa-scroll"></i> Matches</li></button></a>
                </ul>
                <hr>
                <ul class="menuul">
                    <a href="teamsList.php"><button class="linx" title="Teams"><li><i class="fa-sharp fa-solid fa-people-group"></i> Teams</li></button></a>
                    <a href="playersList.php"><button class="linx" title="Players" id="active"><li><i class="fa-solid fa-person"></i> Players</li></button></a>
                </ul>
                <hr>
                <ul class="menuul">
                    <a href="notification.php"><button class="linx" title="Notifications"><li><i class="fa-solid fa-bell"></i> Notifications</li></button></a>
                </ul>
                <hr>
                <ul class="menuul">
                    <a href="settings.php"><button class="linx" title="Settings"><li><i class="fa-solid fa-gear"></i> Settings</li></button></a>
                    <a href="../connections/logout.php"><button class="linx" title="Log out"><li><i class="fa-solid fa-right-from-bracket"></i> Log out</li></button></a>
                </ul>
            </div>';}
?>
    <div class="maincontents">
        <span class="menubars" id="menubars" onclick="showMenu()"><img src="../images/icons8-menu-24.png" alt="" srcset=""></span><br>
        <nav>
            <button class="navlinx" title="Players List" id="active" disabled>Players List</button>
        </nav>
        <main>
            <span class="tablespan">
                <!-- HTML form for showing players list -->
                <form action="../connections/collect_clubs.php" method="POST">
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Player Name</th>
                                <th title="Position">Pos.</th>
                                <th>Team Name</th>
                            </tr>
                        </thead>
                        <form action="../connections/collect_clubs.php" method="post">
                        <tbody>
                            <?php
                            // Retrieve player data from the database
                            $sql = "SELECT DISTINCT PlayerID, FullName, Club, Position 
                            FROM players 
                            ORDER BY Club, PlayerID ASC";
                            
                            $result = mysqli_query($conn, $sql);

                            // Generate rows for each player
                            while ($row = mysqli_fetch_assoc($result)) {
                                $playerID = $row['playerid'];
                                $playerName = $row['FullName'];
                                $position = $row['Position'];
                                $teamName = $row['Club'];

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
                    <br><hr>
                            <input type="submit" name="add" value="Add Players" style="margin-right: 20px;">
                            <input type="submit" name="remove" value="Remove Players">

                    <!--<button type="submit" name="add">Add Players</button>
                    <button type="submit" name="remove">Remove Players</button>-->
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

                if (selectedPlayers < 23 || checkbox.checked) {
                    checkbox.checked = !checkbox.checked;

                    if (checkbox.checked) {
                        selectedPlayers++;
                    } else {
                        selectedPlayers--;
                    }
                }
                else{
                    alert("You can't select more than 23 players.");
                }
            });
        }
    </script>
    <script src="../javascript/index.js"></script>
</body>
</html>
