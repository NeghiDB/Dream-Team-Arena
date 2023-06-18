<?php
    require_once "connection.php";

    session_start();
    $userid = $_SESSION['userid'];

    if (isset($_POST["signup"])){
        $email = $_POST["email"];
        $username = $_POST["username"];
        $phone = $_POST["phone"];
        $newpassword = $_POST["newpassword"];
        $confpassword = $_POST["confpassword"];

        // Validate inputs
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>
            location.href='../signup.html';
            alert('Invalid email format.');
            </script>";
            exit;
        }

        if ($newpassword !== $confpassword) {
            echo "<script>
            location.href='../signup.html';
            alert('The passwords don`t match.');
            </script>";
            exit;
        }

        // Hash the password
        $hashedPassword = password_hash($confpassword, PASSWORD_DEFAULT);

        // Prepare and execute a parameterized INSERT statement
        $stmt = $conn->prepare("INSERT INTO user (email, username, phonenumber, password)
                                VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $email, $username, $phone, $hashedPassword);
        if ($stmt->execute()) {
            echo "<script>
            location.href='../index.html';
            alert('Account created successfully.');
            </script>";
        } elseif ($conn->errno == 1062) {
            echo "<script>
            location.href='../signup.html';
            alert('The email, phone number, or username has already been used.');
            </script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST["update"])){
        $userid1 = $userid;
        $username = $_POST["username"]; 
        $email = $_POST["email"];
        $phone = $_POST["phonenumber"];
        $accountnumber = $_POST["accountnumber"];
        $bankname = $_POST["bankname"];
        $newpassword = $_POST["newpassword"];
        $confpassword = $_POST["confpassword"];

        // Validate inputs
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>
            location.href='../settings.php';
            alert('Invalid email format.');
            </script>";
            exit;
        }

        if ($newpassword !== $confpassword) {
            echo "<script>
            location.href='../settings.php';
            alert('The passwords don`t match.');
            </script>";
            exit;
        }

        // Hash the password
        $hashedPassword = password_hash($confpassword, PASSWORD_DEFAULT);

        // Prepare and execute a parameterized UPDATE statement
        $stmt = $conn->prepare("UPDATE user SET email = ?, username = ?, phonenumber = ?, password = ?, accountnumber = ?, bankname = ?
                                WHERE UserID = ?");
        $stmt->bind_param("ssssssi", $email, $username, $phone, $hashedPassword, $accountnumber, $bankname, $userid1);
        if ($stmt->execute()) {
            echo "<script>
            location.href='../settings.php';
            alert('Account details updated successfully.');
            </script>";
        } elseif ($conn->errno == 1062) {
            echo "<script>
            location.href='../settings.php';
            alert('The email, phone number, or username has already been used.');
            </script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    require_once "disconnection.php";
?>
