<?php
require_once "connection.php";

if (isset($_POST["login"])){
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE Binary Email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        die('Query execution failed: ' . $stmt->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["Password"];

        if (password_verify($password, $hashedPassword)) {
            session_start();
            $_SESSION['userid'] = $row["UserID"];
            $_SESSION['username'] = $row["UserName"];
            $_SESSION['phonenumber'] = $row["PhoneNumber"];
            $_SESSION['email'] = $row["Email"];
            $_SESSION['amount'] = $row["Amount"];
            $_SESSION['plays'] = $row["Plays"];

            $stmt->close();

            header("Location:../home.php");
            exit;
        } else {
            echo "<script>alert('The email or password is incorrect');
            window.open('../login.html','_self');</script>";
        }
    }
    else {
        echo "<script>alert('The email or password does not exist');
        window.open('../login.html','_self');</script>";
    }

    $stmt->close();
}
elseif (isset($_POST["forgotpassword"])){
    $email = $_POST["email"];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE Binary Email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        die('Query execution failed: ' . $stmt->error);
    }

    if ($result->num_rows > 0) {
        $otp = rand(00000000,99999999);
        $updateSql = "UPDATE user SET OTP = '$otp' WHERE Email = '$email'";

        if (mysqli_query($conn, $updateSql)) {
            echo "<script>alert('A password reset link has been sent to your email');
                window.open('../forgotpassword.html','_self');</script>";
        }
        else {
            echo "Error: " . $updateSql . "<br>" . mysqli_error($conn);
        }

        /*
        the format of the mail would be
              users <OTP>
              link to reset page
        */
    }
    else {
        echo "<script>alert('The email does not exist');
        window.open('../forgotpassword.html','_self');</script>";
    }

    $stmt->close();
}
elseif (isset($_POST["resetpassword"])) {
    $email = $_POST["email"];
    $onetimepass = $_POST["onetimepass"];
    $password = $_POST["newpassword"];
    $confirmpassword = $_POST["confirmpassword"];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ? AND OTP = ?");
    $stmt->bind_param("ss", $email, $onetimepass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        if ($password === $confirmpassword) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $updateSql = "UPDATE user SET Password = ?, OTP = 0 WHERE Email = ? AND OTP = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("sss", $hashedPassword, $email, $onetimepass);

            if ($stmt->execute()) {
                echo "<script>alert('Your account password has been reset. You can log in now.');location.href='../login.html';</script>";
            } else {
                echo "Error updating password: " . $stmt->error;
            }
        } else {
            echo "<script>alert('The account passwords do not match'); location.href='../resetpassword.html';</script>";
        }
    } else {
        echo "<script>alert('Invalid email or OTP'); location.href='../resetpassword.html';</script>";
    }

    $stmt->close();
}

require_once "disconnection.php";
?>
