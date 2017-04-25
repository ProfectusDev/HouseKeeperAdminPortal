<?php
global $con;
include "config.php";
include "functions.php";

$id = protect($_POST['uid']);
debug_to_console("Removal Script Executing...");
$query_string = "DELETE * FROM Users WHERE (id = '" .$id. "')";
$res = mysqli_query($con, $query_string);
header("Location:userOnline.php");
?>