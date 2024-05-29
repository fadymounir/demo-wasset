<?php
session_start();

// Unset the specific session variable
unset($_SESSION['USER_DETAILS']);

// Destroy all session variables
$_SESSION = array();

// Completely destroy the session
session_destroy();

// Redirect to index.php
header("location: ../index.php");
exit();
?>