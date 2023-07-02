<?php
    require_once "connection.php";

    session_start();

    if (empty($_SESSION['userid'])) {
        header("Location: ../index.html");
        exit;
    } else {
        $userid = $_SESSION['userid'];
        $username = $_SESSION['username'];
        $amount = $_SESSION['amount'];

        if (isset($_POST["start"])) {
            $sql1 = "ALTER TABLE `user` DROP COLUMN `Plays`";
            $stmt1 = $conn->prepare($sql1);

            if ($stmt1->execute()) {
                $stmt1->close();

                $sql2 = "ALTER TABLE `user` ADD COLUMN `Plays` INT(11) DEFAULT 1";
                $stmt2 = $conn->prepare($sql2);

                if ($stmt2->execute()) {
                    $stmt2->close();

                    // Redirect with success message
                    header("Location: ../admin/dashboard.php?success=matches-started");
                    exit;
                } else {
                    // Log and display error message
                    error_log("Error starting matches: " . $stmt2->error);
                    header("Location: ../admin/dashboard.php?error=matches-start-failed");
                    exit;
                }
            } else {
                // Log and display error message
                error_log("Error starting matches: " . $stmt1->error);
                header("Location: ../admin/dashboard.php?error=matches-start-failed");
                exit;
            }

        } elseif (isset($_POST["end"])) {
            // Update the home team's account amount for result = 1
            $sql1 = "UPDATE `team` AS t
            JOIN (
                SELECT `TeamID`, SUM(`players`.`PlayerPoint`) AS `TotalPoints`
                FROM `players`
                JOIN `team` ON `players`.`playerid` IN (
                    `team`.`PlayerID1`, `team`.`PlayerID2`, `team`.`PlayerID3`, `team`.`PlayerID4`, 
                    `team`.`PlayerID5`, `team`.`PlayerID6`, `team`.`PlayerID7`, `team`.`PlayerID8`, 
                    `team`.`PlayerID9`, `team`.`PlayerID10`, `team`.`PlayerID11`
                )
                GROUP BY `TeamID`
            ) AS p ON t.`TeamID` = p.`TeamID`
            SET t.`Points` = p.`TotalPoints`";

            $stmt1 = $conn->prepare($sql1);

            if ($stmt1->execute()) {
            $stmt1->close();

            // Update the match results
            $sql2 = "UPDATE `matches`
                SET `Result` = (
                    SELECT CASE
                        WHEN `team1`.`Points` > `team2`.`Points` THEN 1
                        WHEN `team1`.`Points` < `team2`.`Points` THEN 2
                        ELSE 0
                    END
                    FROM (
                        SELECT `TeamID`, `Points`
                        FROM `team`
                        JOIN `matches`
                        WHERE `TeamID` = `matches`.`HomeTeamID`
                    ) AS `team1`
                    JOIN (
                        SELECT `TeamID`, `Points`
                        FROM `team`
                        JOIN `matches`
                        WHERE `TeamID` = `matches`.`AwayTeamID`
                    ) AS `team2`
                    ON 1 = 1
                )";

            $stmt2 = $conn->prepare($sql2);

            if ($stmt2->execute()) {
            $stmt2->close();

            // Update user statistics
            $sql3 = "UPDATE `user` AS u
                    SET u.Win = (
                        SELECT COUNT(*)
                        FROM `matches` AS m
                        INNER JOIN `team` AS t ON t.TeamID = m.HomeTeamID
                        WHERE t.OwnerID = u.UserID AND m.Result = 1
                    ) + (
                        SELECT COUNT(*)
                        FROM `matches` AS m
                        INNER JOIN `team` AS t ON t.TeamID = m.AwayTeamID
                        WHERE t.OwnerID = u.UserID AND m.Result = 2
                    ),
                    u.Loss = (
                        SELECT COUNT(*)
                        FROM `matches` AS m
                        INNER JOIN `team` AS t ON t.TeamID = m.HomeTeamID
                        WHERE t.OwnerID = u.UserID AND m.Result = 2
                    ) + (
                        SELECT COUNT(*)
                        FROM `matches` AS m
                        INNER JOIN `team` AS t ON t.TeamID = m.AwayTeamID
                        WHERE t.OwnerID = u.UserID AND m.Result = 1
                    ),
                    u.Draw = (
                        SELECT COUNT(*)
                        FROM `matches` AS m
                        INNER JOIN `team` AS t ON (t.TeamID = m.HomeTeamID OR t.TeamID = m.AwayTeamID)
                        WHERE t.OwnerID = u.UserID AND m.Result = 0
                    )";

            $stmt3 = $conn->prepare($sql3);

            if ($stmt3->execute()) {
            $stmt3->close();

            // Reset player IDs in team table
            $sql4 = "UPDATE `team` 
                        SET PlayerID1 = NULL, PlayerID2 = NULL, PlayerID3 = NULL, PlayerID4 = NULL, PlayerID5 = NULL, 
                            PlayerID6 = NULL, PlayerID7 = NULL, PlayerID8 = NULL, PlayerID9 = NULL, PlayerID10 = NULL, 
                            PlayerID11 = NULL";

            $stmt4 = $conn->prepare($sql4);

            if ($stmt4->execute()) {
                $stmt4->close();

                // Update the 'Plays' column in the 'user' table
                $sql5 = "ALTER TABLE `user` DROP COLUMN `Plays`";
                $stmt5 = $conn->prepare($sql5);

                if ($stmt5->execute()) {
                    $stmt5->close();

                    $sql6 = "ALTER TABLE `user` ADD COLUMN `Plays` INT(11) DEFAULT 0";
                    $stmt6 = $conn->prepare($sql6);

                    if ($stmt6->execute()) {
                        $stmt6->close();

                        // Generate and download CSV file
                        generateAndDownloadCSV($conn);

                        $sql7 = "TRUNCATE TABLE `matches` ";
                        $stmt7 = $conn->prepare($sql7);

                        if ($stmt7->execute()) {
                            $stmt7->close();

                            $sql8 = "TRUNCATE TABLE `team` ";
                            $stmt8 = $conn->prepare($sql8);

                            if ($stmt8->execute()) {
                                $stmt8->close();

                            } else {
                                // Log and display error message
                                error_log("Error ending matches: " . $stmt8->error);
                                header("Location: ../admin/dashboard.php?error=matches-end-failed");
                                exit;
                            }

                        } else {
                            // Log and display error message
                            error_log("Error ending matches: " . $stmt7->error);
                            header("Location: ../admin/dashboard.php?error=matches-end-failed");
                            exit;
                        }
                    } else {
                        // Log and display error message
                        error_log("Error ending matches: " . $stmt6->error);
                        header("Location: ../admin/dashboard.php?error=matches-end-failed");
                        exit;
                    }
                } else {
                    // Log and display error message
                    error_log("Error ending matches: " . $stmt5->error);
                    header("Location: ../admin/dashboard.php?error=matches-end-failed");
                    exit;
                }
            } else {
                // Log and display error message
                error_log("Error ending matches: " . $stmt4->error);
                header("Location: ../admin/dashboard.php?error=matches-end-failed");
                exit;
            }
            } else {
            // Log and display error message
            error_log("Error ending matches: " . $stmt3->error);
            header("Location: ../admin/dashboard.php?error=matches-end-failed");
            exit;
            }
            } else {
            // Log and display error message
            error_log("Error ending matches: " . $stmt2->error);
            header("Location: ../admin/dashboard.php?error=matches-end-failed");
            exit;
            }
            } else {
            // Log and display error message
            error_log("Error ending matches: " . $stmt1->error);
            header("Location: ../admin/dashboard.php?error=matches-end-failed");
            exit;
            }

        }
    }

    function generateAndDownloadCSV($conn) {
        // Connect to the database using PDO
        $dbhost = "localhost";
        $dbname = "sneakyco_dreamteamarena";
        $dbchar = "utf8";
        $dbuser = "sneakyco_dreamteamarena";
        $dbpass = "K=2oXF4Ft~Ce";

        try {
            $pdo = new PDO(
                "mysql:host=$dbhost;dbname=$dbname;charset=$dbchar",
                $dbuser, $dbpass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );

            // Create an empty CSV file
            $filename = "matches_result.csv";
            $fh = fopen($filename, "w");

            if ($fh === false) {
                error_log("Failed to create CSV file");
                header("Location: ../admin/dashboard.php?error=csv-creation-failed");
                exit;
            }

            // Define column headers for team table
            $teamHeaders = ['TeamID', 'TeamName', 'OwnerID', 'Points'];
            fputcsv($fh, $teamHeaders);

            // Get the team data from the database
            $teamStmt = $pdo->prepare("SELECT * FROM `team`");
            $teamStmt->execute();

            // Output the team data to the CSV file
            while ($teamRow = $teamStmt->fetch(PDO::FETCH_NAMED)) {
                fputcsv($fh, [
                    $teamRow['TeamID'], $teamRow['TeamName'], $teamRow['OwnerID'], $teamRow['Points']
                ]);
            }

            // Define column headers for matches table
            $matchesHeaders = ['MatchID', 'HomeTeamID', 'AwayTeamID', 'Result'];
            fputcsv($fh, $matchesHeaders);

            // Get the matches data from the database
            $matchesStmt = $pdo->prepare("SELECT * FROM `matches`");
            $matchesStmt->execute();

            // Output the matches data to the CSV file
            while ($matchesRow = $matchesStmt->fetch(PDO::FETCH_NAMED)) {
                fputcsv($fh, [
                    $matchesRow['MatchID'], $matchesRow['HomeTeamID'], $matchesRow['AwayTeamID'], $matchesRow['Result']
                ]);
            }

            // Close the CSV file
            fclose($fh);

            // Set headers to download the CSV file
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($filename));

            // Send the file to the browser for download
            readfile($filename);

            // Delete the CSV file from the server
            unlink($filename);
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            header("Location: ../admin/dashboard.php?error=database-connection-failed");
            exit;
        }
    }
?>
