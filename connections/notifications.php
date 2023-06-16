<?php

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Check if the form is submitted
        if (isset($_POST["withdrawal"])) {
            // Connect to the database
            $dbhost = "localhost";
            $dbname = "dreamteamarena";
            $dbchar = "utf8";
            $dbuser = "root";
            $dbpass = "";
            $pdo = new PDO(
                "mysql:host=$dbhost;dbname=$dbname;charset=$dbchar",
                $dbuser, $dbpass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );

            // Create an empty CSV file
            $fh = fopen("withdrawal.csv","w");
            if ($fh === false) {
                exit("Failed to create CSV file");
            }

            // Define column headers for team table
            $withdrawalHeaders = ['WithdrawalID', 'UserID', 'Amount', 'Date', 'Sent'];
            fputcsv($fh, $withdrawalHeaders);

            // Get the team data from the database
            $teamStmt = $pdo->prepare("SELECT * FROM Withdrawal");
            $teamStmt->execute();

            // Output the team data to the CSV file
            while ($teamRow = $teamStmt->fetch(PDO::FETCH_NAMED)) {
                fputcsv($fh, [
                    $teamRow['WithdrawalID'], $teamRow['UserID'], $teamRow['Amount'], $teamRow['Date'], $teamRow['Sent']
                ]);
            }

            // Close the CSV file
            fclose($fh);

            // Set headers to download the CSV file
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="withdrawal.csv"');
            header('Content-Length: ' . filesize('withdrawal.csv'));

            // Send the file to the browser for download
            readfile('withdrawal.csv');

            // Delete the CSV file from the server
            unlink('withdrawal.csv');
        }
        elseif (isset($_POST["feedback"])) {
            // Connect to the database
            $dbhost = "localhost";
            $dbname = "dreamteamarena";
            $dbchar = "utf8";
            $dbuser = "root";
            $dbpass = "";
            $pdo = new PDO(
                "mysql:host=$dbhost;dbname=$dbname;charset=$dbchar",
                $dbuser, $dbpass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );

            // Create an empty CSV file
            $fh = fopen("feedback.csv","w");
            if ($fh === false) {
                exit("Failed to create CSV file");
            }

            // Define column headers for team table
            $feedbackHeaders = ['FeedbackID', 'UserID', 'Text', 'Date'];
            fputcsv($fh, $feedbackHeaders);

            // Get the team data from the database
            $teamStmt = $pdo->prepare("SELECT * FROM Feedback");
            $teamStmt->execute();

            // Output the team data to the CSV file
            while ($teamRow = $teamStmt->fetch(PDO::FETCH_NAMED)) {
                fputcsv($fh, [
                    $teamRow['FeedbackID'], $teamRow['UserID'], $teamRow['Text'], $teamRow['Date']
                ]);
            }

            // Close the CSV file
            fclose($fh);

            // Set headers to download the CSV file
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="feedback.csv"');
            header('Content-Length: ' . filesize('feedback.csv'));

            // Send the file to the browser for download
            readfile('feedback.csv');

            // Delete the CSV file from the server
            unlink('feedback.csv');
        }
        elseif (isset($_POST["otp"])) {
            // Connect to the database
            $dbhost = "localhost";
            $dbname = "dreamteamarena";
            $dbchar = "utf8";
            $dbuser = "root";
            $dbpass = "";
            $pdo = new PDO(
                "mysql:host=$dbhost;dbname=$dbname;charset=$dbchar",
                $dbuser, $dbpass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );

            // Create an empty CSV file
            $fh = fopen("otp.csv","w");
            if ($fh === false) {
                exit("Failed to create CSV file");
            }

            // Define column headers for team table
            $otpHeaders = ['PhoneNumber', 'Email', 'OTP'];
            fputcsv($fh, $otpHeaders);

            // Get the team data from the database
            $teamStmt = $pdo->prepare("SELECT PhoneNumber, Email, OTP FROM User WHERE OTP > 0");
            $teamStmt->execute();

            // Output the team data to the CSV file
            while ($teamRow = $teamStmt->fetch(PDO::FETCH_NAMED)) {
                fputcsv($fh, [
                    $teamRow['PhoneNumber'], $teamRow['Email'], $teamRow['OTP']
                ]);
            }

            // Close the CSV file
            fclose($fh);

            // Set headers to download the CSV file
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="otp.csv"');
            header('Content-Length: ' . filesize('otp.csv'));

            // Send the file to the browser for download
            readfile('otp.csv');

            // Delete the CSV file from the server
            unlink('otp.csv');
        }
    }

?>