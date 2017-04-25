<?php
/**
 * Created by PhpStorm.
 * User: johnfiorentino
 * Date: 4/14/17
 * Time: 12:29 AM
 */
session_start();

global $con;

include "config.php";
include "functions.php";
?>
<html>
<head>
    <title>HouseKeeper Web Portal - Account Registration</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="css/animate.css" />
    <link rel="icon" type="image.png" href="icon.png" />
</head>
<body>
<?php
debug_to_console("Registration Page PHP script running");
// check to see if the form has been submitted
if (isset($_POST['submit'])) {
    // protect and store the posted data
    $email = protect($_POST['email']);
    $password = protect($_POST['password']);
    $passconf = protect($_POST['passconf']);

    // check for empty fields
    if (!$email || !$password || !$passconf) {
        // if any weren't, display error message
        echo "You need to fill in all of the required fields";
    } else {
        // if they are all filled, continue

        //select all rows where the email matches the email stored
        $res = mysqli_query($con, "SELECT * FROM Users WHERE (email = '" .$email. "'");
        $num = mysqli_num_rows($res);
        if ($num == 1) {
            echo "An account with that email already exists";
        } else {
            // ensure that the email is the right format
            $checkEmail = "/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";
            if (!preg_match($checkEmail, $email)) {
                echo "Invalid email; must be of the format name@server.tld";
            } else if (strlen($email) <= 8 || strlen($email) >= 256) {
                echo "Invalid email; must be between 5 and 256 characters long";
            } else {
                // if the email is of the right format and lenght, check the password
                if (strlen($password) < 8 || strlen($password) > 32 ) {
                    // check the password length
                    echo "Invalid password; must be between 8 and 32 characters long";
                } else {
                    // check if the password and confirmed passwords match
                    if ($password != $passconf) {
                        echo "Passwords do not match";
                    } else {
                        // otherwise, register the account

                        // UNCOMMENT THe FOLLOWING BLOCK IF activation keys are being used
                        $registrationTime = date('U');
                        $code = md5($email).$registrationTime;

                        // set status variable for administrator privileges
                        $admin = 1;

                        $res2 = mysqli_query($con, "INSERT INTO Users (email,password,admin) VALUES ('".$email."','".$password."','".$admin."')");

                        // send an email contact to the owner of HouseKeeper for confirmation of admin privileges
                        // EDIT: the email address and website/domain will need to be changed if the server is uploaded to a new location
                        mail($email, $email.': confirm admin portal access', "The user listed at the email address " .$email." has requested
                        access to the HouseKeeper Admin Portal. If you approve of this request please activate the users account by clicking the following link. 
                        If the link does not work, please copy/paste it into your browser address bar. \n\nhttp://www.johnfiorentino.xyz/housekeeperadminportal/
                        activate.php?code=".$code, 'From: noreply@johnfiorentino.xyz');

                        // display the success message
                        echo "You have successfully registered! Upon approval from the owner, you will be granted administrator privileges and access to the portal!";

                        header("Location: index.php");
                    }
                }
            }
        }

    }
}
?>

<div id="wrapper">
    <?php include "navigation.html"; ?>
    <?php include "footer.html"; ?>
    <div class="input-holder">
        <form action="register.php" method="post">
            <div class="animated fadeInDown header">
                <p class="title">
                    Registration
                </p>
            </div>
            <div class="input-container">
                <input class="input-fields" type="text" name="email" placeholder="Email" required/><br>
                <input class="input-fields" type="password" name="password" placeholder="Password" required/><br>
                <input class="input-fields" type="password" name="passconf" placeholder="Confirm Password" required/><br>
                <button class="button-fields animated fadeInUp" type="submit" name="submit">Register</button>
                <div class="navlink_container">
                    <a class="navlink" href="index.php">Back to Login</a><br>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var button = document.getElementById("login_nav");
    button.addEventListener('click', function() {
        document.location.href = 'index.php';
    });
</script>
</body>
</html>
