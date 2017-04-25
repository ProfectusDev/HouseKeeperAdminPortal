<?php
/**
 * Created by PhpStorm.
 * User: johnfiorentino
 * Date: 4/14/17
 * Time: 10:15 AM
 */

session_start();

include "config.php";

include "functions.php";

?>
<html>
<head>
    <title>Account Activation - HouseKeeper Administrator Web Portal</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="css/animate.css" />
    <link rel="icon" type="image.png" href="icon.png" />
</head>
<body>
<?php
echo md5('other');

// before getting the code, protect it
$code = protect($_GET['code']);

// check for null values
if (!$code) {
    echo "There was an error activating your account";
} else {
    // ...continue...
    // select all inactive accounts
    $res = mysqli_query($con, "SELECT * FROM Users WHERE ('active' = '0')");
    while ($row = mysqli_fetch_assoc($res)) {
        // check if the code from the database matches the submitted code
        if ($code == md5($row['email']).$row['rtime']) {
            // if yes, activate the account and display success
            $res1 = mysqli_query($con, "UPDATE Users SET 'active' = '0' WHERE 'email' = '".$row['email']."'");
            echo 'Your account has been activated';
        }
    }
}
?>
</body>
</html>
