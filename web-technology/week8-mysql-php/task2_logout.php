<?php
// -- Logout: destroy session and redirect to login
session_start();
session_destroy(); // Clears all session data
header("Location: task2_login.php");
exit;
?>