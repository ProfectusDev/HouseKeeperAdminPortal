<?php
$connection = mysqli_connect('45.55.183.86', 'root', 'jdcogsquad', 'Users');

if (!$connection) {
  die('Database Connection Failed' . mysql_error($connection));
}

?>
