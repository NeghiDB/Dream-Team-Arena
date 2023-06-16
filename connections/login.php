<?php
require_once "connection.php";

if (isset($_POST["login"])){
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM user
        WHERE Binary Email='$email' AND Binary Password='$password'";

    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        die('Query execution failed: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['userid'] = $row["UserID"];
        $_SESSION['username'] = $row["UserName"];
        $_SESSION['phonenumber'] = $row["PhoneNumber"];
        $_SESSION['email'] = $row["Email"];
        $_SESSION['amount'] = $row["Amount"];
        $_SESSION['plays'] = $row["Plays"];
        
        header("Location:../home.php");
    }
    else {
        echo "<script>alert('The email or password does not exist');
        window.open('../login.html','_self');</script>";
    }
}
elseif (isset($_POST["forgotpassword"])){
    $email = $_POST["email"];
    
    $sql = "SELECT * FROM user
        WHERE Binary Email='$email'";

    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        die('Query execution failed: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $otp = rand(00000000,99999999);
        $sql1 = "UPDATE user SET OTP = '$otp' WHERE Email = '$email'";
        
        if (mysqli_query($conn, $sql1)) {
            echo "<script>alert('A password reset link has been sent to your mail');
                window.open('../forgotpassword.html','_self');</script>";
        }
        else {
            echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
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
}
elseif (isset($_POST["resetpassword"])) {
    $email = $_POST["email"];
    $onetimepass = $_POST["onetimepass"];
    $password = $_POST["newpassword"];
    $confirmpassword = $_POST["confirmpassword"];

    $sql = "SELECT * FROM user WHERE Email = '$email' AND OTP = '$onetimepass'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        if ($password === $confirmpassword) {
            $updateSql = "UPDATE user SET Password = '$password', OTP = 0 WHERE Email = '$email' AND OTP = '$onetimepass'";

            if (mysqli_query($conn, $updateSql)) {
                echo "<script>alert('Your account password has been reset. You can log in now.');location.href='../login.html';</script>";
            } else {
                echo "Error updating password: " . mysqli_error($conn);
            }
        } else {
            echo "<script>alert('The account passwords do not match'); location.href='../resetpassword.html';</script>";
        }
    } else {
        echo "<script>alert('Invalid email or OTP'); location.href='../resetpassword.html';</script>";
    }
}


require_once "disconnection.php";
?>