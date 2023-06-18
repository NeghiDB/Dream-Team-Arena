<?php
    require_once "connection.php";

    session_start();

    if(empty($_SESSION['userid'])){
        header("Location: ../index.html");
        exit();
    } else {
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

                    // Prepare the SQL statement using a prepared statement
                    $sql = "UPDATE player SET Available = 'Yes' WHERE Club = ?";

                    // Prepare the statement
                    $stmt = $conn->prepare($sql);

                    // Bind the parameter
                    $stmt->bind_param("s", $club);

                    // Access each selected club
                    foreach ($selectedClubs as $club) {
                        // Execute the statement
                        if ($stmt->execute()) {
                            echo "<script>alert('Selected club players are now available');</script>";
                        } else {
                            echo "Error updating availability: " . $stmt->error;
                        }
                        echo "Selected club: " . $club . "<br>";
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    echo "No clubs selected.";
                }
            } elseif (isset($_POST["unavailable"])) {
                // Handle the "Unavailable" button click
                if (isset($_POST["clubs"])) {
                    // Process the selected clubs
                    $selectedClubs = $_POST["clubs"];

                    // Prepare the SQL statement using a prepared statement
                    $sql = "UPDATE player SET Available = 'No' WHERE Club = ?";

                    // Prepare the statement
                    $stmt = $conn->prepare($sql);

                    // Bind the parameter
                    $stmt->bind_param("s", $club);

                    // Access each selected club
                    foreach ($selectedClubs as $club) {
                        // Execute the statement
                        if ($stmt->execute()) {
                            echo "<script>alert('Selected club players are now unavailable');</script>";
                        } else {
                            echo "Error updating availability: " . $stmt->error;
                        }
                        echo "Selected club: " . $club . "<br>";
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    echo "No clubs selected.";
                }
            } elseif (isset($_POST["add"])) {
                header("Location: ../admin/add_player.php");
                exit();
            } elseif (isset($_POST["remove"])) {
                // Handle the "Remove players" button click
                if (isset($_POST["players"])) {
                    // Process the selected players
                    $selectedPlayers = $_POST["players"];

                    // Prepare the SQL statement using a prepared statement
                    $sql = "DELETE FROM player WHERE PlayerID = ?";

                    // Prepare the statement
                    $stmt = $conn->prepare($sql);

                    // Bind the parameter
                    $stmt->bind_param("s", $playerId);

                    // Access each selected player
                    foreach ($selectedPlayers as $playerId) {
                        // Execute the statement
                        if ($stmt->execute()) {
                            echo "<script>alert('Selected players have been deleted');</script>";
                        } else {
                            echo "Error deleting players: " . $stmt->error;
                        }
                        echo "Selected player: " . $playerId . "<br>";
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    echo "No players selected.";
                }
            }
        }
    }
?>
