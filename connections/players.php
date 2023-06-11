<?php
require_once "connection.php";

session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$amount = $_SESSION['amount'];
$plays = $_SESSION['plays'];
$x = 500;

if (isset($_POST["play"])) {
    if ($amount >= 500 && $plays < 1){
        $sql = "SELECT TeamID, OwnerID, PlayerID1, PlayerID2, PlayerID3, PlayerID4, PlayerID5, PlayerID6, PlayerID7, PlayerID8, PlayerID9, PlayerID10, PlayerID11
        FROM team
        WHERE OwnerID = $userid
        ORDER BY TeamID DESC
        LIMIT 1";

        $result = mysqli_query($conn, $sql);
        if ($result === false) {
            die('Query execution failed: ' . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            // Check if there is a row with a non-NULL HomeTeamID
            $checkSql = "SELECT COUNT(*) FROM Matches WHERE HomeTeamID IS NOT NULL AND AwayTeamID IS NULL";
            $checkResult = mysqli_query($conn, $checkSql);
            if ($checkResult === false) {
                die('Query execution failed: ' . mysqli_error($conn));
            }

            $rowCount = mysqli_fetch_row($checkResult)[0];

            if ($rowCount > 0) {
                $row = mysqli_fetch_assoc($result);
                $awayTeamID = $row['TeamID'];
                // Update the last row with the AwayTeamID
                $updateSql = "UPDATE Matches SET AwayTeamID = $awayTeamID WHERE AwayTeamID IS NULL";
                $updateResult = mysqli_query($conn, $updateSql);
                if ($updateResult === false) {
                    die('Query execution failed: ' . mysqli_error($conn));
                }
            } else {
                $row = mysqli_fetch_assoc($result);
                $homeTeamID = $row['TeamID'];
                $insertSql = "INSERT INTO Matches (HomeTeamID) VALUES ($homeTeamID)";
                $insertResult = mysqli_query($conn, $insertSql);
                if ($insertResult === false) {
                    die('Query execution failed: ' . mysqli_error($conn));
                }
            }

            if (mysqli_affected_rows($conn) > 0) {
                echo "<script>
                        location.href='../matches.php';
                        alert('You have been matched.');
                    </script>";
                $_SESSION['amount'] = $amount - 500;
                $_SESSION['plays'] = $plays + 1;
                $updateSql = "UPDATE User SET Amount = ($amount - 500) WHERE UserID = $userid;
                UPDATE User SET Plays = ($plays + 1) WHERE UserID = $userid;";
                $updateResult = mysqli_multi_query($conn, $updateSql);
                //session_reset();
                //session_abort();
            } else {
                echo "<script>
                        alert('No available slots for teams.');
                        window.open('../home.php','_self');
                    </script>";
            }
        } else {
            echo "<script>alert('You do not have a complete team yet.');
                window.open('../playersList.php','_self');</script>";
        }
    }
    elseif($plays > 0){
        echo "<script>alert('You have already been matched.');
        window.open('../home.php','_self');</script>";
    }
    else{
        echo "<script>alert('Insufficient funds. You need about 500 naira to play.');
        window.open('../home.php','_self');</script>";
    }
    
}
elseif (isset($_POST["choose"])) {
    echo "<script>window.open('../playersList.php','_self');</script>";
}
elseif (isset($_POST["addTeam"])) {
    echo "<script>window.open('../teamsList.php','_self');</script>";
}
elseif (isset($_POST["removeTeam"])) {
    echo "<script>window.open('../teamsList.php','_self');</script>";
}
elseif (isset($_POST["change"])) {
    $sql = "SELECT * FROM team WHERE OwnerID = $userid";
    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        die('Query execution failed: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        echo "<script>window.open('../home.php','_self');alert('You already have a team previously registered.');</script>";
    }
    else {
        $selectedPlayers = $_POST['players'];

        // Check if the number of selected players is not more than 11
        if (count($selectedPlayers) <= 11) {
            // Prepare the insert statement
            $insertStatement = "INSERT INTO team
                (teamname, ownerid, playerid1, playerid2, playerid3, playerid4, playerid5, playerid6, playerid7, playerid8, playerid9, playerid10, playerid11)
                SELECT ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?";
        
            // Prepare the insert query
            $insertQuery = $conn->prepare($insertStatement);
        
            // Check if the statement is prepared successfully
            if ($insertQuery === false) {
                die('Error preparing statement: ' . $conn->error);
            }

            // Specify the parameter types for bind_param
            $paramTypes = "si"; // Assuming teamname is a string and OwnerID is an integer
            $paramTypes .= "iiiiiiiiiii"; // Assuming the player IDs are integers

            // Create an array with parameter values
            $paramValues = array_merge(array($username, $userid), $selectedPlayers);

            // Bind the parameters to the insert query
            $bindResult = $insertQuery->bind_param($paramTypes, ...$paramValues);
        
            // Check if the binding is successful
            if ($bindResult === false) {
                //die('Error binding parameters: ' . $insertQuery->error);
                echo "<script>window.open('../playersList.php','_self');
                alert(`You haven't selected enough players.`);</script>";
            }
        
            // Execute the insert query
            if ($insertQuery->execute()) {
                echo "<script>alert('Players selected successfully.');</script>";
            } else {
                echo "Error inserting selected players: " . $insertQuery->error;
            }
        
            // Close the prepared statement
            $insertQuery->close();
            echo "<script>window.open('../home.php','_self');</script>";
        } else {
            echo "You can only select a maximum of 11 players.";
        }
    }
}
elseif (isset($_POST["clearFeedback"])) {
    $sql = "DELETE FROM Feedback";
    $result = $conn->query($sql);
    if ($result === false) {
        die('Query execution failed: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        echo "<script>window.open('../admin/feedback.php','_self');alert('Feedback successfully cleared.');</script>";
    }
    else {
        echo "<script>window.open('../admin/feedback.php','_self');alert('No feedback to clear.');</script>";
    }
}

require_once "disconnection.php";
?>