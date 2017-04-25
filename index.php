<?php

// checks and passes sessions
session_start();

// SECURITY FEATURE: keeps the output in an internal buffer
ob_start();

// connect to the database
global $con;

include "config.php";

// import utilities
include "functions.php";
?>

<html>
<head>
    <title>HouseKeeper Administrator Portal - Login</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="css/animate.css" />
    <link rel="icon" type="image.png" href="icon.png" />
</head>
<body>
<?php
debug_to_console("Login Page PHP script running");
// On form submission
if (isset($_POST['submit'])) {
    // protect the submitted values
    $email = protect($_POST['email']);
    $password = protect($_POST['password']);

    // Check for null values
    if (!$email || !$password) {
        // one or both do not exist, display an error message
        echo "You must enter a username and a password.";
    } else {
        // check the validity of the user
        $res = mysqli_query($con, "SELECT * FROM Users WHERE (email = '".$email."')");
        $num = mysqli_num_rows($res);
        // Check is there was a match
        if ($num == 0) {
            // If not...
            echo "The email you supplied is not linked to an account.";
        } else {
            // If there was a match, check email to password

            // select all rows where the email and password match the ones submitted
            $res = mysqli_query($con, "SELECT * FROM Users WHERE (email = '".$email."' AND password = '".$password."')");

            // get number of rows in result
            $num = mysqli_num_rows($res);
            
            // check si there was no match
            if ($num == 0) {
                // if not...
                echo "The password you supplied does not match the one for that email.";
            } else {
                // if there was, confirm that the account has administrator access
                $row = mysqli_fetch_assoc($res);
                if ($row['admin'] == 0) {
                    // if it does not
                    echo $email." does not have access to this portal";
                } else {
                    // if it passes the check
                    // Set the login session using the user id
                    $_SESSION['uid'] = $row['id'];

                    // show login confirmation
                    echo "You have successfully logged in";


                    // if a TIME TICKET was to be implemented, this is where that would be updated

                    // redirect to the usersonline page
                    // CHANGE THIS PARAMETER TO REFLECT THE LOCATION OF THE FORM
                    header('Location:userOnline.php');

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
        <form action="index.php" method="post">
            <div class="animated fadeInDown header">
                <p class="title">
<!--                    <img src="display-icon.png" height="25%" width="25%"/><br>-->
                    HouseKeeper
                </p>
            </div>
            <div class="input-container">
                <input class="input-fields" type="text" placeholder="email" name="email" required>
                <br />
                <input class="input-fields" type="password" placeholder="password" name="password" required>
                <br />
                <button class="button-fields animated fadeInUp" type="submit" name="submit" id="submit">Login</button><br>
                <div class="navlink_container">
                    <a class="navlink" href="register.php">Register</a><br>
                    <a class="navlink" href="forgot.php">Forgot Password?</a>
                </div>
            </div>
        </form>
    </div>
</div>
<!--<script>-->
<!--    var button = document.getElementById("register_nav");-->
<!--    button.addEventListener('click', function() {-->
<!--        document.location.href = 'register.php';-->
<!--    });-->
<!--</script>-->
</body>
</html>
<?php
// SECURITY FEATURE
// flush the output buffer and turn off output buffering
ob_end_flush();
?>
