<?php
    $servername = "localhost";
    $username = "sneakyco_dreamteamarena";
    $password = "K=2oXF4Ft~Ce";
    $dbname = "sneakyco_dreamteamarena";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }
    //echo "Connected successfully";
?>