<?php
    require_once "../connections/connection.php";

    if (isset($_POST["new"])){
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
                location.href='dashboard.php';
                alert('Account created successfully.');
                </script>";
            }
            elseif (mysqli_errno($conn)==1062){
                echo "<script>
                location.href='users.php';
                alert('The email, phone number or username has already being used');
                </script>";
            }
            else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }else{
            echo "<script>
            location.href='users.php';
            alert('The passwords don`t match');
            </script>";
        }
    }elseif (isset($_POST["update"])){
        $userid = $_POST["userid"];
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
            WHERE UserID = '$userid'";
            if (mysqli_query($conn, $sql)) {
                echo "<script>
                location.href='dashboard.php';
                alert('Account details updated successfully.');
                </script>";
            }
            elseif (mysqli_errno($conn)==1062){
                echo "<script>
                location.href='users.php';
                alert('The email, phone number or username has already being used');
                </script>";
            }
            else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }else{
            echo "<script>
            location.href='users.php';
            alert('The passwords don`t match');
            </script>";
        }
    }elseif (isset($_POST["delete"])){
        $userid = $_POST["userid"];
        $username = $_POST["username"]; 
        $email = $_POST["email"];
        $phone = $_POST["phonenumber"];
        
        //$sql = "DELETE FROM user WHERE UserID='$userid' OR UserName='$username' OR Email='$email' OR PhoneNumber='$phone'";
        
        echo '<script>
            var confirmation = confirm("Are you sure you want to delete the account?");
            if (confirmation) {
                location.href = "delete.php?userid=' . $userid . '";
            } else {
                location.href = "dashboard.php";
            }
        </script>';
    }
    

    require_once "../connections/disconnection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/regstyle.css">
    <title>Dream Team Arena</title>
</head>
<body>
    <div id="settingsDiv">
        <img src="../images/DreamTeamArenaLogo.png">
        <form action="users.php" method="post">
            <input type="text" name="userid" id="userId" placeholder="UserID">
            <input type="text" name="username" id="userName" placeholder="Username">
            <input type="email" name="email" id="email" placeholder="Email">
            <input type="tel" name="phonenumber" id="phonenumber" placeholder="Phone Number">
            <input type="text" name="accountnumber" id="accountNumber" placeholder="Enter Account Number">
            <input type="text" name="bankname" id="bankname" placeholder="Enter Bank Name">
            <input type="password" name="newpassword" id="newpassword" placeholder="Enter Password" maxlength="10" required>
            <input type="password" name="confpassword" id="confpassword" placeholder="Confirm Password" maxlength="10" required>
            <input style="margin-bottom: 2%;" type="submit" name="update" value="Update User">
            <input style="margin-bottom: 2%;" type="submit" name="delete" value="Delete User">
            <input type="submit" name="new" value="Create User">
        </form>
    </div>
</body>
</html>