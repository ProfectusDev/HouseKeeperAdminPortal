<?php
/**
 * Created by PhpStorm.
 * User: johnfiorentino
 * Date: 4/14/17
 * Time: 10:44 AM
 */

session_start();

global $con;

include 'config.php';
include 'functions.php';

?>
<html>
<head>
    <title>Forgot Password - HouseKeeper Administrator Web Portal</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="css/animate.css" />
    <link rel="icon" type="image.png" href="icon.png" />
</head>
<body>
<?php
echo '<script>console.log("Pre check...")</script>';
// check that the form has been submitted
if (isset($_POST['submit'])) {
    // if yes, continue checks
    // store the posted email and protect it
    $email = protect($_POST['email']);
    echo '<script>console.log("First Check...Passed!")</script>';
    // check to ensure that the form was completed
    if (!$email) {
        echo 'You must complete all required fields';
    } else {
        // check the format of the email
        $checkemail = "/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";

        if (!preg_match($checkemail, $email)) {
            // if not...
            echo 'Email not valid; must be of the form name@server.tld';
        }  else {
            // if it passes...
            // select all rows form the database where the emails match
            $res= mysqli_query($con, "SELECT * FROM Users WHERE email = '".$email."'");
            $num = mysqli_num_rows($res);

            // check that a match exists
            if ($num == 0) {
                // if not...
                echo 'An account with that email does not exist';
            } else {
                // otherwise, complete pass function
                $row = mysqli_fetch_assoc($res);

                // send email containing password to the user's email
                mail($email, 'Forgotten Password', "Here is your password for Access to the HouseKeeper Administrator Portal: ".$row['password'], 'From: noreply@johnfiorentino.xyz');
                echo 'An email containing your password has been sent to your recorded email address';

                header("Location: index.php");
            }
        }
    }

}
?>
<div id="wrapper">
    <?php include "navigation.html"; ?>
    <?php include "footer.html"; ?>
    <div class="input-holder">
        <div class="input-container">
            <form action="forgot.php" method="post">
                <input class="input-fields" type="text" name="email" placeholder="Email" required/><br>
                <button class="button-fields" type="submit" name="submit">Send Password</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
