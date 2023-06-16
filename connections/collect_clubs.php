<?php
    require_once "connection.php";

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
            if (isset($_POST["available"])) {
                // Handle the "Available" button click
                if (isset($_POST["clubs"])) {
                    // Process the selected clubs
                    $selectedClubs = $_POST["clubs"];

                    // Access each selected club
                    foreach ($selectedClubs as $club) {
                        // Do something with the selected club (e.g., store in the database)
                        $sql = "UPDATE player SET Available = 'Yes' WHERE Club = '$club'";

                        if(mysqli_query($conn, $sql)){
                            echo "<script>alert('Selected club players are now available');</script>";
                        } else {
                            echo "Error updating availability: " . mysqli_error($conn);
                        }
                        echo "Selected club: " . $club . "<br>";
                    }
                } else {
                    echo "No clubs selected.";
                }
            } elseif (isset($_POST["unavailable"])) {
                // Handle the "Unavailable" button click
                // ...
                if (isset($_POST["clubs"])) {
                    // Process the selected clubs
                    $selectedClubs = $_POST["clubs"];

                    // Access each selected club
                    foreach ($selectedClubs as $club) {
                        // Do something with the selected club (e.g., store in the database)
                        $sql = "UPDATE player SET Available = 'No' WHERE Club = '$club'";

                        if(mysqli_query($conn, $sql)){
                            echo "<script>alert('Selected club players are now unavailable');</script>";
                        } else {
                            echo "Error updating availability: " . mysqli_error($conn);
                        }
                        echo "Selected club: " . $club . "<br>";
                    }
                } else {
                    echo "No clubs selected.";
                }
            } elseif (isset($_POST["add"])) {
                header("Location:../admin/add_player.php");
            } elseif (isset($_POST["remove"])) {
                // Handle the "Remove players" button click
                // ...
                if (isset($_POST["players"])) {
                    // Process the selected players
                    $selectedPlayers = $_POST["players"];

                    // Access each selected players
                    foreach ($selectedPlayers as $players) {
                        // Do something with the player id (e.g., store in the database)
                        $sql = "DELETE FROM player WHERE PlayerID = '$players'";

                        if(mysqli_query($conn, $sql)){
                            echo "<script>alert('Selected players have been deleted');</script>";
                        } else {
                            echo "Error deleting players: " . mysqli_error($conn);
                        }
                        echo "Selected players: " . $players . "<br>";
                    }
                } else {
                    echo "No players selected.";
                }
            }
        }
    }
?>
