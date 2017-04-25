<?php
/**
 * Created by PhpStorm.
 * User: johnfiorentino
 * Date: 4/14/17
 * Time: 11:50 AM
 */
session_start();
global $con;

include 'config.php';
include 'functions.php';
?>
<html>
<head>
    <title>Users - HouseKeeper Administrator Portal</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="css/animate.css" />
    <link rel="icon" type="image.png" href="icon.png" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
</head>
<body>
<?php
// check to ensure the user is logged in
if (strcmp($_SESSION['uid'], "") == 0) {
    // display error
    echo 'You must be logged in to use this tool';
    header("Location: index.php");
} else {
    $time = date('U') + 50;

    // Check if anything has been passed to the $_GET
    if (isset($_POST['uid'])) {
        $id = protect($_POST['uid']);
        if ($id) {
            $qry = "DELETE FROM Users Where (id = '".$id."')";
            $res = mysqli_query($con, $qry);
        }
    }
}
?>
<div id="wrapper">
    <?php include "navigation.html"; ?>
    <?php include "footer.html"; ?>
    <div class="view_holder">
        <div class="view_field" id="table_holder">
<?php

$query_str = "SELECT * FROM Users WHERE (id != '" .$_SESSION['uid']. "')";
$results = mysqli_query($con, $query_str);
//$returns = array();
$index = 0;
//while ($row = mysqli_fetch_assoc($res)) {
//    $returns[$index] = $row;
//    $index+=1;
//}

if (mysqli_num_rows( $results ) > 0 )
?>

<table style="background-color: ghostwhite;" border="1" width="100%">
    <thead>
        <tr>
            <th>Email</th>
            <th>User ID</th>
            <th>Dream House ID</th>
            <th>Status</th>
            <th> </th>
        </tr>
    </thead>
    <tbody>
        <?php while( $result = mysqli_fetch_array($results) ) : ?>
        <tr>
            <td class="cell"><?php echo $result['email']; ?></td>
            <td class="cell"><?php echo $result['id']; ?></td>
            <td class="cell"><?php if ($result['dream hid'] != "") { echo $result['dream hid']; } else { echo "Dream House not Created"; } ?></td>
            <td class="cell"><?php if ($result['admin'] == 1) { echo "Administrator"; } else { echo "User"; } ?></td>
            <td class="cell">
                <form action="userOnline.php?uid='<?php echo $result['id']; ?>'" method="post">
                    <input type="hidden" name="uid" value="<?php echo $result['id']; ?>">
                    <input type="submit" name="submit" value="Delete">
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
        </div>
    </div>
</div>

</body>
</html>
