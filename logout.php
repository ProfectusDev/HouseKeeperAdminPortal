<?php
// Initialize the Session
session_start();

// Unset all of the session variables
$_SESSION = array();

// NOTE: In the event that cookies are ever manually used/adjusted in this system,
//  uncomment the following block of code.

//if (ini_get("session.use_cookies")) {
//  $params = session_get_cookie_params();
//  setcookie(session_name(), '', time() - 42000,
//    $params["path"], $params["domain"],
//    $params["secure"], $params["httponly"]
//  );
//}

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: index.php");
?>
