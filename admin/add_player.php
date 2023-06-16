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

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Check if the form is submitted
        if (isset($_POST["addPlayer"])) {
            // Sanitize user input to prevent SQL injection
            $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
            $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
            $pos = mysqli_real_escape_string($conn, $_POST["pos"]);
            $club = mysqli_real_escape_string($conn, $_POST["club"]);
    
            // Validate user input (optional)
            // You can add validation rules here
    
            // Prepare the SQL statement using prepared statements
            $sql = "INSERT INTO player (FirstName, LastName, Position, Club) VALUES (?, ?, ?, ?);";
            $stmt = mysqli_prepare($conn, $sql);
    
            if ($stmt) {
                // Bind the parameters to the prepared statement
                mysqli_stmt_bind_param($stmt, "ssss", $fname, $lname, $pos, $club);
    
                // Execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    echo '<script>location.href="dashboard.php";alert("Player has been added");</script>';
                } else {
                    echo '<script>alert("Unable to add player: ' . mysqli_error($conn) . '");</script>';
                }
            } else {
                echo '<script>alert("Error in preparing the statement");</script>';
            }
    
            // Close the prepared statement
            mysqli_stmt_close($stmt);
        }
    }
    
}

require_once "../connections/disconnection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/regstyle.css">
    <title>Sign up</title>
</head>
<body>
    <div>
        <img src="../images/DreamTeamArenaLogo.png">
        <form action="add_player.php" method="post">
            <input type="text" name="fname" id="fname" placeholder="First Name" required>
            <input type="text" name="lname" id="lname" placeholder="Last Name" required>
            <select style="margin-top:5%;width:95%;height:50px;border:none;" name="pos" id="pos">
                <option value="GK">Goalkeeper</option>
                <option value="DEF">Defender</option>
                <option value="MID">Midfielder</option>
                <option value="FWD">Forward</option>
            </select>
            <input type="text" name="club" id="club" placeholder="Club" required>
            <input type="submit" name="addPlayer" value="Add Player">
        </form>
    </div>
</body>
</html>