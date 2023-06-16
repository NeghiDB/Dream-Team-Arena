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

        if($newpassword===$confpassword){
            $sql = "INSERT INTO user (email, username, phonenumber, password)
                VALUES ('$email', '$username', '$phone', '$confpassword')";
            if (mysqli_query($conn, $sql)) {
                echo "<script>
                location.href='../index.html';
                alert('Account created successfully.');
                </script>";
            }
            elseif (mysqli_errno($conn)==1062){
                echo "<script>
                location.href='../signup.html';
                alert('The email, phone number or username has already being used');
                </script>";
            }
            else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }else{
            echo "<script>
            location.href='../signup.html';
            alert('The passwords don`t match');
            </script>";
        }
    }elseif (isset($_POST["update"])){
        $userid1 = $userid;
        $username = $_POST["username"]; 
        $email = $_POST["email"];
        $phone = $_POST["phonenumber"];
        $accountnumber = $_POST["accountnumber"];
        $bankname = $_POST["bankname"];
        $newpassword = $_POST["newpassword"];
        $confpassword = $_POST["confpassword"];

        if($newpassword===$confpassword){
            $sql = "UPDATE user SET email = '$email', username = '$username', phonenumber = '$phone', password = '$confpassword',
            accountnumber='$accountnumber', bankname='$bankname'
            WHERE UserID = '$userid1'";
            if (mysqli_query($conn, $sql)) {
                echo "<script>
                location.href='../settings.php';
                alert('Account details updated successfully.');
                </script>";
            }
            elseif (mysqli_errno($conn)==1062){
                echo "<script>
                location.href='../settings.php';
                alert('The email, phone number or username has already being used');
                </script>";
            }
            else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }else{
            echo "<script>
            location.href='../settings.php';
            alert('The passwords don`t match');
            </script>";
        }
    }

    require_once "disconnection.php";
?>