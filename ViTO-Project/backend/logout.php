<?php
session_start(); // Start a new session or resume the existing session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session, clearing all session data
header("Location: login.php"); 
exit;
?>