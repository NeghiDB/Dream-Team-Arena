<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dreamteamarena";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Set the character set
    $conn->set_charset("utf8");

    // Enable prepared statements for enhanced security
    $conn->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, true);
    $conn->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);

    // Close the connection at the end of the script
    register_shutdown_function(function() use ($conn) {
        if ($conn !== null) {
            $conn->close();
        }
    });
?>
